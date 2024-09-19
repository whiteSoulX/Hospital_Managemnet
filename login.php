<?php
session_start();

$userDataFile = 'user_data.txt';
$doctorDataFile = 'doctor_data.txt';
$adminDataFile = 'admins.txt';

function validateUser($email, $password, $userType) {
    global $userDataFile, $doctorDataFile, $adminDataFile;
    $file = '';
    $username = '';

    switch ($userType) {
        case 'user':
            $file = $userDataFile;
            break;
        case 'doctor':
            $file = $doctorDataFile;
            break;
        case 'admin':
            $file = $adminDataFile;
            break;
    }

    if (!file_exists($file)) {
        return [false, $username];
    }

    $data = file($file, FILE_IGNORE_NEW_LINES);
    foreach ($data as $line) {
        $userInfo = explode(",", $line);
        
        if ($userType === 'doctor' && isset($userInfo[0], $userInfo[1], $userInfo[3]) &&
            $userInfo[0] === $email && $userInfo[3] === $password) {
            $username = $userInfo[1];
            return [true, $username];
        } elseif ($userType !== 'doctor' && isset($userInfo[1], $userInfo[2]) &&
            $userInfo[1] === $email && $userInfo[2] === $password) {
            $username = $userInfo[0];
            return [true, $username];
        }
    }
    return [false, $username];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userType = $_POST["user_type"];

    list($valid, $username) = validateUser($email, $password, $userType);
    if ($valid) {
        $_SESSION["username"] = $username;
        $_SESSION["role"] = $userType;

        switch ($userType) {
            case 'user':
                header("Location: user_dashboard.php");
                break;
            case 'doctor':
                header("Location: doctor_dashboard.php");
                break;
            case 'admin':
                header("Location: admin_dashboard.php");
                break;
        }
        exit;
    } else {
        $login_err = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Loginstyles.css">
</head>
<body>

<div class="container">
    <div class="login-container">
        <h2 class="login-title">Please Login</h2>
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <select name="user_type" class="form-select">
                    <option value="user">Login as User</option>
                    <option value="doctor">Login as Doctor</option>
                    <option value="admin">Login as Administrator</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
            <?php if(isset($login_err)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $login_err; ?>
                </div>
            <?php } ?>
            <div class="clearfix">
                <a href="#" class="float-right">Forgot Password?</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
