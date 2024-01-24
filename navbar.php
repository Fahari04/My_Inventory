<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-enntExn2ZX5f4kdaX4RUTtKYaVMTI6q81Ce5DPf4Xb6P5aWVjJVT2EEbF6A/Pq2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="dashboard.php">My Inventory</a>
            </div>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="dashboard.php" class="sidebar-link">
                    <i class="lni lni-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-coin"></i>
                    <span>Transaction</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#inventory" aria-expanded="false" aria-controls="inventory">
                    <i class="lni lni-graph"></i>
                    <span>Inventory</span>
                </a>
                <ul id="inventory" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="category.php" class="sidebar-link">
                            <i class="lni lni-tab"></i>
                            Category</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="AllProduct.php" class="sidebar-link">
                            <i class="lni lni-cart"></i>
                            All Products</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="AddProduct.php" class="sidebar-link">
                            <i class="lni lni-plus"></i>
                            Add Products</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#purchase" aria-expanded="false" aria-controls="purchase">
                    <i class="lni lni-dollar"></i>
                    <span>Purchase</span>
                </a>
                <ul id="purchase" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="Purchase.php" class="sidebar-link">
                            <i class="lni lni-dollar"></i>
                            Purchase</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="Supplier.php" class="sidebar-link">
                            <i class="lni lni-target-customer"></i>
                            Supplier</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#sale" aria-expanded="false" aria-controls="sale">
                    <i class="lni lni-money-location"></i>
                    <span>Sale</span>
                </a>
                <ul id="sale" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="lni lni-money-location"></i>
                            Sale</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="customers.php" class="sidebar-link">
                            <i class="lni lni-customer"></i>
                            Customers</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="Employee.php" class="sidebar-link">
                    <i class="lni lni-network"></i>
                    <span>Employee</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-protection"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <a href="#" class="sidebar-link">
                <i class="lni lni-exit"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
<script>
    const hamBurger = document.querySelector(".toggle-btn");

    hamBurger.addEventListener("click", function() {
        document.querySelector("#sidebar").classList.toggle("expand");
    });
</script>


</html>