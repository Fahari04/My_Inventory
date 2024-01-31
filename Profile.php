<?php
include 'config.php';
// Get user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$query = "SELECT `id`, `name`, `username`, `email`, `password`, `mobile`, `date_of_birth`, `image` FROM `user_form` WHERE `id` = $user_id";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch user details
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle error if query fails
    die('Query failed: ' . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Custom style to center the card */
        .center-card {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <?php include 'navbar.php'; ?>

        <div class="main p-3 vh-100 transition text-center">
            
            <?php if (!empty($user)) : ?>
                <div class="card center-card" style="max-width: 800px;" >
                    <div class="card-header">
                        <h5 class="card-title">User Profile</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Name:</strong> <?= $user['name'] ?></p>
                        <p class="card-text"><strong>Username:</strong> <?= $user['username'] ?></p>
                        <p class="card-text"><strong>Email:</strong> <?= $user['email'] ?></p>
                        <p class="card-text"><strong>Mobile:</strong> <?= $user['mobile'] ?></p>
                        <p class="card-text"><strong>Date of Birth:</strong> <?= $user['date_of_birth'] ?></p>

                        <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
                    </div>
                </div>
            <?php else : ?>
                <p>User not found.</p>
            <?php endif; ?>
        </div>

    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-wLXUE/UMIzQ7gDQDmIX/87uXNBs4Ii4sAo1MfJvOVkM1ZJ5+3ZsFJMQfMHAsjJPq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-eNMAF7odTPRn3QSS/Cs7L4Iewea8hMli3KbSS8pcML+L0WsruCUwW1fK6tu5PI3W" crossorigin="anonymous"></script>
</body>

</html>
