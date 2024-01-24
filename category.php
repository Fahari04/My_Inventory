<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "My_Inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addCategory"])) {
    $newCategoryName = $conn->real_escape_string($_POST["categoryName"]);
   
    // Check if the customer already exists
    $checkCategoryrQuery = "SELECT * FROM Category WHERE CustomerName = '$newCategoryName'";
    $existingCategoryResult = $conn->query( $checkCategoryrQuery);

    if ($existingCategoryResult->num_rows > 0) {
        echo "<p class='alert alert-warning'>Customer with the name '$newCategoryName' already exists.</p>";
    } else {
        // If the customer does not exist, insert into the database
        $insertCategoryQuery = "INSERT INTO Category (CategoryName, CategoryID) 
                                VALUES ('$newCategoryName', '$newCategoryID')";

        if ($conn->query($insertCategoryQuery) === TRUE) {
            echo "<p class='alert alert-success'>New customer added successfully!</p>";
        } else {
            echo "<p class='alert alert-danger'>Error adding customer: " . $conn->error . "</p>";
        }
    }
}

// Handle remove customer by searching form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["removeCategorySearchBtn"])) {
    $searchRemoveCategoryName = $conn->real_escape_string($_POST["searchRemoveCategory"]);

    $deleteCategoryQuery = "DELETE FROM Category WHERE CategoryName = '$searchRemoveCategoryName'";

    if ($conn->query( $deleteCategoryQuery) === TRUE) {
        echo "<p class='alert alert-success'>Customer removed successfully! Deleted CustomerName: $searchRemoveCategoryName</p>";
    } else {
        echo "<p class='alert alert-danger'>Error removing customer: " . $conn->error . "</p>";
    }
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

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            include 'navbar.php';
            ?>

             <div class="col-md-12">

                <div class="bg-light flex-fill">
                    <div class="p-2 d-md-none d-flex text-white bg-success">
                        <a href="#" class="text-success" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
                            <i class="fas fa-bars"></i>
                        </a>
                    </div>

                    <div class="p-4">
                        <h4 class="mb-4">Category Management</h4>

                        <!-- Search Form -->
                        <form class="mb-4" method="GET" action="">
                            <div class="input-group">
                                <input type="search" class="form-control" placeholder="Search by Customer Name" aria-label="Search" name="search">
                                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>

                        <!-- Search Results -->
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
                            $searchTerm = $conn->real_escape_string($_GET["search"]);
                            $searchQuery = ("SELECT * FROM Category WHERE CategoryName LIKE '%$searchTerm%'");
                            $searchResult = $conn->query($searchQuery);

                            if ($searchResult->num_rows > 0) {
                                echo "<h6 class='mb-3'>Search Results:</h6>";
                                echo "<table class='table'>";
                                echo "<thead><tr><th>CategoryID</th><th>CategoryName</th></thead>";
                                echo "<tbody>";

                                while ($row = $searchResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['CustomerID'] . "</td>";
                                    echo "<td>" . $row['CustomerName'] . "</td>";
                                    echo "</tr>";
                                }

                                echo "</tbody></table>";
                            } else {
                                echo "<p class='alert alert-info'>No results found for the search term: $searchTerm</p>";
                            }
                        }
                        ?>

                        <!-- Full Customer Table -->
                        <?php
                        $fullTableQuery = "SELECT * FROM Category";
                        $fullTableResult = $conn->query($fullTableQuery);

                        if ($fullTableResult->num_rows > 0) {
                            echo "<h6 class='mb-3'>Category Table:</h6>";
                            echo "<table class='table'>";
                            echo "<thead><tr><th>CategoryID</th><th>CategoryName</th></thead>";
                            echo "<tbody>";

                            while ($row = $fullTableResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['CategoryID'] . "</td>";
                                echo "<td>" . $row['CategoryName'] . "</td>";
                                echo "</tr>";
                            }

                            echo "</tbody></table>";
                        } else {
                            echo "<p class='alert alert-info'>No customers found.</p>";
                        }
                        ?>

                        <!-- Add New Customer Form -->
                        <form method="POST" action="" class="mb-4">
                            <h4 class="mb-3">Add New Category</h4>
                          
                            <div class="mb-3">
                                <label for="contactInfo" class="form-label">Category Name:</label>
                                <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                            </div>
                           
                            <button type="submit" class="btn btn-primary" name="addCategory">Add Category</button>
                        </form>

                        <!-- Remove Customer Form -->
                        <form method="POST" action="">
                            <h4 class="mb-3">Remove Category by Searching</h4>
                            <div class="mb-3">
                                <label for="searchRemoveCategory" class="form-label">Enter Category Name to Remove:</label>
                                <input type="text" class="form-control" id="searchRemoveCategory" name="searchRemoveCategory" required>
                            </div>
                            <button type="submit" class="btn btn-danger" name="removeCategorySearchBtn">Remove Category</button>
                        </form>
                    </div>
                </div>
            </div>

            
                ?> 
            
        </div>

    </div>

    <!-- Your existing JavaScript and Bootstrap script includes -->
</body>

</html>