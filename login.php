<?php
include("./db_connect.php");

function login($email, $password, $user_type)
{
    global $conn;
    if ($user_type == "user") {
        $sql = "SELECT * FROM users where email = ?";
    } else if ($user_type == "doctor") {
        $sql = "SELECT * FROM doctors where email = ?";
    } else if ($user_type == "admin") {
        $sql = "SELECT * FROM admin where email = ?";
    }

    try {
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_all(MYSQLI_ASSOC);

            if (password_verify($password, $user[0]['password'])) {
                session_start();
                $_SESSION['username'] = $user[0]['username'];
                $_SESSION['role'] = $user_type;

                if ($user_type == "user") {
                    header("Location: user_dashboard.php");
                } else if ($user_type == "doctor") {
                    header("Location: doctor_dashboard.php");
                } else if ($user_type == "admin") {
                    header("Location: admin_dashboard.php");
                }
            }
        }
    } catch (\Throwable $th) {
        echo ($th);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    //print_r($_POST);

    login($email, $password, $user_type);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/Loginstyles.css">
</head>

<body>

    <div class="container">
        <div class="login-container">
            <h2 class="login-title">Please Login</h2>
            <form class="login-form" method="post">
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
                <?php if (isset($login_err)) { ?>
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
