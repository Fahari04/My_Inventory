<?php
// Include the configuration file
include 'config.php';

// Get user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$query = "SELECT `id`, `name`, `username`, `email`, `mobile`, `date_of_birth` FROM `user_form` WHERE `id` = $user_id";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch user details
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle error if query fails
    die('Query failed: ' . mysqli_error($conn));
}

// Update user details if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['new_name'];
    $newMobile = $_POST['new_mobile'];
    $newDateOfBirth = $_POST['new_date_of_birth'];

    // Update user details in the database
    $updateQuery = "UPDATE `user_form` SET `name`='$newName', `mobile`='$newMobile', `date_of_birth`='$newDateOfBirth' WHERE `id` = $user_id";

    if (mysqli_query($conn, $updateQuery)) {
        // Update successful, redirect to profile page
        header("Location: Profile.php");
        exit();
    } else {
        // Handle error if the update fails
        echo "Error updating record: " . mysqli_error($conn);
    }
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
</head>

<body>

    <div class="d-flex">
        <?php include 'navbar.php'; ?>

        <div class="main p-3 vh-100 overflow-hidden transition text-center">
            <!-- User Profile Information -->
            <?php if (!empty($user)) : ?>
                <div class="card mx-auto" style="max-width: 400px;">
                    <div class="card-header">
                        <h5 class="card-title">User Profile</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="new_name" class="form-label">New Name</label>
                                <input type="text" class="form-control" id="new_name" name="new_name" value="<?= $user['name'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="new_mobile" class="form-label">New Mobile</label>
                                <input type="text" class="form-control" id="new_mobile" name="new_mobile" value="<?= $user['mobile'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="new_date_of_birth" class="form-label">New Date of Birth</label>
                                <input type="date" class="form-control" id="new_date_of_birth" name="new_date_of_birth" value="<?= $user['date_of_birth'] ?>">
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
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