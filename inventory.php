<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "My_Inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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
    <style>
        html,
        body {
            height: 100%;
            font-family: 'Ubuntu', sans-serif;
        }

        .mynav {
            color: #fff;
        }

        .mynav li a {
            color: #fff;
            text-decoration: none;
            width: 100%;
            display: block;
            border-radius: 5px;
            padding: 8px 5px;
        }

        .mynav li a.active {
            background: rgba(255, 255, 255, 0.2);
        }

        .mynav li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .mynav li a i {
            width: 25px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php
            include 'navbar.php';
            ?>

            <div class="col-md-8">

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
                                <input class="form-control me-2" type="search" placeholder="Search by ProductID" aria-label="Search" name="search">
                                <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-search"></i></button>
                            </form>
                            <!-- End of search form -->

                            <!-- PHP code for search results -->
                            <?php
                            // ... (your existing code)
                            // PHP code for search by category
                            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
                                $searchTerm = $conn->real_escape_string($_GET["search"]);
                                $searchQuery = "SELECT * FROM Inventory WHERE  ProductID LIKE '%$searchTerm%'";
                                $searchResult = $conn->query($searchQuery);

                                if ($searchResult->num_rows > 0) {
                                    echo "<h4>Search Results:</h4>";
                                    echo "<table class='table'>";
                                    echo "<thead><tr><th>ProductID</th><th>SupplierID</th><th>ProductName</th><th>ProductPrice</th><th>StockQuantity</th><th>ReorderLevel</th><th>ShelfLocation</th><th>LastRestockDate</th><th>ExpiryDate</th></tr></thead>";
                                    echo "<tbody>";

                                    while ($row = $searchResult->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['ProductID'] . "</td>";
                                        echo "<td>" . $row['SupplierID'] . "</td>";
                                        echo "<td>" . $row['ProductName'] . "</td>";
                                        echo "<td>" . $row['ProductPrice'] . "</td>";
                                        echo "<td>" . $row['StockQuantity'] . "</td>";
                                        echo "<td>" . $row['ReorderLevel'] . "</td>";
                                        echo "<td>" . $row['ShelfLocation'] . "</td>";
                                        echo "<td>" . $row['LastRestockDate'] . "</td>";
                                        echo "<td>" . $row['ExpiryDate'] . "</td>";
                                        echo "</tr>";
                                    }

                                    echo "</tbody></table>";
                                } else {
                                    echo "<p>No results found for the search term: $searchTerm</p>";
                                }
                            }
                            // PHP code for table and search
                            $fullTableQuery = "SELECT * FROM Inventory";
                            $fullTableResult = $conn->query($fullTableQuery);

                            if ($fullTableResult->num_rows > 0) {
                                echo "<h4>Full Inventory Table:</h4>";
                                echo "<table class='table'>";
                                echo "<thead><tr><th>ProductID</th><th>SupplierID</th><th>ProductName</th><th>ProductPrice</th><th>StockQuantity</th><th>ReorderLevel</th><th>ShelfLocation</th><th>LastRestockDate</th><th>ExpiryDate</th></tr></thead>";
                                echo "<tbody>";

                                while ($row = $fullTableResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['ProductID'] . "</td>";
                                    echo "<td>" . $row['SupplierID'] . "</td>";
                                    echo "<td>" . $row['ProductName'] . "</td>";
                                    echo "<td>" . $row['ProductPrice'] . "</td>";
                                    echo "<td>" . $row['StockQuantity'] . "</td>";
                                    echo "<td>" . $row['ReorderLevel'] . "</td>";
                                    echo "<td>" . $row['ShelfLocation'] . "</td>";
                                    echo "<td>" . $row['LastRestockDate'] . "</td>";
                                    echo "<td>" . $row['ExpiryDate'] . "</td>";
                                    echo "</tr>";
                                }

                                echo "</tbody></table>";
                            } else {
                                echo "<p>No suppliers found.</p>";
                            }


                            ?>
                            <!-- End of PHP code -->

                        </nav>
                    </div>
                </div>

            </div>
        </div>

    </div>


    </div>

    <!-- Your existing JavaScript and Bootstrap script includes -->
</body>

</html>