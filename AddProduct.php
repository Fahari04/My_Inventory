<?php
include 'config.php';

// Function to show alerts and refresh the page
function showAlertAndRefresh($message)
{
    echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "'); window.location.href='AllProduct.php';</script>";
}

// Handle new product form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addProduct'])) {
    $newProductName = $conn->real_escape_string($_POST["productName"]);
    $newProductPrice = $conn->real_escape_string($_POST["productPrice"]);
    $newCategoryName = $conn->real_escape_string($_POST["categoryName"]);
    $newSupplierName = $conn->real_escape_string($_POST["supplierName"]);
    $newStockQuantity = $conn->real_escape_string($_POST["stockQuantity"]);
    $newReorderLevel = 0;
    $newShelfLocation = $conn->real_escape_string($_POST["shelfLocation"]);
    $newLastRestockDate = $conn->real_escape_string($_POST["lastRestockDate"]);
    $newExpiryDate = $conn->real_escape_string($_POST["expiryDate"]);

    // Retrieve CategoryID based on CategoryName
    $getCategoryIDQuery = "SELECT CategoryID FROM Category WHERE CategoryName = '$newCategoryName'";
    $categoryIDResult = $conn->query($getCategoryIDQuery);
    $categoryIDRow = $categoryIDResult->fetch_assoc();
    $newCategoryID = $categoryIDRow['CategoryID'];

    // Retrieve SupplierID based on SupplierName
    $getSupplierIDQuery = "SELECT SupplierID FROM Supplier WHERE SupplierName = '$newSupplierName'";
    $supplierIDResult = $conn->query($getSupplierIDQuery);
    $supplierIDRow = $supplierIDResult->fetch_assoc();
    $newSupplierID = $supplierIDRow['SupplierID'];

    // Check if the product already exists
    $checkProductQuery = "SELECT * FROM Inventory WHERE ProductName = '$newProductName'";
    $existingProductResult = $conn->query($checkProductQuery);

    if ($existingProductResult->num_rows > 0) {
        // If the product exists, update it
        $updateQuery = "UPDATE Inventory SET 
            ProductPrice = '$newProductPrice',
            CategoryName = '$newCategoryName',
            SupplierName = '$newSupplierName',
            StockQuantity = '$newStockQuantity',
            ReorderLevel = '$newReorderLevel',
            ShelfLocation = '$newShelfLocation',
            LastRestockDate = '$newLastRestockDate',
            ExpiryDate = '$newExpiryDate'
            WHERE ProductName = '$newProductName'";

        if ($conn->query($updateQuery) === TRUE) {
            showAlertAndRefresh("Product updated successfully!");
        } else {
            showAlertAndRefresh("Error updating product: " . $conn->error);
        }
    } else {
        // If the product does not exist, insert it into the database
        $insertQuery = "INSERT INTO Inventory (ProductName, ProductPrice,CategoryName, SupplierName, StockQuantity, ReorderLevel, ShelfLocation, LastRestockDate, ExpiryDate) 
            VALUES ('$newProductName', '$newProductPrice','$newCategoryName', '$newSupplierName', '$newStockQuantity', '$newReorderLevel', '$newShelfLocation', '$newLastRestockDate', '$newExpiryDate')";

        if ($conn->query($insertQuery) === TRUE) {
            showAlertAndRefresh("New product added successfully!");
        } else {
            showAlertAndRefresh("Error adding product: " . $conn->error);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rYU79z8b3CzBXGAZ+R9MDd94R/RO/TFJ2ACa/i8FJQnJd1k1IKVMMsXa4JXAM1v2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        <?php
        include 'navbar.php';
        ?>
        <div class="main p-3 vh-100 overflow-hidden transition text-center">
            <div class="mb-4">
                <h4 class="mb-3">Add New Product</h4>
                <form method="POST" action="" class="needs-validation" novalidate>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" required>
                            <div class="invalid-feedback">
                                Please enter a product name.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="productPrice" class="form-label">Product Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" id="productPrice" name="productPrice" required>
                                <div class="invalid-feedback">
                                    Please enter a valid price.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <select class="form-select" id="categoryName" name="categoryName" required>
                                <?php
                                $fetchCategoriesQuery = "SELECT * FROM Category";
                                $categoriesResult = $conn->query($fetchCategoriesQuery);

                                while ($row = $categoriesResult->fetch_assoc()) {
                                    echo "<option value='" . $row['CategoryName'] . "'>" . $row['CategoryName'] . "</option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" name="categoryID" id="categoryID" value="">
                            <div class="invalid-feedback">
                                Please select a category.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="supplierName" class="form-label">Supplier Name</label>
                            <select class="form-select" id="supplierName" name="supplierName" required>
                                <?php
                                $fetchSuppliersQuery = "SELECT * FROM Supplier";
                                $suppliersResult = $conn->query($fetchSuppliersQuery);

                                while ($row = $suppliersResult->fetch_assoc()) {
                                    echo "<option value='" . $row['SupplierName'] . "'>" . $row['SupplierName'] . "</option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" name="supplierID" id="supplierID" value="">
                            <div class="invalid-feedback">
                                Please select a supplier.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="stockQuantity" class="form-label">Stock Quantity</label>
                            <input type="text" class="form-control" id="stockQuantity" name="stockQuantity" required>
                            <div class="invalid-feedback">
                                Please enter a valid stock quantity.
                            </div>
                        </div>
                        <!-- ReorderLevel excluded -->
                        <div class="col-md-6">
                            <label for="shelfLocation" class="form-label">Shelf Location</label>
                            <input type="text" class="form-control" id="shelfLocation" name="shelfLocation" required>
                            <div class="invalid-feedback">
                                Please enter a shelf location.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="lastRestockDate" class="form-label">Last Restock Date</label>
                            <input type="date" class="form-control" id="lastRestockDate" name="lastRestockDate" required>
                            <div class="invalid-feedback">
                                Please enter a valid last restock date.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="expiryDate" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="expiryDate" name="expiryDate" required>
                            <div class="invalid-feedback">
                                Please enter a valid expiry date.
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3" name="addProduct">Add Product</button>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

        <script>
            function updateCategoryID() {
                var categorySelect = document.getElementById("categoryName");
                var categoryIDInput = document.getElementById("categoryID");
                categoryIDInput.value = categorySelect.value;
            }

            function updateSupplierID() {
                var supplierSelect = document.getElementById("supplierName");
                var supplierIDInput = document.getElementById("supplierID");
                supplierIDInput.value = supplierSelect.value;
            }
        </script>
</body>

</html>