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
    <title>Add Product</title>
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
            <div class="container mt-5">
                <h2>Transaction History</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Transaction Type</th>
                            <th>Transaction Date</th>
                            <th>Transaction Amount</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction) : ?>
                            <tr>
                                <td><?= $transaction['TransactionID']; ?></td>
                                <td><?= $transaction['TransactionType']; ?></td>
                                <td><?= $transaction['TransactionDate']; ?></td>
                                <td><?= $transaction['TransactionAmount']; ?></td>
                                <td><?= $transaction['TotalQuantity']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination links -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item<?= ($i == $currentPage) ? ' active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>