<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "My_Inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

// Handle new customer form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCustomer"])) {
    $newCustomerName = $conn->real_escape_string($_POST["customerName"]);
    $newContactInfo = $conn->real_escape_string($_POST["contactInfo"]);
    $newCustomerAddress = $conn->real_escape_string($_POST["customerAddress"]);

    // Check if the customer already exists
    $checkCustomerQuery = "SELECT * FROM Customer WHERE CustomerName = '$newCustomerName'";
    $existingCustomerResult = $conn->query($checkCustomerQuery);

    if ($existingCustomerResult->num_rows > 0) {
        echo "<p class='alert alert-warning'>Customer with the name '$newCustomerName' already exists.</p>";
    } else {
        // If the customer does not exist, insert into the database
        $insertCustomerQuery = "INSERT INTO Customer (CustomerName, ContactInfo, CustomerAddress) 
                                VALUES ('$newCustomerName', '$newContactInfo', '$newCustomerAddress')";

        if ($conn->query($insertCustomerQuery) === TRUE) {
            echo "<p class='alert alert-success'>New customer added successfully!</p>";
        } else {
            echo "<p class='alert alert-danger'>Error adding customer: " . $conn->error . "</p>";
        }
    }
}

// Handle remove customer by searching form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["removeCustomerSearchBtn"])) {
    $searchRemoveCustomerName = $conn->real_escape_string($_POST["searchRemoveCustomer"]);

    $deleteCustomerQuery = "DELETE FROM Customer WHERE CustomerName = '$searchRemoveCustomerName'";

    if ($conn->query($deleteCustomerQuery) === TRUE) {
        echo "<p class='alert alert-success'>Customer removed successfully! Deleted CustomerName: $searchRemoveCustomerName</p>";
    } else {
        echo "<p class='alert alert-danger'>Error removing customer: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rYU79z8b3CzBXGAZ+R9MDd94R/RO/TFJ2ACa/i8FJQnJd1k1IKVMMsXa4JXAM1v2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            font-family: 'Ubuntu', sans-serif;
        }

        .mynav {
            color: #fff;
        }

        .mynav li a {
            color: #fff;
            text-decoration: none;
            width: 100%;
            display: block;
            border-radius: 5px;
            padding: 8px 5px;
        }

        .mynav li a.active {
            background: rgba(255, 255, 255, 0.2);
        }

        .mynav li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .mynav li a i {
            width: 25px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php include 'navbar.php'; ?>

            <div class="col-md-12">

                <div class="bg-light flex-fill">
                    <div class="p-2 d-md-none d-flex text-white bg-success">
                        <a href="#" class="text-success" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>

                    <div class="p-4">
                        <h4 class="mb-4">Customer Management</h4>

                        <!-- Search Form -->
                        <form class="mb-4" method="GET" action="">
                            <div class="input-group">
                                <input type="search" class="form-control" placeholder="Search by Customer Name" aria-label="Search" name="search">
                                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>

                        <!-- Search Results -->
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
                            $searchTerm = $conn->real_escape_string($_GET["search"]);
                            $searchQuery = ("SELECT * FROM Customer WHERE CustomerName LIKE '%$searchTerm%'");
                            $searchResult = $conn->query($searchQuery);

                            if ($searchResult->num_rows > 0) {
                                echo "<h6 class='mb-3'>Search Results:</h6>";
                                echo "<table class='table'>";
                                echo "<thead><tr><th>CustomerID</th><th>CustomerName</th><th>ContactInfo</th><th>CustomerAddress</th></thead>";
                                echo "<tbody>";

                                while ($row = $searchResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['CustomerID'] . "</td>";
                                    echo "<td>" . $row['CustomerName'] . "</td>";
                                    echo "<td>" . $row['ContactInfo'] . "</td>";
                                    echo "<td>" . $row['CustomerAddress'] . "</td>";
                                    echo "</tr>";
                                }

                                echo "</tbody></table>";
                            } else {
                                echo "<p class='alert alert-info'>No results found for the search term: $searchTerm</p>";
                            }
                        }
                        ?>

                        <!-- Full Customer Table -->
                        <?php
                        $fullTableQuery = "SELECT * FROM Customer";
                        $fullTableResult = $conn->query($fullTableQuery);

                        if ($fullTableResult->num_rows > 0) {
                            echo "<h6 class='mb-3'>Full Customer Table:</h6>";
                            echo "<table class='table'>";
                            echo "<thead><tr><th>CustomerID</th><th>CustomerName</th><th>ContactInfo</th><th>CustomerAddress</th></thead>";
                            echo "<tbody>";

                            while ($row = $fullTableResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['CustomerID'] . "</td>";
                                echo "<td>" . $row['CustomerName'] . "</td>";
                                echo "<td>" . $row['ContactInfo'] . "</td>";
                                echo "<td>" . $row['CustomerAddress'] . "</td>";
                                echo "</tr>";
                            }

                            echo "</tbody></table>";
                        } else {
                            echo "<p class='alert alert-info'>No customers found.</p>";
                        }
                        ?>

                        <!-- Add New Customer Form -->
                        <form method="POST" action="" class="mb-4">
                            <h4 class="mb-3">Add New Customer</h4>
                            <div class="mb-3">
                                <label for="customerName" class="form-label">Customer Name:</label>
                                <input type="text" class="form-control" id="customerName" name="customerName" required>
                            </div>
                            <div class="mb-3">
                                <label for="contactInfo" class="form-label">Contact Info:</label>
                                <input type="text" class="form-control" id="contactInfo" name="contactInfo" required>
                            </div>
                            <div class="mb-3">
                                <label for="customerAddress" class="form-label">Customer Address:</label>
                                <input type="text" class="form-control" id="customerAddress" name="customerAddress" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="addCustomer">Add Customer</button>
                        </form>

                        <!-- Remove Customer Form -->
                        <form method="POST" action="">
                            <h4 class="mb-3">Remove Customer by Searching</h4>
                            <div class="mb-3">
                                <label for="searchRemoveCustomer" class="form-label">Enter Customer Name to Remove:</label>
                                <input type="text" class="form-control" id="searchRemoveCustomer" name="searchRemoveCustomer" required>
                            </div>
                            <button type="submit" class="btn btn-danger" name="removeCustomerSearchBtn">Remove Customer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
