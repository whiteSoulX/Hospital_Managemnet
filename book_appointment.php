<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

function getDoctorList() {
    $doctorsFile = 'doctors.txt';
    $doctors = [];
    if (file_exists($doctorsFile)) {
        $lines = file($doctorsFile, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $data = explode(",", $line);
            $doctors[] = ['name' => $data[0], 'field' => $data[1]];
        }
    }
    return $doctors;
}

function saveAppointment($username, $doctorName, $date, $time) {
    $appointmentsFile = 'appointments.txt';
    $appointmentData = "$username,$doctorName,$date,$time\n";
    file_put_contents($appointmentsFile, $appointmentData, FILE_APPEND | LOCK_EX);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedDoctor = $_POST["doctor"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $username = $_SESSION["username"];
    saveAppointment($username, $selectedDoctor, $date, $time);
    header("Location: user_dashboard.php");
    exit;
}

$doctorList = getDoctorList();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
        }
        .form-control {
            border-radius: 30px;
        }
        .btn-primary {
            border-radius: 30px;
        }
        .card {
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: bold;
        }
        .input-group-text {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2 class="text-center">Book an Appointment</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="doctor">Select Doctor:</label>
                    <select class="form-control" id="doctor" name="doctor" required>
                        <option value="" disabled selected>Select Doctor</option>
                        <?php foreach ($doctorList as $doctor) : ?>
                            <option value="<?php echo $doctor['name']; ?>"><?php echo $doctor['name'] . ' - ' . $doctor['field']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a doctor.</div>
                </div>
                
                <div class="form-group">
                    <label for="date">Date:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="invalid-feedback">Please choose a valid date.</div>
                </div>

                <div class="form-group">
                    <label for="time">Time:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        </div>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                    <div class="invalid-feedback">Please choose a valid time.</div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-check"></i> Book Appointment</button>
            </form>
        </div>
    </div>

    <!-- JQuery, Bootstrap JS, and Font Awesome -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom script for form validation -->
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>
