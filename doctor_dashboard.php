<?php
session_start();


if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}


include 'db_connect.php';


$username = $_SESSION["username"];


function getDoctorDetails($conn, $username) {
    $sql = "SELECT username FROM doctors WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();  
    } else {
        return null;
    }
}

$doctorDetails = getDoctorDetails($conn, $username);


if ($doctorDetails) {
    $doctorName = $doctorDetails['username']; 
    
    function getDoctorAppointments($conn, $doctorName) {
        $appointments = [];
        $sql = "SELECT username, appointment_date, appointment_time FROM appointments WHERE doctor_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $doctorName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $appointments[] = $row;
            }
        }
        return $appointments;
    }

    $appointments = getDoctorAppointments($conn, $doctorName);
} else {
   
    echo "Doctor not found!";
    exit;
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/doctor_dash.css"> 
</head>
<body>
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Welcome, Dr. <?php echo htmlspecialchars($doctorName); ?></h1>
            <p class="lead">This is your doctor dashboard.</p>
            <hr class="my-4">
           
            <a class="btn btn-success" href="index.php" role="button">Home</a>
            <a class="btn btn-primary" href="doctorprofile.php" role="button">Profile</a>
            <a class="btn btn-danger" href="logout.php" role="button">Logout</a>
        </div>

        
        <?php if (!empty($appointments)): ?>
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">You have appointments!</h4>
            <hr>
            <ul>
                <?php foreach ($appointments as $appointment): ?>
                    <li><?php echo htmlspecialchars($appointment['username']); ?> has an appointment booked with you at <?php echo htmlspecialchars($appointment['appointment_time']); ?> on <?php echo htmlspecialchars($appointment['appointment_date']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php else: ?>
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">No appointments!</h4>
            <p>You currently have no appointments.</p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
