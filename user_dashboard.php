<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

function getBookedAppointments() {
    $appointmentsFile = 'appointments.txt';
    $userAppointments = [];
    if (file_exists($appointmentsFile)) {
        $appointments = file($appointmentsFile, FILE_IGNORE_NEW_LINES);
        foreach ($appointments as $appointment) {
            $data = explode(",", $appointment);
            if ($data[0] === $_SESSION["username"]) {
                $userAppointments[] = [
                    'doctor' => $data[1],
                    'date' => $data[2],
                    'time' => $data[3]
                ];
            }
        }
    }
    return $userAppointments;
}

$username = $_SESSION["username"];
$userAppointments = getBookedAppointments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .appointment-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .appointment-card:hover {
            transform: translateY(-5px);
        }
        .card-body h5 {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>User Dashboard</h2>
        <p>Welcome, <?php echo $username; ?>!</p>
        
        <?php if (!empty($userAppointments)): ?>
            <h4>Your Appointments:</h4>
            <div class="row">
                <?php foreach ($userAppointments as $appointment): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card appointment-card">
                            <div class="card-body">
                                <h5 class="card-title">Appointment with Dr. <?php echo $appointment['doctor']; ?></h5>
                                <p class="card-text">
                                    <strong>Date:</strong> <?php echo $appointment['date']; ?><br>
                                    <strong>Time:</strong> <?php echo $appointment['time']; ?>
                                </p>
                                <a href="#" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                You don't have any appointments booked.
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn btn-primary">Home</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
