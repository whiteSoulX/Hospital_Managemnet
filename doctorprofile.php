<?php
session_start();

function getDoctorDetails($doctorName) {
    $doctorsFile = 'doctors.txt';
    $details = [];
    if (file_exists($doctorsFile)) {
        $lines = file($doctorsFile, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $data = explode(",", $line);
            if ($data[0] === $doctorName) {
                $details['name'] = $data[0];
                $details['field'] = $data[1];
                break;
            }
        }
    }
    return $details;
}

// Function to get and format reviews
function getReviews($doctorName) {
    $ratingsFile = 'ratings.txt';
    $reviews = [];
    if (file_exists($ratingsFile)) {
        $lines = file($ratingsFile, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $data = explode(",", $line);
            if ($data[0] === $doctorName) {
                $review = [
                    'user' => $data[1], // Get the user's name
                    'rating' => $data[2],
                    'review' => $data[3]
                ];
                $reviews[] = $review;
            }
        }
    }
    return $reviews;
}

$doctorName = $_GET["doctor"];
$doctorDetails = getDoctorDetails($doctorName);
$reviews = getReviews($doctorName);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $doctorDetails['name']; ?> Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2><?php echo $doctorDetails['name']; ?> Profile</h2>
        <p><strong>Field:</strong> <?php echo $doctorDetails['field']; ?></p>
        

        <h3>Previous Reviews:</h3>
        <ul class="list-group">
            <?php foreach ($reviews as $review): ?>
                <li class="list-group-item">
                    <strong>User:</strong> <?php echo $review['user']; ?>,
                    <strong>Rating:</strong> <?php echo $review['rating']; ?>,
                    <strong>Review:</strong> <?php echo $review['review']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
