<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

// Include the database connection
include 'db_connect.php';

// Function to handle service request
function requestAmbulance($username, $name, $address, $phone)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO service_requests (username, name, address, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $name, $address, $phone);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["username"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];

   
    if (!empty($name) && !empty($address) && !empty($phone)) {
        if (requestAmbulance($username, $name, $address, $phone)) {
            $message = "Ambulance request sent successfully!";
        } else {
            $message = "Error sending ambulance request. Please try again.";
        }
    } else {
        $message = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Ambulance Service</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"> 
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Home</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a class="btn btn-danger my-2 my-sm-0" href="logout.php">Logout</a>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Request Ambulance Service</h2>
        <?php if ($message): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="col-md-6">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">Request Ambulance</button>
            </form>
        </div>
    </div>
</body>
</html>
