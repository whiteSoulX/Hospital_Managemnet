<?php
session_start();

function getDoctorsList() {
    $doctorsFile = 'doctors.txt';
    $ratingsFile = 'ratings.txt';
    $doctors = [];

    if (file_exists($doctorsFile)) {
        $lines = file($doctorsFile, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $data = explode(",", $line);
            $doctor = [
                'name' => $data[0],
                'field' => $data[1],
                'rating' => 0,
                'ratingCount' => 0
            ];

            if (!array_key_exists($data[1], $doctors)) {
                $doctors[$data[1]] = [];
            }

            $doctors[$data[1]][] = $doctor;
        }
    }

    if (file_exists($ratingsFile)) {
        $lines = file($ratingsFile, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $data = explode(",", $line);
            $doctorName = $data[0];
            $rating = (int)$data[2];

            foreach ($doctors as &$field) {
                foreach ($field as &$doctor) {
                    if ($doctor['name'] === $doctorName) {
                        $doctor['rating'] += $rating;
                        $doctor['ratingCount']++;
                        break;
                    }
                }
            }
        }
    }

    foreach ($doctors as &$field) {
        foreach ($field as &$doctor) {
            if ($doctor['ratingCount'] > 0) {
                $doctor['rating'] = $doctor['rating'] / $doctor['ratingCount'];
            }
        }
    }

    return $doctors;
}

function displayDoctorsList($doctors) {
    foreach ($doctors as $field => $fieldDoctors) {
        echo '<h3 class="text-primary">' . $field . '</h3>';
        foreach ($fieldDoctors as $doctor) {
            echo '<div class="card mb-3 shadow-sm">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title"><i class="fas fa-user-md"></i> ' . $doctor['name'] . '</h5>';
            echo '<p class="card-text"><strong>Field:</strong> ' . $doctor['field'] . '</p>';
            if ($doctor['rating'] > 0) {
                echo '<p class="card-text"><strong>Rating:</strong> <span class="badge badge-warning">' . number_format($doctor['rating'], 1) . '</span></p>';
            } else {
                echo '<p class="card-text"><strong>Rating:</strong> <span class="badge badge-secondary">No ratings yet</span></p>';
            }
            echo '<a href="doctor_profile.php?doctor=' . urlencode($doctor['name']) . '" class="btn btn-outline-primary mr-2"><i class="fas fa-info-circle"></i> Profile</a>';
            echo '<a href="rate_doctor.php?doctor=' . urlencode($doctor['name']) . '" class="btn btn-outline-success mr-2"><i class="fas fa-star"></i> Rate</a>';
            echo '<a href="book_appointment.php?doctor=' . urlencode($doctor['name']) . '" class="btn btn-outline-info"><i class="fas fa-calendar-alt"></i> Book Appointment</a>';
            echo '</div></div>';
        }
    }
}

$doctorsList = getDoctorsList();

if (isset($_GET['department']) && !empty($_GET['department'])) {
    $selectedDepartment = $_GET['department'];
    $doctorsList = array_filter($doctorsList, function($field) use ($selectedDepartment) {
        return $field == $selectedDepartment;
    }, ARRAY_FILTER_USE_KEY);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            border-radius: 12px;
        }
        .form-control {
            border-radius: 25px;
        }
        .btn-outline-primary, .btn-outline-success, .btn-outline-info {
            border-radius: 20px;
        }
        h2, h3 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center text-info">Our Doctors</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="mb-3">
            <div class="form-group">
                <label for="department" class="font-weight-bold">Select Department:</label>
                <select name="department" id="department" class="form-control" onchange="this.form.submit()">
                    <option value="">All Departments</option>
                    <?php
                    foreach ($doctorsList as $field => $fieldDoctors) {
                        echo '<option value="' . $field . '" ' . (isset($_GET['department']) && $_GET['department'] === $field ? 'selected' : '') . '>' . $field . '</option>';
                    }
                    ?>
                </select>
            </div>
        </form>

        <div class="row">
            <div class="col-md-12">
                <?php displayDoctorsList($doctorsList); ?>
            </div>
        </div>
    </div>

    <!-- JQuery, Popper.js, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
