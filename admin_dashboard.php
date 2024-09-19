<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Welcome, Administrator <?php echo $username; ?></h1>
            <p class="lead">This is your admin dashboard.</p>
            <hr class="my-4">
            <p>You can add doctors to specific fields from here.</p>
            <a class="btn btn-primary" href="add_doctor.php" role="button">Add Doctor</a>
            <a class="btn btn-danger" href="logout.php" role="button">Logout</a>
        </div>
    </div>
</body>
</html>
