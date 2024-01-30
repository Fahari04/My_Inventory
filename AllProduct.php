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
        <div class="main p-3 vh-100 overflow-hidden transition">
            <form class="d-flex justify-content-end mb-2" method="GET" action="">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-search"></i></button>
            </form>

            <?php
            $resultsPerPage = 10; // Set the number of results per page

            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
                // PHP code for search
                $searchTerm = $conn->real_escape_string($_GET["search"]);
                $columns = array("ProductName", "ProductPrice", "CategoryName", "SupplierName", "StockQuantity", "ReorderLevel", "ShelfLocation", "LastRestockDate", "ExpiryDate");
                $searchQuery = "SELECT * FROM Inventory WHERE ";

                foreach ($columns as $column) {
                    $searchQuery .= "$column LIKE '%$searchTerm%' OR ";
                }

                $searchQuery = rtrim($searchQuery, " OR ");
                $searchResult = $conn->query($searchQuery);

                if ($searchResult->num_rows > 0) {
                    echo "<h4>Search Results:</h4>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>ProductName</th><th>ProductPrice</th><th>CategoryName</th><th>SupplierName</th><th>StockQuantity</th><th>ReorderLevel</th><th>ShelfLocation</th><th>LastRestockDate</th><th>ExpiryDate</th></tr></thead>";
                    echo "<tbody>";

                    $totalSearchResults = $searchResult->num_rows;
                    $totalPages = ($totalSearchResults > 0) ? ceil($totalSearchResults / $resultsPerPage) : 1;
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

                    // Adjust the current page if it's out of bounds
                    $currentPage = max(1, min($currentPage, $totalPages));

                    $offset = ($currentPage - 1) * $resultsPerPage;
                    $searchQuery .= " LIMIT $offset, $resultsPerPage";
                    $searchResult = $conn->query($searchQuery);

                    while ($row = $searchResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ProductName'] . "</td>";
                        echo "<td>" . $row['ProductPrice'] . "</td>";
                        echo "<td>" . $row['CategoryName'] . "</td>";
                        echo "<td>" . $row['SupplierName'] . "</td>";
                        echo "<td>" . $row['StockQuantity'] . "</td>";
                        echo "<td>" . $row['ReorderLevel'] . "</td>";
                        echo "<td>" . $row['ShelfLocation'] . "</td>";
                        echo "<td>" . $row['LastRestockDate'] . "</td>";
                        echo "<td>" . $row['ExpiryDate'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table>";

                    // Pagination for search results
                    echo "<nav aria-label='Page navigation'>";
                    echo "<ul class='pagination justify-content-end'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item" . ($i == $currentPage ? " active" : "") . "'>";
                        echo "<a class='page-link' href='AllProduct.php?page=$i" . (isset($_GET['search']) ? "&search=" . urlencode($_GET['search']) : "") . "'>$i</a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                    echo "</nav>";
                } else {
                    echo "<p>No results found for the search term: $searchTerm</p>";
                }
            } else {
                // PHP code for displaying the full Inventory table
                $fullTableQuery = "SELECT * FROM Inventory";
                $fullTableResult = $conn->query($fullTableQuery);

                if ($fullTableResult->num_rows > 0) {
                    echo "<h4>Full Inventory Table:</h4>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>ProductName</th><th>ProductPrice</th><th>CategoryName</th><th>SupplierName</th><th>StockQuantity</th><th>ReorderLevel</th><th>ShelfLocation</th><th>LastRestockDate</th><th>ExpiryDate</th></tr></thead>";
                    echo "<tbody>";

                    $totalFullTableResults = $fullTableResult->num_rows;
                    $totalFullTablePages = ceil($totalFullTableResults / $resultsPerPage);
                    $currentFullTablePage = isset($_GET['page']) ? $_GET['page'] : 1;

                    // Adjust the current page if it's out of bounds
                    $currentFullTablePage = max(1, min($currentFullTablePage, $totalFullTablePages));

                    $offset = ($currentFullTablePage - 1) * $resultsPerPage;
                    $fullTableQuery .= " LIMIT $offset, $resultsPerPage";
                    $fullTableResult = $conn->query($fullTableQuery);

                    while ($row = $fullTableResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ProductName'] . "</td>";
                        echo "<td>" . $row['ProductPrice'] . "</td>";
                        echo "<td>" . $row['CategoryName'] . "</td>";
                        echo "<td>" . $row['SupplierName'] . "</td>";
                        echo "<td>" . $row['StockQuantity'] . "</td>";
                        echo "<td>" . $row['ReorderLevel'] . "</td>";
                        echo "<td>" . $row['ShelfLocation'] . "</td>";
                        echo "<td>" . $row['LastRestockDate'] . "</td>";
                        echo "<td>" . $row['ExpiryDate'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table>";

                    // Pagination for full table
                    echo "<nav aria-label='Page navigation'>";
                    echo "<ul class='pagination justify-content-end'>";
                    for ($i = 1; $i <= $totalFullTablePages; $i++) {
                        echo "<li class='page-item" . ($i == $currentFullTablePage ? " active" : "") . "'>";
                        echo "<a class='page-link' href='AllProduct.php?page=$i'>$i</a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                    echo "</nav>";
                } else {
                    echo "<p>No products found.</p>";
                }
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
