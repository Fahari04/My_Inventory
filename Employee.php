
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
        <?php
        include 'navbar.php';
        ?>
        <div class="main p-3 vh-100 overflow-hidden transition text-center">
            <!-- Add the search form here -->
            <form class="d-flex justify-content-end mb-2" method="GET" action="">
                <input class="form-control me-2" type="search" placeholder="Search by Employee Name or Position" aria-label="Search" name="search">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-search"></i></button>
            </form>

            <?php
            // Pagination configuration
            $resultsPerPage = 10;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $resultsPerPage;

            // PHP code for search by Employee Name or Position
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
                $searchTerm = $conn->real_escape_string($_GET["search"]);
                $searchQuery = "SELECT * FROM Employee WHERE EmployeeName LIKE '%$searchTerm%' OR Position LIKE '%$searchTerm%' LIMIT $offset, $resultsPerPage";
                $searchResult = $conn->query($searchQuery);

                if ($searchResult->num_rows > 0) {
                    echo "<h4>Search Results:</h4>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>No.</th><th>EmployeeName</th><th>Position</th><th>ContactInfo</th></tr></thead>";
                    echo "<tbody>";

                    $recordNumber = $offset + 1;
                    while ($row = $searchResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $recordNumber . "</td>";
                        echo "<td>" . $row['EmployeeName'] . "</td>";
                        echo "<td>" . $row['Position'] . "</td>";
                        echo "<td>" . $row['ContactInfo'] . "</td>";
                        echo "</tr>";
                        $recordNumber++;
                    }

                    echo "</tbody></table>";

                    // Pagination controls
                    $totalRows = $searchResult->num_rows;
                    $totalPages = ceil($totalRows / $resultsPerPage);

                    echo "<div class='pagination-container'>";
                    echo "<ul class='pagination'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i&search=$searchTerm'>$i</a></li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                } else {
                    echo "<p>No results found for the search term: $searchTerm</p>";
                }
            } else {
                // PHP code for displaying the full Employee table with pagination
                $fullTableQuery = "SELECT * FROM Employee LIMIT $offset, $resultsPerPage";
                $fullTableResult = $conn->query($fullTableQuery);

                if ($fullTableResult->num_rows > 0) {
                    echo "<h4>Full Employee Table:</h4>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>No.</th><th>EmployeeName</th><th>Position</th><th>ContactInfo</th></tr></thead>";
                    echo "<tbody>";

                    $recordNumber = $offset + 1;
                    while ($row = $fullTableResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $recordNumber . "</td>";
                        echo "<td>" . $row['EmployeeName'] . "</td>";
                        echo "<td>" . $row['Position'] . "</td>";
                        echo "<td>" . $row['ContactInfo'] . "</td>";
                        echo "</tr>";
                        $recordNumber++;
                    }

                    echo "</tbody></table>";

                    // Pagination controls
                    $totalRows = $fullTableResult->num_rows;
                    $totalPages = ceil($totalRows / $resultsPerPage);

                    echo "<div class='pagination-container'>";
                    echo "<ul class='pagination'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                } else {
                    echo "<p>No employees found.</p>";
                }
            }
            ?>


        </div>
    </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
