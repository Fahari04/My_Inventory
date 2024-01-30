
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Management</title>
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
                <h4 class="mb-4">Supplier Management</h4>

                <form class="mb-4" method="GET" action="">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Search by Supplier Name" aria-label="Search" name="search">
                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>

                <!-- Search Results -->
                <?php
                // Number of records per page
                $recordsPerPage = 10;

                // Calculate the total number of pages
                $totalPagesQuery = "SELECT COUNT(*) as total FROM Supplier";
                $totalPagesResult = $conn->query($totalPagesQuery);
                $totalRecords = $totalPagesResult->fetch_assoc()['total'];
                $totalPages = ceil($totalRecords / $recordsPerPage);

                // Determine the current page number
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($currentPage - 1) * $recordsPerPage;

                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
                    // Display Search Results
                    $searchTerm = $conn->real_escape_string($_GET["search"]);
                    $searchQuery = "SELECT * FROM Supplier 
                    WHERE SupplierName LIKE '%$searchTerm%' 
                       OR CategoryName LIKE '%$searchTerm%' 
                    LIMIT $offset, $recordsPerPage";
                    $searchResult = $conn->query($searchQuery);
                } else {
                    // Display Full Supplier Table
                    $fullTableQuery = "SELECT * FROM Supplier LIMIT $offset, $recordsPerPage";
                    $fullTableResult = $conn->query($fullTableQuery);
                }

                if (isset($searchResult) && $searchResult->num_rows > 0) {
                    echo "<h6 class='mb-3'>Search Results:</h6>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>No.</th><th>Supplier Name</th><th>PaymentTerms</th><th>PhoneNumber</th><th>CategoryName</th></tr></thead>";
                    echo "<tbody>";
                    $recordNumber = 1;
                    while ($row = $searchResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $recordNumber . "</td>";
                        echo "<td>" . $row['SupplierName'] . "</td>";
                        echo "<td>" . $row['PaymentTerms'] . "</td>";
                        echo "<td>" . $row['PhoneNumber'] . "</td>";
                        echo "<td>" . $row['CategoryName'] . "</td>";
                        echo "</tr>";
                        $recordNumber++;
                    }

                    echo "</tbody></table>";

                    // Pagination links
                    echo "<nav aria-label='Page navigation'>";
                    echo "<ul class='pagination justify-content-end'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item" . ($i == $currentPage ? " active" : "") . "'>";
                        echo "<a class='page-link' href='Supplier.php?page=$i&search=" . urlencode($_GET['search']) . "'>$i</a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                    echo "</nav>";
                } elseif (isset($fullTableResult) && $fullTableResult->num_rows > 0) {
                    echo "<h6 class='mb-3'>Full Customer Table:</h6>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>No.</th><th>Supplier Name</th><th>PaymentTerms</th><th>PhoneNumber</th><th>CategoryName</th></tr></thead>";
                    echo "<tbody>";
                    $recordNumber = 1;
                    while ($row = $fullTableResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $recordNumber . "</td>";
                        echo "<td>" . $row['SupplierName'] . "</td>";
                        echo "<td>" . $row['PaymentTerms'] . "</td>";
                        echo "<td>" . $row['PhoneNumber'] . "</td>";
                        echo "<td>" . $row['CategoryName'] . "</td>";
                        echo "</tr>";
                        $recordNumber++;
                    }

                    echo "</tbody></table>";

                    // Pagination links
                    echo "<nav aria-label='Page navigation'>";
                    echo "<ul class='pagination justify-content-end'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item" . ($i == $currentPage ? " active" : "") . "'>";
                        echo "<a class='page-link' href='Supplier.php?page=$i'>$i</a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                    echo "</nav>";
                } else {
                    echo "<p class='alert alert-info'>No Supplier found.</p>";
                }
                ?>


                <!-- Add New Supplier Form -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">Add Supplier</button>

                <!-- Add Supplier Modal -->
                <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addSupplierModalLabel">Add New Supplier</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="" class="mb-4">
                                    <div class="mb-3">
                                        <label for="supplierName" class="form-label">Supplier Name:</label>
                                        <input type="text" class="form-control" id="supplierName" name="supplierName" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="paymentTerms" class="form-label">Payment Terms:</label>
                                        <select class="form-select" id="paymentTerms" name="paymentTerms" required>
                                            <option value="Cash">Cash</option>
                                            <option value="Online Payment">Online Payment</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phoneNumber" class="form-label">Phone Number:</label>
                                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="categoryName" class="form-label">Category Name:</label>
                                        <select class="form-select" id="categoryName" name="categoryName" required>
                                            <?php
                                            // Fetch existing categories for the dropdown
                                            $fetchCategoriesQuery = "SELECT * FROM Category";
                                            $categoriesResult = $conn->query($fetchCategoriesQuery);

                                            while ($row = $categoriesResult->fetch_assoc()) {
                                                echo "<option value='" . $row['CategoryName'] . "'>" . $row['CategoryName'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary" name="addSupplier">Add Supplier</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                function showAlertAndRefresh($message)
                {
                    echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "'); window.location.href='Supplier.php';</script>";
                }

                // Handle new supplier form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addSupplier'])) {
                    $newSupplierName = $conn->real_escape_string($_POST["supplierName"]);
                    $newPaymentTerms = $conn->real_escape_string($_POST["paymentTerms"]);
                    $newPhoneNumber = $conn->real_escape_string($_POST["phoneNumber"]);
                    $newCategoryName = $conn->real_escape_string($_POST["categoryName"]);

                    // Check if the supplier already exists
                    $checkSupplierQuery = "SELECT * FROM Supplier WHERE SupplierName = '$newSupplierName'";
                    $existingSupplierResult = $conn->query($checkSupplierQuery);

                    if ($existingSupplierResult->num_rows > 0) {
                        showAlertAndRefresh("Supplier with the name '$newSupplierName' already exists.");
                    } else {
                        // If the supplier does not exist, insert into the database
                        $insertQuery = "INSERT INTO Supplier (SupplierName, PaymentTerms, PhoneNumber, CategoryName) 
                            VALUES ('$newSupplierName', '$newPaymentTerms', '$newPhoneNumber', '$newCategoryName')";

                        if ($conn->query($insertQuery) === TRUE) {
                            showAlertAndRefresh("New supplier added successfully!");
                        } else {
                            showAlertAndRefresh("Error adding supplier: " . $conn->error);
                        }
                    }
                }
                // Handle remove supplier form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['removeSupplierSearchBtn'])) {
                    $removeSupplierName = $conn->real_escape_string($_POST["removeSupplier"]); // Change to removeSupplier

                    // Check if the supplier exists
                    $checkSupplierQuery = "SELECT * FROM Supplier WHERE SupplierName = '$removeSupplierName'";
                    $existingSupplierResult = $conn->query($checkSupplierQuery);

                    if ($existingSupplierResult->num_rows > 0) {
                        // Supplier found, proceed with removal
                        $removeSupplierQuery = "DELETE FROM Supplier WHERE SupplierName = '$removeSupplierName'";
                        if ($conn->query($removeSupplierQuery) === TRUE) {
                            showAlertAndRefresh("Supplier '$removeSupplierName' removed successfully!", 'Supplier.php');
                        } else {
                            showAlertAndRefresh("Error removing supplier: " . $conn->error, 'Supplier.php');
                        }
                    } else {
                        showAlertAndRefresh("Supplier '$removeSupplierName' not found.", 'Supplier.php');
                    }
                }

                // Fetch all suppliers for the dropdown
                $fetchSuppliersQuery = "SELECT * FROM Supplier";
                $suppliersResult = $conn->query($fetchSuppliersQuery);
                ?>

                <!-- Remove Supplier Form -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeSupplierModal">Remove Supplier</button>
                <div class="modal fade" id="removeSupplierModal" tabindex="-1" aria-labelledby="removeSupplierModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="removeSupplierModalLabel">Remove Supplier</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="removeSupplier" class="form-label">Select Supplier to Remove:</label>
                                        <select class="form-select" id="removeSupplier" name="removeSupplier" required>
                                            <?php
                                            // Fetch all suppliers for the dropdown
                                            $fetchSuppliersQuery = "SELECT * FROM Supplier";
                                            $suppliersResult = $conn->query($fetchSuppliersQuery);

                                            while ($row = $suppliersResult->fetch_assoc()) {
                                                echo "<option value='" . $row['SupplierName'] . "'>" . $row['SupplierName'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-danger" name="removeSupplierSearchBtn">Remove Supplier</button>
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