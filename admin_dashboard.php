<?php
session_start();


if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}


include 'db_connect.php';


$username = $_SESSION["username"];
$email = ""; 
$sql = "SELECT email FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = htmlspecialchars($row['email']);
}


function registerDoctor($username, $email, $specialization, $password)
{
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO doctors (username, email, specialization, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $specialization, $hashed_password);
    if ($stmt->execute()) {
        return "Doctor registered successfully!";
    } else {
        return "Error: " . $stmt->error;
    }
}


function deleteDoctor($doctorId)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $doctorId);
    if ($stmt->execute()) {
        return "Doctor deleted successfully!";
    } else {
        return "Error: " . $stmt->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_doctor'])) {
        $username = $_POST["name"];
        $email = $_POST["email"];
        $specialization = $_POST['specialization'];
        $password = $_POST["password"];

        
        if (!empty($username) && !empty($email) && !empty($specialization) && !empty($password)) {
            $message = registerDoctor($username, $email, $specialization, $password);
        } else {
            $message = "All fields are required!";
        }
    } elseif (isset($_POST['delete_doctor'])) {
        $doctorId = $_POST["doctorId"];
        if (!empty($doctorId)) {
            $message = deleteDoctor($doctorId);
        } else {
            $message = "Doctor ID is required!";
        }
    }
}


$conn->close();
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Welcome, Admin <?php echo htmlspecialchars($username); ?></h1>
            <p class="lead">Email: <?php echo $email; ?></p>
            <hr class="my-4">
        </div>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <h3>Add Doctor</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="name">Doctor Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="specialization">Specialization:</label>
                        <input type="text" class="form-control" id="specialization" name="specialization" placeholder="Enter specialization" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" name="add_doctor" class="btn btn-primary">Add Doctor</button>
                </form>
            </div>

            <div class="col-md-6">
                <h3>Delete Doctor</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="doctorId">Doctor ID:</label>
                        <input type="number" class="form-control" id="doctorId" name="doctorId" placeholder="Enter Doctor ID" required>
                    </div>
                    <button type="submit" name="delete_doctor" class="btn btn-danger">Delete Doctor</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
