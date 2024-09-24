<?php
session_start();
$doctorName = isset($_GET['doctor']) ? $_GET['doctor'] : '';


$profileFile = 'doctor_profiles.txt';


function getDoctorProfile($doctorName) {
    global $profileFile;
    if (file_exists($profileFile)) {
        $lines = file($profileFile, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $data = explode(",", $line);
            if ($data[0] === $doctorName) {
                return [
                    'name' => $data[0],
                    'degree' => $data[1],
                    'department' => $data[2],
                    'address' => $data[3],
                    'phone' => $data[4]
                ];
            }
        }
    }
    return null;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $degree = $_POST['degree'];
    $department = $_POST['department'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    
    $lines = file_exists($profileFile) ? file($profileFile, FILE_IGNORE_NEW_LINES) : [];
    $updated = false;

    foreach ($lines as &$line) {
        $data = explode(",", $line);
        if ($data[0] === $doctorName) {
            $line = "$doctorName,$degree,$department,$address,$phone"; 
            $updated = true;
            break;
        }
    }

    if (!$updated) {
        
        $lines[] = "$doctorName,$degree,$department,$address,$phone";
    }

    file_put_contents($profileFile, implode("\n", $lines)); 
    $profile = getDoctorProfile($doctorName); 
}


$profile = getDoctorProfile($doctorName);
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
    <?php if ($profile): ?>
       
        <h2 class="text-primary">Profile of Dr. <?php echo htmlspecialchars($profile['name']); ?></h2>
        <p><strong>Degree:</strong> <?php echo htmlspecialchars($profile['degree']); ?></p>
        <p><strong>Department:</strong> <?php echo htmlspecialchars($profile['department']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($profile['address']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($profile['phone']); ?></p>
    <?php else: ?>
        
        <h2 class="text-danger">No profile found for Dr. <?php echo htmlspecialchars($doctorName); ?></h2>
        <p>Please fill out your profile details below:</p>
        <form method="POST" action="">
            <div class="form-group">
                <label for="degree">Degree</label>
                <input type="text" name="degree" id="degree" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" name="department" id="department" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Profile</button>
        </form>
    <?php endif; ?>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
