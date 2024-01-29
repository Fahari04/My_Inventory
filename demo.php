<?php
include 'config.php';

// Function to show alert and refresh the page
function showAlertAndRefresh($message)
{
    echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "'); window.location.href='customers.php';</script>";
}

// Handle new customer form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCustomer"])) {
    // Replace $conn with your database connection
    $newCustomerName = $conn->real_escape_string($_POST["customerName"]);
    $newContactInfo = $conn->real_escape_string($_POST["contactInfo"]);
    $newCustomerAddress = $conn->real_escape_string($_POST["customerAddress"]);

    // Check if the customer already exists
    $checkCustomerQuery = "SELECT * FROM Customer WHERE CustomerName = '$newCustomerName'";
    $existingCustomerResult = $conn->query($checkCustomerQuery);

    if ($existingCustomerResult->num_rows > 0) {
        showAlertAndRefresh("Customer with the name '$newCustomerName' already exists.");
    } else {
        // If the customer does not exist, insert into the database
        $insertCustomerQuery = "INSERT INTO Customer (CustomerName, ContactInfo, CustomerAddress) 
            VALUES ('$newCustomerName', '$newContactInfo', '$newCustomerAddress')";

        if ($conn->query($insertCustomerQuery) === TRUE) {
            showAlertAndRefresh("New customer added successfully!");
        } else {
            showAlertAndRefresh("Error adding customer: " . $conn->error);
        }
    }
}

// Handle remove customer by searching form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["removeCustomerSearchBtn"])) {
    // Replace $conn with your database connection
    $searchRemoveCustomerName = $conn->real_escape_string($_POST["searchRemoveCustomer"]);

    $deleteCustomerQuery = "DELETE FROM Customer WHERE CustomerName = '$searchRemoveCustomerName'";

    if ($conn->query($deleteCustomerQuery) === TRUE) {
        showAlertAndRefresh("Customer removed successfully! Deleted CustomerName: $searchRemoveCustomerName");
    } else {
        showAlertAndRefresh("Error removing customer: " . $conn->error);
    }
}
?>


<html>

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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="d-flex">
        <?php

        include 'navbar.php';
        ?>
        <div class="main p-3 vh-100 overflow-hidden transition text-center text-center">

        </div>

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ONm3paZlUd3zXasYtqXy5jtDGR5FHWdG1A9Omd+P3oqkfnbPf5lR2l5zF5VgeMDa" crossorigin="anonymous"></script>
</body>

</html>