<?php
include 'config.php';

// Function to show alerts and refresh the page
function showAlertAndRefresh($message)
{
    echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "'); window.location.href='transaction.php';</script>";
}

// Handle product purchase form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addPurchase'])) {
    // Ensure purchase date is set
    if (!isset($_POST['purchaseDate']) || empty($_POST['purchaseDate'])) {
        showAlertAndRefresh("Please select a purchase date");
    }

    // Get purchase date from the form
    $purchaseDate = $conn->real_escape_string($_POST['purchaseDate']);

    // Initialize total price and total quantity for the entire purchase
    $totalPurchasePrice = 0;
    $totalQuantity = 0;

    // Loop through each product
    foreach ($_POST['productName'] as $index => $productName) {
        // Get product details
        $productName = $conn->real_escape_string($productName);
        $quantity = $conn->real_escape_string($_POST['quantity'][$index]);

        // Fetch unit price and total quantity for the selected product
        $fetchProductDetailsQuery = "SELECT ProductID, ProductPrice, StockQuantity FROM Inventory WHERE ProductName = '$productName'";
        $result = $conn->query($fetchProductDetailsQuery);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Get additional details
            $productId = $row['ProductID'];
            $unitPrice = $row['ProductPrice'];
            $totalProductQuantity = $row['StockQuantity'];
            // Calculate the total price for the current product
            $totalPrice = $unitPrice * $quantity;

            // Add the current product's total price to the overall purchase total
            $totalPurchasePrice += $totalPrice;

            // Add the current product's quantity to the overall purchase quantity
            $totalQuantity += $quantity;

            // Calculate the remaining quantity after the purchase
            $remainingQuantity = $totalProductQuantity - $quantity;

            // Update the product row with the deducted quantity
            $updateProductQuery = "UPDATE Inventory SET StockQuantity = '$remainingQuantity', ReorderLevel = ReorderLevel + '$quantity' WHERE ProductID = '$productId'";
            if ($conn->query($updateProductQuery) !== TRUE) {
                showAlertAndRefresh("Error updating product quantity: " . $conn->error);
            }

            // Insert the purchase information into the transaction table along with the date
            $insertTransactionQuery = "INSERT INTO Transaction (TransactionType, TotalQuantity, TransactionAmount, TransactionDate) 
                                       VALUES ('Sale', '$quantity', '$totalPrice', '$purchaseDate')";

            if ($conn->query($insertTransactionQuery) !== TRUE) {
                showAlertAndRefresh("Error inserting transaction information: " . $conn->error);
            }
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
    <title>Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rYU79z8b3CzBXGAZ+R9MDd94R/RO/TFJ2ACa/i8FJQnJd1k1IKVMMsXa4JXAM1v2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body class="bg-light">
    <div class="d-flex">
        <?php include 'navbar.php'; ?>
        <div class="main p-3 vh-100 overflow-hidden transition text-center">
            <div class="container mt-5 bg-white p-4 rounded shadow">
                <h4 class="mb-4">Add Product to Sale</h4>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
                <form method="POST" action="" class="mt-3">
                    <table class="table table-striped" id="productTable">
                        <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Total Quantity</th>
                                <th scope="col">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>Total Quantity:</strong>
                            <span id="totalQuantity" class="badge bg-primary">0</span>
                        </div>
                        <div class="col-md-6 text-end">
                            <strong>Total Amount:</strong>
                            <span id="totalAmount" class="badge bg-success">$0.00</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="mb-3">
                                <label for="purchaseDate" class="form-label">Sale Date</label>
                                <input type="date" class="form-control" id="purchaseDate" name="purchaseDate" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addPurchase">Add Sale</button>
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
                            <div class="mb-3">
                                <label for="newProductName" class="form-label">Product Name</label>
                                <select class="form-select" id="newProductName" name="newProductName" required onchange="fetchProductDetails()">
                                    <option value="" selected disabled>Select a product</option>
                                    <?php
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

                            <div class="mb-3">
                                <label for="newUnitPrice" class="form-label">Unit Price</label>
                                <input type="text" class="form-control" id="newUnitPrice" name="newUnitPrice" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="newTotalQuantity" class="form-label">Total Quantity</label>
                                <input type="text" class="form-control" id="newTotalQuantity" name="newTotalQuantity" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="newQuantity" class="form-label">Quantity</label>
                                <input type="text" class="form-control" id="newQuantity" name="newQuantity" required>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"
        integrity="sha384-E7J8oIpgiPf5jfaOfjhCpLcdXD1TjNBWr6b7F2S10Y1L0h3CQad/Ip63KbIvbL+Z"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyIx7Q4I3cxgP5+9TqWDj57f5C4b7pJd"
        crossorigin="anonymous"></script>    
        <script>
        var selectedProductName = "";

        function fetchProductDetails() {
            selectedProductName = document.getElementById('newProductName').value;
            if (selectedProductName) {
                fetch('get_product.php?productName=' + selectedProductName)
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

        function updateTotals(quantity, unitPrice) {
            var totalQuantityElement = document.getElementById('totalQuantity');
            var currentTotalQuantity = parseFloat(totalQuantityElement.innerHTML);
            totalQuantityElement.innerHTML = (currentTotalQuantity + quantity).toFixed(2);

            var totalAmountElement = document.getElementById('totalAmount');
            var currentTotalAmount = parseFloat(totalAmountElement.innerHTML.replace('$', ''));
            var newTotalAmount = currentTotalAmount + quantity * unitPrice;
            totalAmountElement.innerHTML = '$' + newTotalAmount.toFixed(2);
        }

        function addNewProduct() {
            var newProductName = document.getElementById('newProductName').value;
            var newUnitPrice = document.getElementById('newUnitPrice').value;
            var newTotalQuantity = document.getElementById('newTotalQuantity').value;
            var newQuantity = document.getElementById('newQuantity').value;

            // Call updateTotals to update total quantity and total amount
            updateTotals(parseFloat(newQuantity), parseFloat(newUnitPrice));

            // Create a new product row in the table
            var productTable = document.getElementById('productTable');
            var newRow = productTable.insertRow(-1);

            // Add cells to the new row
            var cellProductName = newRow.insertCell(0);
            var cellUnitPrice = newRow.insertCell(1);
            var cellTotalQuantity = newRow.insertCell(2);
            var cellQuantity = newRow.insertCell(3);

            // Set the content of each cell
            cellProductName.innerHTML = newProductName;
            cellUnitPrice.innerHTML = newUnitPrice;
            cellTotalQuantity.innerHTML = newTotalQuantity;
            cellQuantity.innerHTML = newQuantity;

            // Create hidden input fields for dynamically added rows
            var hiddenProductName = document.createElement('input');
            hiddenProductName.type = 'hidden';
            hiddenProductName.name = 'productName[]';
            hiddenProductName.value = newProductName;

            var hiddenQuantity = document.createElement('input');
            hiddenQuantity.type = 'hidden';
            hiddenQuantity.name = 'quantity[]';
            hiddenQuantity.value = newQuantity;

            // Append hidden input fields to the form
            document.forms[0].appendChild(hiddenProductName);
            document.forms[0].appendChild(hiddenQuantity);

            // Close the modal
            $('#addProductModal').modal('hide');
        }
    </script>

</body>

</html>