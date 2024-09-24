<?php
session_start();
include "db_connect.php";

function registerDoctor($username, $email, $specialization, $password)
{
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
   
    $stmt = $conn->prepare("INSERT INTO doctors (username, email, specialization, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $specialization, $hashed_password);
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["name"];
    $email = $_POST["email"];
    $specialization = $_POST['specialization'];
    $password = $_POST["password"];

    
    if (!empty($username) && !empty($email) && !empty($specialization) && !empty($password)) {
        registerDoctor($username, $email, $specialization, $password);
    } else {
        echo "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Signup</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome for Icons -->
    <style>
        body {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            /* Gradient Background */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signup-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 25px;
        }

        .btn-custom {
            background-color: #6e8efb;
            border-color: #6e8efb;
            color: white;
            border-radius: 25px;
        }

        .btn-custom:hover {
            background-color: #a777e3;
            border-color: #a777e3;
        }

        .form-label {
            font-weight: bold;
        }

        .input-group-text {
            border-radius: 25px;
        }
        .home{
            margin:10px 20px;
            padding:20px;
            font-size:50px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="home">
            <a href="user_dashboard.php" class="dash-btn">
                <button type="button" class="btn btn-success">Log in</button>
            </a>

            <a href="index.php" class="dash-btn">
                <button type="button" class="btn btn-warning">Home</button>
            </a>
        </div>
    <div class="container signup-container">
        <h2 class="text-center mb-4">Doctor Signup</h2>
        <div class="col-md-8 mx-auto">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-briefcase-medical"></i></span>
                    </div>
                    <input type="text" class="form-control" id="specialization" name="specialization" placeholder="Enter specialization" required>
                </div>

                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-custom btn-block">Sign Up</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
