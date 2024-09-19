<?php
session_start();

if (isset($_SESSION["username"])) {
    $welcome_message = "Welcome, " . $_SESSION["username"];
    $login_logout_link = '<a class="btn btn-outline-light my-2 my-sm-0" href="logout.php">Logout</a>';
} else {
    $login_logout_link = '<div class="dropdown">
        <button class="btn btn-outline-light my-2 my-sm-0 dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Sign Up</button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="user_signup.php">Sign Up as User</a></li>
            <li><a class="dropdown-item" href="doctor_signup.php">Sign Up as Doctor</a></li>
            <li><a class="dropdown-item" href="admin_signup.php">Sign Up as Administrator</a></li>
        </ul>
    </div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <!-- Custom CSS for additional styling -->
  <style>
      body {
          background-color: #f0f8ff;
      }
      .navbar {
          background-color: #343a40 !important;
      }
      .jumbotron {
          background: linear-gradient(45deg, #4caf50, #2196f3);
          color: white;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }
      .jumbotron h1, .jumbotron p {
          text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
      }
      .btn-lg {
          padding: 15px 30px;
          font-size: 1.25rem;
      }
      .icon {
          font-size: 1.5rem;
          margin-right: 10px;
      }
      .card {
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease;
      }
      .card:hover {
          transform: translateY(-5px);
      }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="fas fa-hospital-alt"></i> AL-JOHA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <?php echo isset($login_logout_link) ? $login_logout_link : ''; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="jumbotron p-5">
    <h1 class="display-4">Welcome to Al-Joha Hospital</h1>
    <p class="lead">Where your health is our priority.</p>
    <hr class="my-4">
    <p>Log in to access your account or sign up if you're new here.</p>
    <a class="btn btn-primary btn-lg mr-3" href="login.php" role="button"><i class="fas fa-sign-in-alt"></i> Login</a>
    <a class="btn btn-success btn-lg" href="user_signup.php" role="button"><i class="fas fa-user-plus"></i> Sign Up</a>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="card p-4 text-center">
        <h2><i class="fas fa-user-md icon"></i>Doctors</h2>
        <p>View our list of experienced doctors.</p>
        <a class="btn btn-info" href="doctorlist.php" role="button"><i class="fas fa-list"></i> View Doctors</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-4 text-center">
        <h2><i class="fas fa-stethoscope icon"></i>Services</h2>
        <p>Discover the services we offer.</p>
        <a class="btn btn-info" href="work_in_progress.php" role="button"><i class="fas fa-clipboard-list"></i> View Services</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-4 text-center">
        <h2><i class="fas fa-calendar-check icon"></i>Appointments</h2>
        <p>Book an appointment with your preferred doctor.</p>
        <a class="btn btn-info" href="book_appointment.php" role="button"><i class="fas fa-calendar-alt"></i> Book Appointment</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="h<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>"></script>

</body>
</html>
