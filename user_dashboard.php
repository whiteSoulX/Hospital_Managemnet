<?php
session_start();


if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}


include 'db_connect.php';

function getBookedAppointments($conn, $username)
{
    $appointments = [];
    $sql = "SELECT doctor_name, appointment_date, appointment_time FROM appointments WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $appointments[] = [
                'doctor' => $row['doctor_name'],
                'date' => $row['appointment_date'],
                'time' => $row['appointment_time']
            ];
        }
    }
    return $appointments;
}


$username = $_SESSION["username"];
$userAppointments = getBookedAppointments($conn, $username);


$conn->close();
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

        <?php if (!empty($userAppointments)) { ?>
            <h4>Your Appointments:</h4>
            <div class="row">
                <?php foreach ($userAppointments as $appointment) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card appointment-card">
                            <div class="card-body">
                                <h5 class="card-title">Appointment with Dr. <?php echo $appointment['doctor']; ?></h5>
                                <p class="card-text">
                                    <strong>Date:</strong> <?php echo $appointment['date']; ?><br>
                                    <strong>Time:</strong> <?php echo $appointment['time']; ?>
                                </p>
                                <a href="doctor_details.php?doctor=<?php echo urlencode($appointment['doctor']); ?>" class="btn btn-primary">View Details</a>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div style="opacity: 1;" class="alert alert-warning" role="alert">
                You don't have any appointments
                <a class="btn-primary btn-lg btn" href="./book_appointment.php">Book Appointment</a>
            </div>
        <?php } ?>

        <a href="index.php" class="btn btn-primary">Home</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
