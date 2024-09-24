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

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

 
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="css/index.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="fas fa-hospital-alt"></i> AL-JOHA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <?php if (isset($_SESSION['username'])) { ?>
      <a href="<?php echo ($_SESSION['role'] == 'user') ? 'user_dashboard.php' : (($_SESSION['role'] == 'doctor') ? 'doctor_dashboard.php' : 'admin_dashboard.php'); ?>" class="dash-btn">
        <button type="button" class="btn btn-warning">Dashboard</button>
      </a>
    <?php } ?>

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

      <?php
      if (!isset($_SESSION['username'])) {
        
      ?>
        <a class="btn btn-primary btn-lg mr-3" href="login.php" role="button"><i class="fas fa-sign-in-alt"></i> Login</a>
      <?php
      } else if ($_SESSION['role'] == "user") {
      ?>
        <a class="btn btn-primary btn-lg mr-3" href="user_dashboard.php" role="button"><i class="fas fa-user"></i> User Dashboard</a>
      <?php
      } else if ($_SESSION['role'] == "doctor") {
      ?>
        <a class="btn btn-primary btn-lg mr-3" href="doctor_dashboard.php" role="button"><i class="fas fa-user-md"></i> Doctor Dashboard</a>
      <?php
      } else if ($_SESSION['role'] == "admin") {
      ?>
        <a class="btn btn-primary btn-lg mr-3" href="admin_dashboard.php" role="button"><i class="fas fa-user-shield"></i> Admin Dashboard</a>
      <?php
      }
      ?>
      <a class="btn btn-success btn-lg" href="user_signup.php" role="button"><i class="fas fa-user-plus"></i> Sign Up</a>

    </div>
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
        <a class="btn btn-info" href="service.php" role="button"><i class="fas fa-clipboard-list"></i> View Services</a>
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


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
