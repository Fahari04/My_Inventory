<!doctype html>

<head>
    <link rel="icon" href="home.jpeg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>QuickStock</title>
</head>
<style>
    
</style>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand h4 ps-5" href="">My Inventory</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarText">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active h5 px-5" href="">Contact us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active h5 px-5" href="">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active h5 px-5" href="">Help</a>
                    </li>
                    <li class="nav-item h5 px-4">
                        <form method="post" action="login.php">
                            <button type="submit" class="btn btn-primary px-5">
                                <h6 class="m-0 p-1">Sign in</h6>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="center-container">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="my-5">Elevate Your Inventory<br>Control Effortlessly</h1>
                    <h5 class="primary" style="color: #55ACEE;">Welcome to our Store Inventory Management System! Streamline your
                        business operations with our powerful and user-friendly solution.
                        Effortlessly manage inventory, track products, and optimize stock levels.
                        Take control of your store's efficiency and enhance your overall business performance.
                        Experience simplicity and effectiveness in inventory management with our dedicated system.
                    </h5>
                    <a href='register.php' class="text-decoration-none">
                        <button type="submit" name="get_started" class="btn btn-dark my-5 px-5 d-flex justify-content-between">
                            <h5 class="m-0 p-2">Get Started</h5>
                            <img style="padding-left: 8px;padding-top: 10px;width: 30px;" src="right-arrow.png" alt="Right Arrow">
                        </button>
                    </a>
                </div>
                <div class="col-md-6">
                    <img src="home.jpeg" alt="Inventory System Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</body>

</html>