<?php
include 'config.php';

// Function to fetch transactions from the database with pagination
function getTransactionsWithPagination($offset, $limit, $searchTerm = "")
{
    global $conn;
    $searchCondition = $searchTerm ? " WHERE TransactionID LIKE '%$searchTerm%' OR TransactionProduct LIKE '%$searchTerm%' or TransactionHolder LIKE '%$searchTerm%' or TransactionType LIKE '%$searchTerm%' or TransactionDate LIKE '%$searchTerm%' or TransactionAmount LIKE '%$searchTerm%' or TotalQuantity LIKE '%$searchTerm%'" : "";
    $query = "SELECT * FROM Transaction $searchCondition LIMIT $offset, $limit";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Function to get the total number of transactions
function getTotalTransactionsCount($searchTerm = "")
{
    global $conn;
    $searchCondition = $searchTerm ? " WHERE TransactionID LIKE '%$searchTerm%' OR TransactionProduct LIKE '%$searchTerm%' or TransactionHolder LIKE '%$searchTerm%' or TransactionType LIKE '%$searchTerm%' or TransactionDate LIKE '%$searchTerm%' or TransactionAmount LIKE '%$searchTerm%' or TotalQuantity LIKE '%$searchTerm%'" : "";
    $query = "SELECT COUNT(*) as total FROM Transaction $searchCondition";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['total'];
    } else {
        return 0;
    }
}

// Number of transactions per page
$transactionsPerPage = 10;

// Determine the current page number
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Fetch search term
$searchTerm = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";

// Calculate the total number of pages
$totalTransactions = getTotalTransactionsCount($searchTerm);
$totalPages = ceil($totalTransactions / $transactionsPerPage);

// Ensure the current page is within valid bounds
$currentPage = max(1, min($currentPage, $totalPages));

// Calculate the offset for the SQL query
$offset = ($currentPage - 1) * $transactionsPerPage;

// Fetch transactions for the current page
$transactions = getTransactionsWithPagination($offset, $transactionsPerPage, $searchTerm);
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
                // Displaying search results or full transaction table
                if ($transactions) {
                    echo "<h4>Transaction Table:</h4>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>TransactionNO</th><th>TransactionProduct</th><th>TransactionHolder</th><th>Transaction Type</th><th>Transaction Date</th><th>Transaction Amount</th><th>TotalQuantity</th></tr></thead>";
                    echo "<tbody>";

                    $recordNumber = $offset + 1;
                    foreach ($transactions as $row) {
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
                    echo "<div class='pagination-container mt-3'>";
                    echo "<ul class='pagination justify-content-end'>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo "<li class='page-item " . ($currentPage == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i" . ($searchTerm ? "&search=$searchTerm" : "") . "'>$i</a></li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                } else {
                    echo "<p>No transactions found.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-EFhIiGQGqI1GfTkP9ibYI5hB6ysjOGp1hiZyAnFGa/1R3ZBTPetOuW49lI" crossorigin="anonymous"></script>
</body>

</html>
