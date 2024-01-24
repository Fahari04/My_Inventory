<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rYU79z8b3CzBXGAZ+R9MDd94R/RO/TFJ2ACa/i8FJQnJd1k1IKVMMsXa4JXAM1v2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        <?php include 'navbar.php'; ?>
        <div class="main p-3 vh-100 overflow-hidden transition text-center text-center">
            <div class="bg-light flex-fill">
                <div class="p-4">
                    <h4 class="mb-4">Category Management</h4>

                    <form class="mb-4" method="GET" action="">
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Search by Category Name" aria-label="Search" name="search">
                            <button class="btn btn-outline-secondary" type="submit"><i class="lni lni-search-alt"></i></button>
                        </div>
                    </form>

                    <!-- Display Search Results or Full Category Table -->
                    <?php

                    // Number of records per page
                    $recordsPerPage = 10;

                    // Calculate the total number of pages
                    $totalPagesQuery = "SELECT COUNT(*) as total FROM Category";
                    $totalPagesResult = $conn->query($totalPagesQuery);
                    $totalRecords = $totalPagesResult->fetch_assoc()['total'];
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    // Determine the current page number
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($currentPage - 1) * $recordsPerPage;

                    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
                        // Display Search Results
                        $searchTerm = $conn->real_escape_string($_GET["search"]);
                        $searchQuery = "SELECT * FROM Category WHERE CategoryName LIKE '%$searchTerm%' LIMIT $offset, $recordsPerPage";
                        $searchResult = $conn->query($searchQuery);
                    } else {
                        // Display Full Category Table
                        $fullTableQuery = "SELECT * FROM Category LIMIT $offset, $recordsPerPage";
                        $fullTableResult = $conn->query($fullTableQuery);
                    }
                    if (isset($searchResult) && $searchResult->num_rows > 0) {
                        echo "<table class='table'>";
                        echo "<thead><tr><th>No.</th><th>CategoryName</th></thead>";
                        echo "<tbody>";

                        $recordNumber = 1;
                        while ($row = $searchResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $recordNumber . "</td>";
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
                            echo "<a class='page-link' href='category.php?page=$i&search=" . urlencode($_GET['search']) . "'>$i</a>";
                            echo "</li>";
                        }
                        echo "</ul>";
                        echo "</nav>";
                    } elseif (isset($fullTableResult) && $fullTableResult->num_rows > 0) {
                        echo "<table class='table'>";
                        echo "<thead><tr><th>No.</th><th>CategoryName</th></thead>";
                        echo "<tbody>";

                        $recordNumber = 1;
                        while ($row = $fullTableResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $recordNumber . "</td>";
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
                            echo "<a class='page-link' href='category.php?page=$i'>$i</a>";
                            echo "</li>";
                        }
                        echo "</ul>";
                        echo "</nav>";
                    } else {
                        echo "<p class='alert alert-info'>No categories found.</p>";
                    }
                    ?>


                    <?php
                    function showAlertAndRefresh($message)
                    {
                        echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "'); window.location.href='category.php';</script>";
                    }
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCategory"])) {
                        $newCategoryID = uniqid('category_');
                        $newCategoryName = $conn->real_escape_string($_POST["categoryName"]);

                        // Check if the category already exists
                        $checkCategoryQuery = "SELECT * FROM Category WHERE CategoryName = '$newCategoryName'";
                        $existingCategoryResult = $conn->query($checkCategoryQuery);

                        if ($existingCategoryResult->num_rows > 0) {
                            showAlertAndRefresh("Category with the name '$newCategoryName' already exists.");
                        } else {
                            // If the category does not exist, insert into the database
                            $insertCategoryQuery = "INSERT INTO Category (CategoryName, CategoryID) VALUES ('$newCategoryName', '$newCategoryID')";

                            if ($conn->query($insertCategoryQuery) === TRUE) {
                                showAlertAndRefresh("New category added successfully!");
                            } else {
                                showAlertAndRefresh("Error adding category: " . $conn->error);
                            }
                        }
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["removeCategorySearchBtn"])) {
                        $searchRemoveCategoryName = $conn->real_escape_string($_POST["searchRemoveCategory"]);

                        // Check if the category exists before attempting to delete
                        $checkCategoryQuery = "SELECT * FROM Category WHERE CategoryName = '$searchRemoveCategoryName'";
                        $existingCategoryResult = $conn->query($checkCategoryQuery);

                        if ($existingCategoryResult->num_rows > 0) {
                            // If the category exists, proceed with deletion
                            $deleteCategoryQuery = "DELETE FROM Category WHERE CategoryName = '$searchRemoveCategoryName'";

                            if ($conn->query($deleteCategoryQuery) === TRUE) {
                                showAlertAndRefresh("Category removed successfully! Deleted CategoryName: $searchRemoveCategoryName");
                            } else {
                                showAlertAndRefresh("Error removing category: " . $conn->error);
                            }
                        } else {
                            // If the category does not exist, show a message
                            showAlertAndRefresh("There is no category with the name '$searchRemoveCategoryName'.");
                        }
                    }
                    ?>

                    <!-- Button to trigger Add Category Modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        Add Category
                    </button>

                    <!-- Button to trigger Remove Category Modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeCategoryModal">
                        Remove Category
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add New Category Form -->
                    <form method="POST" action="" class="mb-4">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name:</label>
                            <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addCategory">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Remove Category Modal -->
    <div class="modal fade" id="removeCategoryModal" tabindex="-1" aria-labelledby="removeCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeCategoryModalLabel">Remove Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Remove Category Form -->
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="searchRemoveCategory" class="form-label">Enter Category Name to Remove:</label>
                            <input type="text" class="form-control" id="searchRemoveCategory" name="searchRemoveCategory" required>
                        </div>
                        <button type="submit" class="btn btn-danger" name="removeCategorySearchBtn">Remove Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>