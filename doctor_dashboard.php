<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];

function hasAppointments($doctorName) {
    $appointmentsFile = 'appointments.txt';
    if (file_exists($appointmentsFile)) {
        $appointments = file($appointmentsFile, FILE_IGNORE_NEW_LINES);
        foreach ($appointments as $appointment) {
            $data = explode(",", $appointment);

            if (stripos($data[1], $doctorName) !== false) {
                return true;
            }
        }
    }
    return false;
}

$doctorName = $username;

$hasAppointments = hasAppointments($doctorName);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Welcome, Dr. <?php echo $doctorName; ?></h1>
            <p class="lead">This is your doctor dashboard.</p>
            <hr class="my-4">
            <p>You can navigate to other sections of the website from here.</p>
            <a class="btn btn-primary" href="index.php" role="button">Home</a>
            <a class="btn btn-danger" href="logout.php" role="button">Logout</a>
        </div>

        <?php if ($hasAppointments): ?>
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">You have appointments!</h4>
            <hr>
            <ul>
                <?php
                $appointmentsFile = 'appointments.txt';
                $appointments = file($appointmentsFile, FILE_IGNORE_NEW_LINES);
                foreach ($appointments as $appointment) {
                    $data = explode(",", $appointment);
                    // Check if the doctor's name appears in the appointment data
                    if (stripos($data[1], $doctorName) !== false) {
                        echo "<li>{$data[0]} has an appointment booked with you at {$data[2]} on {$data[3]}</li>";
                    }
                }
                ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
