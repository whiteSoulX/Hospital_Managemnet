<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit;
}

function addDoctor($name, $field) {
    $doctorsFile = 'doctors.txt';
    $doctorData = fopen($doctorsFile, 'a');
    fwrite($doctorData, "$name,$field\n");
    fclose($doctorData);
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $field = $_POST["field"];
    addDoctor($name, $field);
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Doctor</h2>
        <div class="col-md-6">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Doctor's Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter doctor's name" required>
                </div>
                <div class="mb-3">
                    <label for="field" class="form-label">Field</label>
                    <input type="text" class="form-control" id="field" name="field" placeholder="Enter doctor's field" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Doctor</button>
            </form>
        </div>
    </div>
</body>
</html>
