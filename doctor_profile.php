<?php
session_start();


function getDoctorDetails($doctorName) {
    $doctorsFile = 'doctors.txt';
    $ratingsFile = 'ratings.txt';
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


    $ratings = [];
    if (file_exists($ratingsFile)) {
        $lines = file($ratingsFile, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $data = explode(",", $line);
            if ($data[0] === $doctorName) {
                $rating = (int)$data[2];
                $review = implode(",", array_slice($data, 3)); // Get the review (the rest of the data)
                $ratings[] = ['rating' => $rating, 'review' => $review];
            }
        }
    }
    $details['ratings'] = $ratings;

    return $details;
}


$doctorName = $_GET["doctor"];


$doctorDetails = getDoctorDetails($doctorName);
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
        <?php if (count($doctorDetails['ratings']) > 0): ?>
            <?php foreach ($doctorDetails['ratings'] as $rating): ?>
                <p>Rating: <?php echo $rating['rating']; ?></p>
                <p>Review: <?php echo $rating['review']; ?></p>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
