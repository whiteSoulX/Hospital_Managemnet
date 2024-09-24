<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION["username"])) {
    header("Location: doctor_login.php");
    exit;
}

$username = $_SESSION["username"];


function getDoctorProfile($conn, $username) {
    $sql = "SELECT * FROM doctors_profile WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['full_name'];
    $department = $_POST['department'];
    $degree = $_POST['degree'];
    $phoneNumber = $_POST['phone_number'];

    $sql = "REPLACE INTO doctors_profile (username, full_name, department, degree, phone_number)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $fullName, $department, $degree, $phoneNumber);
    $stmt->execute();

    header("Location: doctorprofile.php");
    exit;
}


$doctorProfile = getDoctorProfile($conn, $username);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php if (!$doctorProfile): ?>
           
            <h2>Update Your Profile</h2>
            <form method="POST" action="doctorprofile.php">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" class="form-control" id="department" name="department" required>
                </div>
                <div class="form-group">
                    <label for="degree">Degree</label>
                    <input type="text" class="form-control" id="degree" name="degree" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                </div>
                <button type="submit" class="btn btn-primary">Save Profile</button>
            </form>
        <?php else: ?>
            
            <h2>Your Profile</h2>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($doctorProfile['full_name']); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($doctorProfile['department']); ?></p>
            <p><strong>Degree:</strong> <?php echo htmlspecialchars($doctorProfile['degree']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($doctorProfile['phone_number']); ?></p>

            <a href="doctor_dashboard.php" class="btn btn-primary">Go to Dashboard</a>
        <?php endif; ?>
    </div>
</body>
</html>
