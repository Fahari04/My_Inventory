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

        .dropdown-menu a {
            color: #000;
        }

        .dropdown-menu a:hover {
            background-color: #e0e0e0;
            /* Change this to the desired hover background color for other submenu items */
            color: #000;
            /* Change this to the desired hover text color for other submenu items */
        }

        /* Custom styles for Add and Manage submenu items */
        .dropdown-menu a.add-item,
        .dropdown-menu a.manage-item {
            background-color: #007bff;
            /* Change this to the desired background color (blue) for Add and Manage */
            color: #fff;
            /* Change this to the desired text color for Add and Manage */
        }

        .dropdown-menu a.add-item:hover,
        .dropdown-menu a.manage-item:hover {
            background-color: #007bff;
            /* Keep the same background color on hover for Add and Manage */
        }

        /* Add fixed-top class to make the navbar fixed at the top */
        #bdSidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
        }

        /* Add some padding to the content to avoid being hidden under the fixed navbar */
        .bg-light {
            padding-left: 280px;
        }
    </style>
</head>

<body>

    <div class="col-md-2">
        <nav class="">
            <div id="bdSidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-primary text-white offcanvas-md offcanvas-start" style="width: 280px;">
                <a href="#" class="navbar-brand">
                    <h5><i class="fa-solid fa-bomb me-2" style="font-size: 28px;"></i>My Inventory</h5>
                </a>
                <hr>

                <ul class="mynav nav nav-pills flex-column mb-auto">
                    <li class="nav-item mb-1">
                        <a href="dashboard.php" class="">
                            <i class="fa-solid fa-gauge"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-1">

                        <a href="category.php" class="">
                            <i class="fa-brands fa-product-hunt"></i>
                            Category
                        </a>
                        <!-- Add your dropdown menu content here -->

                    </li>
                    <li class="nav-item mb-1">

                        <a href="inventory.php" class="">
                            <i class="fa-solid fa-house"></i>
                            Inventory
                        </a>
                        <!-- Add your dropdown menu content here -->

                    </li>
                    <li class="nav-item mb-1">
                        <a href="Orders.php" class="">
                            <i class="fa-solid fa-box"></i>
                            Orders
                        </a>
                    </li>

                    <li class="nav-item mb-1">
                        <a href="customers.php" class="">
                            <i class="fa-solid fa-person-walking-luggage"></i>
                            Customers
                        </a>
                    </li>

                    <li class="nav-item mb-1">
                        <a href="Supplier.php" class="">
                            <i class="fa-solid fa-boxes-packing"></i>
                            Supplier
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="Employee.php" class="">
                            <i class="fa-regular fa-user"></i>
                            Employee
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="d-flex">
                    <img src="img/login.jpg" class="img-fluid rounded me-2" width="50px" alt="">
                    <span>
                        <h3 class="mt-1 mb-0">Admin</h3>
                    </span>
                </div>
            </div>

            <div class="bg-light flex-fill">
                <div class="p-2 d-md-none d-flex text-white bg-primary">
                    <a href="#" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </div>
                <!-- Your main content here -->
            </div>
        </nav>


    </div>

</body>

</html>