<?php
include 'config.php';

// Function to fetch transactions from the database with pagination
function getTransactionsWithPagination($offset, $limit)
{
    global $conn;
    $query = "SELECT * FROM Transaction LIMIT $offset, $limit";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Function to get the total number of transactions
function getTotalTransactionsCount()
{
    global $conn;
    $query = "SELECT COUNT(*) as total FROM Transaction";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['total'];
    } else {
        return 0;
    }
}

// Number of transactions per page
$transactionsPerPage = 10;

// Calculate the total number of pages
$totalTransactions = getTotalTransactionsCount();
$totalPages = ceil($totalTransactions / $transactionsPerPage);

// Determine the current page number
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $transactionsPerPage;

// Fetch transactions for the current page
$transactions = getTransactionsWithPagination($offset, $transactionsPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
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
            <form class="d-flex justify-content-end mb-2" method="GET" action="">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-search"></i></button>
            </form>
            <div class="container mt-5">
                <?php

                // Pagination configuration
                $resultsPerPage = 10;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $resultsPerPage;
                // PHP code for search by Transaction ID or Product
                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
                    $searchTerm = $conn->real_escape_string($_GET["search"]);
                    $searchQuery = "SELECT * FROM transaction WHERE TransactionID LIKE '%$searchTerm%' OR TransactionProduct LIKE '%$searchTerm%' or TransactionHolder LIKE '%$searchTerm%' or TransactionType LIKE '%$searchTerm%' or TransactionDate LIKE '%$searchTerm%' or TransactionAmount LIKE '%$searchTerm%' or TotalQuantity LIKE '%$searchTerm%' LIMIT $offset, $resultsPerPage";
                    $searchResult = $conn->query($searchQuery);

                    if ($searchResult && $searchResult->num_rows > 0) {
                        echo "<h4>Search Results:</h4>";
                        echo "<table class='table'>";
                        echo "<thead><tr><th>TransactionNO</th><th>TransactionProduct</th><th>TransactionHolder</th><th>Transaction Type</th><th>Transaction Date</th><th>Transaction Amount</th><th>TotalQuantity</th></tr></thead>";
                        echo "<tbody>";

                        $recordNumber = $offset + 1;
                        while ($row = $searchResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $recordNumber . "</td>";

                            echo "<td>" . $row['TransactionProduct'] . "</td>";
                            echo "<td>" . $row['TransactionHolder'] . "</td>";
                            echo "<td>" . $row['TransactionType'] . "</td>";
                            echo "<td>" . $row['TransactionDate'] . "</td>";
                            echo "<td>" . $row['TransactionAmount'] . "</td>";
                            echo "<td>" . $row['TotalQuantity'] . "</td>";
                            echo "</tr>";
                            $recordNumber++;
                        }

                        echo "</tbody></table>";

                        // Pagination controls
                        $totalRows = $searchResult->num_rows;
                        $totalPages = ceil($totalRows / $resultsPerPage);

                        // Pagination controls
                        echo "<div class='pagination-container mt-3'>";
                        echo "<ul class='pagination justify-content-end'>";
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i" . (isset($_GET['search']) ? "&search={$_GET['search']}" : "") . "'>$i</a></li>";
                        }
                        echo "</ul>";
                        echo "</div>";
                    } else {
                        echo "<p>No results found for the search term: $searchTerm</p>";
                    }
                } else {
                    // PHP code for displaying the full Transaction table with pagination
                    $fullTableQuery = "SELECT * FROM transaction LIMIT $offset, $resultsPerPage";
                    $fullTableResult = $conn->query($fullTableQuery);

                    if ($fullTableResult && $fullTableResult->num_rows > 0) {
                        echo "<h4>Full Transaction Table:</h4>";
                        echo "<table class='table'>";
                        echo "<thead><tr><th>TransactionNO</th><th>TransactionProduct</th><th>TransactionHolder</th><th>Transaction Type</th><th>Transaction Date</th><th>Transaction Amount</th><th>TotalQuantity</th></tr></thead>";
                        echo "<tbody>";

                        $recordNumber = $offset + 1;
                        while ($row = $fullTableResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $recordNumber . "</td>";

                            echo "<td>" . $row['TransactionProduct'] . "</td>";
                            echo "<td>" . $row['TransactionHolder'] . "</td>";
                            echo "<td>" . $row['TransactionType'] . "</td>";
                            echo "<td>" . $row['TransactionDate'] . "</td>";
                            echo "<td>" . $row['TransactionAmount'] . "</td>";
                            echo "<td>" . $row['TotalQuantity'] . "</td>";
                            echo "</tr>";
                            $recordNumber++;
                        }

                        echo "</tbody></table>";

                        // Pagination controls
                        $totalRows = $fullTableResult->num_rows;
                        $totalPages = ceil($totalRows / $resultsPerPage);

                        // Pagination controls
                        echo "<div class='pagination-container mt-3'>";
                        echo "<ul class='pagination justify-content-end'>";
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i" . (isset($_GET['search']) ? "&search={$_GET['search']}" : "") . "'>$i</a></li>";
                        }
                        echo "</ul>";
                        echo "</div>";
                    } else {
                        echo "<p>No transactions found.</p>";
                    }
                }
                ?>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>