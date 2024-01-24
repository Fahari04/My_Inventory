<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);

    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $message[] = 'User already exists';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password not matched!';
        } elseif ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, username, email, password, mobile, date_of_birth, image) VALUES('$name', '$username', '$email', '$pass', '$mobile', '$dob', '$image')") or die('Query failed: ' . mysqli_error($conn));

            if ($insert) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_message = 'Registered successfully!';
                header('location: login.php');
            } else {
                $message[] = 'Registration failed! ' . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="icon" href="/assests/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="container mt-5">
        <a href="home.php" class="btn btn-outline-secondary mt-2">Back to Home</a>
        <h3 class="text-center mb-4">Register Now</h3>
        <?php
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<div class="alert alert-danger">' . $message . '</div>';
            }
        }
        ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="user_type" class="form-label">User Type</label>
                        <select name="user_type" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="other">Other</option>
                        </select>
                    </div> -->

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control" placeholder="Confirm password" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn btn-dark">Register Now</button>
                    </div>
                    <p class="text-center">Already have an account? <a href="login.php">Login now</a></p>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Toast for success message -->
    <?php if (isset($success_message)) : ?>
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?php echo $success_message; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bootstrap JS (required) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Activate Toast -->

</body>

</html>