<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "My_Inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ... (your existing code)

// Handle new supplier form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addSupplier"])) {
    $newSupplierName = $conn->real_escape_string($_POST["supplierName"]);
    // $newContactInfo = $conn->real_escape_string($_POST["contactInfo"]);
    $newPaymentTerms = $conn->real_escape_string($_POST["paymentTerms"]);
    $newPhoneNumber = $conn->real_escape_string($_POST["phoneNumber"]);
    $newCategoryID = $conn->real_escape_string($_POST["categoryID"]);

    $insertQuery = "INSERT INTO Supplier (SupplierName, PaymentTerms, PhoneNumber, CategoryID) 
                    VALUES ('$newSupplierName', '$newPaymentTerms', '$newPhoneNumber', '$newCategoryID')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<p>New supplier added successfully!</p>";
    } else {
        echo "<p>Error adding supplier: " . $conn->error . "</p>";
    }
}
// ... (the rest of your existing code)



// Handle remove supplier form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["removeSupplier"])) {
    $removeSupplierName = $conn->real_escape_string($_POST["removeSupplier"]);

    $deleteQuery = "DELETE FROM Supplier WHERE SupplierName = '$removeSupplierName'";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "<p>Supplier removed successfully! Deleted: $removeSupplierName</p>";
    } else {
        echo "<p>Error removing supplier: " . $conn->error . "</p>";
    }
}


// Fetch and display all suppliers
$fetchSuppliersQuery = "SELECT * FROM Supplier";
$suppliersResult = $conn->query($fetchSuppliersQuery);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php
            include 'navbar.php';
            ?>

            <div class="col-md-12">

                <div class="bg-light flex-fill">
                    <div class="p-2 d-md-none d-flex text-white bg-success">
                        <a href="#" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                    </div>

                    <div class="p-4">
                        <nav style="--bs-breadcrumb-divider:'>';font-size:14px">
                            <!-- Add the search form here -->
                            <form class="d-flex justify-content-end mb-2" method="GET" action="">
                                <input class="form-control me-2" type="search" placeholder="SupplierID" aria-label="Search" name="search">
                                <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-search"></i></button>
                            </form>
                            <!-- End of search form -->

                            <!-- PHP code for table -->
                            <?php
                            // ... (your existing code)
                            // PHP code for search by category
                            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
                                $searchTerm = $conn->real_escape_string($_GET["search"]);
                                $searchQuery = "SELECT * FROM Supplier WHERE SupplierName LIKE '%$searchTerm%'";
                                $searchResult = $conn->query($searchQuery);

                                if ($searchResult->num_rows > 0) {
                                    echo "<h4>Search Results by Category:</h4>";
                                    echo "<table class='table'>";
                                    echo "<thead><tr><th>Supplier ID</th><th>Supplier Name</th><th>Contact Info</th><th>Payment Terms</th><th>Category</th></tr></thead>";
                                    echo "<tbody>";

                                    while ($row = $searchResult->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['SupplierID'] . "</td>";
                                        echo "<td>" . $row['SupplierName'] . "</td>";
                                        echo "<td>" . $row['PhoneNumber'] . "</td>";
                                        echo "<td>" . $row['PaymentTerms'] . "</td>";
                                        echo "<td>" . $row['CategoryName'] . "</td>";
                                        echo "</tr>";
                                    }

                                    echo "</tbody></table>";
                                } else {
                                    echo "<p>No results found for the search term: $searchTerm</p>";
                                }
                            }
                            // PHP code for table and search
                            $fullTableQuery = "SELECT * FROM Supplier";
                            $fullTableResult = $conn->query($fullTableQuery);

                            if ($fullTableResult->num_rows > 0) {
                                echo "<h4>Full Supplier Table:</h4>";
                                echo "<table class='table'>";
                                echo "<thead><tr><th>Supplier ID</th><th>Supplier Name</th><th>PaymentTerms</th><th>PhoneNumber</th><th>CategoryID</th><th>CategoryName</th></tr></thead>";
                                echo "<tbody>";

                                while ($row = $fullTableResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['SupplierID'] . "</td>";
                                    echo "<td>" . $row['SupplierName'] . "</td>";
                                    echo "<td>" . $row['PaymentTerms'] . "</td>";
                                    echo "<td>" . $row['PhoneNumber'] . "</td>";
                                    echo "<td>" . $row['CategoryID'] . "</td>";
                                    echo "<td>" . $row['CategoryName'] . "</td>";
                                    echo "</tr>";
                                }

                                echo "</tbody></table>";
                            } else {
                                echo "<p>No suppliers found.</p>";
                            }
                            ?>

                            <!-- End of PHP code -->

                            <form method="POST" action="">
                                <h4>Add New Supplier:</h4>
                                <div class="mb-3">
                                    <label for="supplierName" class="form-label">Supplier Name:</label>
                                    <input type="text" class="form-control" id="supplierName" name="supplierName" required>
                                </div>
                              
                                <div class="mb-3">
                                    <label for="paymentTerms" class="form-label">Payment Terms:</label>
                                    <input type="text" class="form-control" id="paymentTerms" name="paymentTerms" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneNumber" class="form-label">Phone Number:</label>
                                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
                                </div>
                                <div class="mb-3">
                                    <label for="categoryID" class="form-label">Category ID:</label>
                                    <input type="text" class="form-control" id="categoryID" name="categoryID" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="addSupplier">Add Supplier</button>
                            </form>



                            <?php
                            // Assuming $conn is your database connection

                            function setRemoveSupplierValue()
                            {
                                if (isset($_POST['removeSupplier'])) {
                                    $removeSupplierSelect = $_POST["removeSupplier"];
                                    $removeSupplierHiddenInput = $_POST["removeSupplierHidden"];

                                    // Set the value of the hidden input to the selected supplier Name
                                    $selectedSupplier = $removeSupplierSelect;
                                    $_POST["removeSupplierHidden"] = $selectedSupplier;
                                }
                            }

                            // Check if the form is submitted
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                // Call the function to set the hidden input value
                                setRemoveSupplierValue();

                                // Process form data (for example, remove the selected supplier from the database)
                                if (isset($_POST['removeSupplierHidden'])) {
                                    $selectedSupplier = $_POST['removeSupplierHidden'];

                                    // Perform database operation (example: removing the supplier)
                                    $removeSupplierQuery = "DELETE FROM Supplier WHERE SupplierName = ?";
                                    $stmt = $conn->prepare($removeSupplierQuery);
                                    $stmt->bind_param("s", $selectedSupplier);
                                    $stmt->execute();
                                    // Add further error handling and success messages as needed
                                }
                            }
                            ?>
                            <!-- HTML Form -->
                            <form method="POST" action="">
                                <h4>Remove Supplier:</h4>
                                <div class="mb-3">
                                    <label for="removeSupplier" class="form-label">Select Supplier to Remove:</label>
                                    <select class="form-select" id="removeSupplier" name="removeSupplier" required onchange="this.form.submit()">
                                        <?php
                                        // Fetch existing suppliers for the dropdown
                                        $fetchSuppliersQuery = "SELECT * FROM Supplier";
                                        $suppliersResult = $conn->query($fetchSuppliersQuery);

                                        while ($row = $suppliersResult->fetch_assoc()) {
                                            echo "<option value='" . $row['SupplierName'] . "'>" . $row['SupplierName'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Hidden input to store selected supplier -->
                                <input type="hidden" name="removeSupplierHidden" id="removeSupplierHidden">
                                <button type="submit" class="btn btn-danger">Remove Supplier</button>
                            </form>


                        </nav>


                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>




</body>

</html>