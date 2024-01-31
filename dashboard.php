<?php
include 'config.php';
$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$query = "SELECT `id`, `name`, `username`, `email`, `password`, `mobile`, `date_of_birth` FROM `user_form` WHERE `id` = $user_id";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch user details
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle error if query fails
    die('Query failed: ' . mysqli_error($conn));
}
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
        <?php
        include 'navbar.php';
        ?>

        <div class="main p-3 vh-100 overflow-hidden transition text-center">
            <div class="row justif-content-center align-items-center">
                <div class="">
                    <p class="fs-1">Welcome <?php echo $user['name'] ?></p>
                    <p> <span class="fw-bold">User Name:</span> <?php echo $user['username'] ?></p>
                    <p><span class="fw-bold">Email:</span><?php echo $user['email'] ?></p>
                </div>

            </div>
            <div class="row justif-content-center align-items-center">
                <div class="col-md-4">
                    <?php

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


                    $totalTransactions = getTotalTransactionsCount();
                    ?>
                    <div class="container mt-5">
                        <div class="card bg-dark bg-gradient">
                            <div class="card-header">
                                <h4 style="color: white;">Total Transactions</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text" style="color: white;">Total number of transactions: <?php echo $totalTransactions; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php

                    function getTotalProductsCount()
                    {
                        global $conn;
                        $query = "SELECT COUNT(*) as total FROM inventory";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            return $result->fetch_assoc()['total'];
                        } else {
                            return 0;
                        }
                    }


                    $totalProducts = getTotalProductsCount();
                    ?>
                    <div class="container mt-5">
                        <div class="card bg-secondary bg-gradient">
                            <div class="card-header">
                                <h4 style="color: white;">Total Products</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text" style="color: white;">Total number of products: <?php echo $totalProducts; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container mt-5">
                        <?php

                        function getTotalUserCount()
                        {
                            global $conn;
                            $query = "SELECT COUNT(*) as total FROM user_form";
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                return $result->fetch_assoc()['total'];
                            } else {
                                return 0;
                            }
                        }


                        $totalUsers = getTotalUserCount();
                        ?>
                        <div class="card bg-success bg-gradient">
                            <div class="card-header">
                                <h4 style="color: white;">Total Users</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text" style="color: white;">Total number of users: <?php echo $totalUsers; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row justif-content-center align-items-center">
                <div class="col-md-6 mt-5 p-5">
                    <?php
                    // Function to fetch the last 3 transactions from the database
                    function getLast3Transactions()
                    {
                        global $conn;
                        $query = "SELECT * FROM Transaction ORDER BY TransactionID DESC LIMIT 5";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            return $result->fetch_all(MYSQLI_ASSOC);
                        } else {
                            return [];
                        }
                    }

                    // Fetch the last 3 transactions
                    $last3Transactions = getLast3Transactions();

                    if (!empty($last3Transactions)) {
                        echo "<h4>Recent Transactions</h4>";
                        echo "<table class='table'>";
                        echo "<thead><tr><th>TransactionProduct</th><th>TransactionHolder</th><th>Transaction Type</th><th>Transaction Date</th><th>Transaction Amount</th><th>TotalQuantity</th></tr></thead>";
                        echo "<tbody>";

                        foreach ($last3Transactions as $transaction) {
                            echo "<tr>";
                            echo "<td>{$transaction['TransactionProduct']}</td>";
                            echo "<td>{$transaction['TransactionHolder']}</td>";
                            echo "<td>{$transaction['TransactionType']}</td>";
                            echo "<td>{$transaction['TransactionDate']}</td>";
                            echo "<td>{$transaction['TransactionAmount']}</td>";
                            echo "<td>{$transaction['TotalQuantity']}</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "<p>No transactions found.</p>";
                    }
                    ?>
                </div>
                <div class="col-md-6 p-4">
                    <?php
                    // Function to fetch the last 3 products from the database
                    function getLast3Products()
                    {
                        global $conn;
                        $query = "SELECT `ProductName`, `ProductPrice`, `CategoryName`, `StockQuantity`, `ReorderLevel`, `ShelfLocation` FROM `inventory` ORDER BY ProductID DESC LIMIT 5";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            return $result->fetch_all(MYSQLI_ASSOC);
                        } else {
                            return [];
                        }
                    }

                    // Fetch the last 3 products
                    $last3Products = getLast3Products();

                    if (!empty($last3Products)) {
                        echo "<h4>Recent Products:</h4>";
                        echo "<table class='table'>";
                        echo "<thead><tr><th>ProductName</th><th>ProductPrice</th><th>CategoryName</th><th>StockQuantity</th><th>ReorderLevel</th><th>ShelfLocation</th></tr></thead>";
                        echo "<tbody>";

                        foreach ($last3Products as $product) {
                            echo "<tr>";
                            echo "<td>{$product['ProductName']}</td>";
                            echo "<td>{$product['ProductPrice']}</td>";
                            echo "<td>{$product['CategoryName']}</td>";
                            echo "<td>{$product['StockQuantity']}</td>";
                            echo "<td>{$product['ReorderLevel']}</td>";
                            echo "<td>{$product['ShelfLocation']}</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "<p>No products found.</p>";
                    }
                    ?>
                </div>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>