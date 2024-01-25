<?php
include 'config.php';

// Function to show alerts and refresh the page
function showAlertAndRefresh($message)
{
    echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "'); window.location.href='Purchase.php';</script>";
}

// Handle product purchase form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addPurchase'])) {
    // Get the number of products added
    $numProducts = count($_POST['productName']);

    // Initialize total price for the entire purchase
    $totalPurchasePrice = 0;

    // Loop through each product
    for ($i = 0; $i < $numProducts; $i++) {
        // Get product details
        $productName = $conn->real_escape_string($_POST["productName"][$i]);
        $quantity = $conn->real_escape_string($_POST["quantity"][$i]);

        // Fetch unit price and total quantity for the selected product
        $fetchProductDetailsQuery = "SELECT ProductPrice, StockQuantity FROM Inventory WHERE ProductName = '$productName'";
        $result = $conn->query($fetchProductDetailsQuery);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Get additional details
            $unitPrice = $row['ProductPrice'];
            $totalQuantity = $row['StockQuantity'];

            // Calculate the total price for the current product
            $totalPrice = $unitPrice * $quantity;

            // Add the current product's total price to the overall purchase total
            $totalPurchasePrice += $totalPrice;

            // Calculate the remaining quantity after the purchase
            $remainingQuantity = $totalQuantity - $quantity;

            // Insert the purchase information into the transaction table
            $insertTransactionQuery = "INSERT INTO Transaction (ProductName, Type, UnitPrice, Quantity, TotalPrice) 
                                       VALUES ('$productName', 'purchase', '$unitPrice', '$quantity', '$totalPrice')";

            if ($conn->query($insertTransactionQuery) !== TRUE) {
                showAlertAndRefresh("Error purchasing product: " . $conn->error);
            }
        } else {
            showAlertAndRefresh("Error fetching product details: " . $conn->error);
        }
    }

    showAlertAndRefresh("Products purchased successfully! Total purchase price: $" . number_format($totalPurchasePrice, 2));
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
            <div class="container mt-5">
                <h4>Add Product to Purchase</h4>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
                <form method="POST" action="" class="mt-3">
                    <div class="row">
                        <div class="col-md-2">
                            <div id="productContainer">
                                <!-- Existing product input fields go here -->
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addPurchase">Add Purchase</button>
                </form>
            </div>

            <!-- Modal for adding a new product -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- New product input fields go here -->
                            <div class="mb-3">
                                <label for="newProductName" class="form-label">Product Name</label>
                                <select class="form-select" id="newProductName" name="newProductName" required onchange="saveSelectedProduct(this)">
                                    <option value="" selected disabled>Select a product</option>
                                    <?php
                                    // Fetch product names from the inventory table
                                    $fetchProductNamesQuery = "SELECT DISTINCT ProductName FROM Inventory";
                                    $result = $conn->query($fetchProductNamesQuery);

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['ProductName'] . "'>" . $row['ProductName'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <script>
                                // Define a JavaScript variable to store the selected product name
                                var selectedProduct = "";

                                // Function to save the selected product in the variable
                                function saveSelectedProduct(selectElement) {
                                    selectedProduct = selectElement.value;
                                    // You can use 'selectedProduct' in your JavaScript code or send it to the server using AJAX.
                                }
                            </script>

                            
                            <div class="mb-3">
                                <label for="UnitPrice" class="form-label">Unit Price</label>
                                <?php
                                $fetchProductPriceQuery = "SELECT DISTINCT ProductPrice FROM Inventory WHERE ProductName = 'selectedProduct'";
                                $result = $conn->query($fetchProductPriceQuery);
                                echo $result;
                                ?>
                                <input type="text" class="form-control" id="UnitPrice" name="UnitPrice" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="newTotalQuantity" class="form-label">Total Quantity</label>
                                <input type="text" class="form-control" id="newTotalQuantity" name="totalQuantity[]" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="newQuantity" class="form-label">Quantity</label>
                                <input type="text" class="form-control" id="newQuantity" name="quantity[]" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="addNewProduct()">Add Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <script>
        function addNewProduct() {
            // Get values from modal inputs
            var newProductName = document.getElementById('newProductName').value;
            var newUnitPrice = document.getElementById('newUnitPrice').value;
            var newTotalQuantity = document.getElementById('newTotalQuantity').value;
            var newQuantity = document.getElementById('newQuantity').value;

            // Create a new product container
            var productContainer = document.getElementById('productContainer');
            var newProductContainer = document.createElement('div');
            newProductContainer.className = 'mb-3';

            // Add input fields for the new product
            newProductContainer.innerHTML = `
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="productName[]" value="${newProductName}" readonly>
                <label for="unitPrice" class="form-label">Unit Price</label>
                <input type="text" class="form-control" name="unitPrice[]" value="${newUnitPrice}" readonly>
                <label for="totalQuantity" class="form-label">Total Quantity</label>
                <input type="text" class="form-control" name="totalQuantity[]" value="${newTotalQuantity}" readonly>
                <label for="quantity" class="form-label">Quantity</label>
                <input type="text" class="form-control" name="quantity[]" value="${newQuantity}" readonly>
            `;

            // Append the new product container to the existing products
            productContainer.appendChild(newProductContainer);

            // Close the modal
            $('#addProductModal').modal('hide');
        }

        function fetchProductDetails() {
            var selectedProduct = document.getElementById('newProductName').value;
            if (selectedProduct) {
                // Fetch unit price and total quantity from the inventory table using AJAX
                // Update the unit price and total quantity fields in the modal
                fetch('get_product_details.php?productName=' + selectedProduct)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('newUnitPrice').value = data.unitPrice;
                        document.getElementById('newTotalQuantity').value = data.totalQuantity;
                    })
                    .catch(error => {
                        console.error('Error fetching product details:', error);
                    });
            }
        }
    </script>
</body>

</html>