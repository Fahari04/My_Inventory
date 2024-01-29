<?php
include 'config.php';
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
</head>

<body>
    <div class="d-flex">
        <?php
        include 'navbar.php';
        ?>
        <div class="main p-3 vh-100 overflow-hidden transition text-center text-center">
            <div class="p-4">
                <h4 class="mb-4">Customer Management</h4>

                <form class="mb-4" method="GET" action="">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Search by Customer Name" aria-label="Search" name="search">
                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>

                <!-- Search Results -->
                <?php
                // Number of records per page
                $recordsPerPage = 10;

                // Calculate the total number of pages
                $totalPagesQuery = "SELECT COUNT(*) as total FROM Customer";
                $totalPagesResult = $conn->query($totalPagesQuery);
                $totalRecords = $totalPagesResult->fetch_assoc()['total'];
                $totalPages = ceil($totalRecords / $recordsPerPage);

                // Determine the current page number
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($currentPage - 1) * $recordsPerPage;

                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
                    // Display Search Results
                    $searchTerm = $conn->real_escape_string($_GET["search"]);
                    $searchQuery = "SELECT * FROM Customer 
                    WHERE CustomerName LIKE '%$searchTerm%' 
                       OR ContactInfo LIKE '%$searchTerm%' 
                       OR CustomerAddress LIKE '%$searchTerm%'
                       OR CustomerID LIKE '%$searchTerm%'
                    LIMIT $offset, $recordsPerPage";
                    $searchResult = $conn->query($searchQuery);
                } else {
                    // Display Full Customer Table
                    $fullTableQuery = "SELECT * FROM Customer LIMIT $offset, $recordsPerPage";
                    $fullTableResult = $conn->query($fullTableQuery);
                }

                if (isset($searchResult) && $searchResult->num_rows > 0) {
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

                    // Pagination links
                    echo "<nav aria-label='Page navigation'>";
                    echo "<ul class='pagination justify-content-end'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item" . ($i == $currentPage ? " active" : "") . "'>";
                        echo "<a class='page-link' href='customers.php?page=$i&search=" . urlencode($_GET['search']) . "'>$i</a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                    echo "</nav>";
                } elseif (isset($fullTableResult) && $fullTableResult->num_rows > 0) {
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

                    // Pagination links
                    echo "<nav aria-label='Page navigation'>";
                    echo "<ul class='pagination justify-content-end'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item" . ($i == $currentPage ? " active" : "") . "'>";
                        echo "<a class='page-link' href='customers.php?page=$i'>$i</a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                    echo "</nav>";
                } else {
                    echo "<p class='alert alert-info'>No customers found.</p>";
                }
                ?>


                <!-- Add New Customer Form -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">Add Customer</button>
                <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" class="mb-4">
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
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                function showAlertAndRefresh($message)
                {
                    echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "'); window.location.href='customers.php';</script>";
                }

                // Handle new customer form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCustomer"])) {
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
                    $searchRemoveCustomerName = $conn->real_escape_string($_POST["searchRemoveCustomer"]);

                    $deleteCustomerQuery = "DELETE FROM Customer WHERE CustomerName = '$searchRemoveCustomerName'";

                    if ($conn->query($deleteCustomerQuery) === TRUE) {
                        showAlertAndRefresh("Customer removed successfully! Deleted CustomerName: $searchRemoveCustomerName");
                    } else {
                        showAlertAndRefresh("Error removing customer: " . $conn->error);
                    }
                }
                ?>
                <!-- Remove Customer Form -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeCustomerModal">Remove Customer</button>
                <div class="modal fade" id="removeCustomerModal" tabindex="-1" aria-labelledby="removeCustomerModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="removeCustomerModalLabel">Remove Customer by Searching</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="">
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
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
