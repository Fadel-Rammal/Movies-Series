<?php 
session_start();
$rate = $_POST['rating'];
$feed = $_POST['feedbackForm'];
$booking_id = $_SESSION['booking_id'];
$userName = $_SESSION['firstName'];

// Additional line to retrieve movie title from form submission
$movie_title = $_POST['movie_title'];

include('connection.php');

$sql = "INSERT INTO feedbackForm (rating, feedback, username, movie_title) VALUES ('$rate', '$feed', '$userName', '$movie_title')";
if ($conn->query($sql) === TRUE) {
    header('Location:index.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
