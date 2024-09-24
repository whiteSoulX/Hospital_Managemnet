<?php
session_start();


if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}


include 'db_connect.php';

function getDoctorList($conn) {
    $doctors = [];
    $sql = "SELECT username, specialization FROM doctors";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $doctors[] = ['name' => $row['username'], 'field' => $row['specialization']];
        }
    }
    return $doctors;
}

function saveAppointment($conn, $username, $doctorName, $date, $time) {
    $sql = "INSERT INTO appointments (username, doctor_name, appointment_date, appointment_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $doctorName, $date, $time);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedDoctor = $_POST["doctor"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $username = $_SESSION["username"];
    saveAppointment($conn, $username, $selectedDoctor, $date, $time);
    header("Location: user_dashboard.php");
    exit;
}

$doctorList = getDoctorList($conn);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="appointment.css"> 
</head>
<body>
    <div class="container">
        <div class="nav-buttons">
            <a href="index.php" class="btn btn-info btn-home"><i class="fas fa-home"></i> Home</a>
            <?php if (isset($_SESSION['username'])) { ?>
            <a href="<?php echo ($_SESSION['role'] == 'user') ? 'user_dashboard.php' : (($_SESSION['role'] == 'doctor') ? 'doctor_dashboard.php' : 'admin_dashboard.php'); ?>" class="btn btn-warning">
                Dashboard
            </a>
            <?php } ?>
        </div>

        <div class="card">
            <h2 class="text-center">Book an Appointment</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="doctor">Select Doctor:</label>
                    <select class="form-control" id="doctor" name="doctor" required>
                        <option value="" disabled selected>Select Doctor</option>
                        <?php foreach ($doctorList as $doctor) : ?>
                            <option value="<?php echo $doctor['name']; ?>">
                                <?php echo $doctor['name'] . ' - ' . $doctor['field']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="date">Date:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="time">Time:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block mt-4">
                    <i class="fas fa-check"></i> Book Appointment
                </button>
            </form>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
