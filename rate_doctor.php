<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

function saveRatingReview($doctorName, $userName, $rating, $review) {
    $ratingsFile = 'ratings.txt';
    $ratingData = "$doctorName,$userName,$rating,$review\n";
    file_put_contents($ratingsFile, $ratingData, FILE_APPEND | LOCK_EX);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorName = $_POST["doctor"];
    $userName = $_SESSION["username"];
    $rating = $_POST["rating"];
    $review = $_POST["review"];
    
    saveRatingReview($doctorName, $userName, $rating, $review);
    header("Location: doctorlist.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Doctor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Rate Doctor</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="doctor">Doctor:</label>
                <input type="text" class="form-control" id="doctor" name="doctor" value="<?php echo isset($_GET['doctor']) ? $_GET['doctor'] : ''; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="rating">Rating:</label>
                <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="review">Review:</label>
                <textarea class="form-control" id="review" name="review" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
