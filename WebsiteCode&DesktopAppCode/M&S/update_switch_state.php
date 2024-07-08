
<?php
session_start();

if (!isset($_SESSION["usertoken"])) {
    exit("User not logged in");
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "Movies&Series";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from AJAX request
$user_id = $_SESSION["usertoken"];
$movie_id = $_POST["movie_id"];
$state = $_POST["state"];

// Check if a record already exists for the user and movie
$sql_check = "SELECT * FROM allowed WHERE user_id = $user_id AND movie_id = $movie_id";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // Update switch state in the database
    $sql_update = "UPDATE allowed SET state = $state WHERE user_id = $user_id AND movie_id = $movie_id";
    
    if ($conn->query($sql_update) === TRUE) {
        echo "Switch state updated successfully";
    } else {
        echo "Error updating switch state: " . $conn->error;
    }
} else {
    // Insert a new record for the user and movie
    $sql_insert = "INSERT INTO allowed (user_id, movie_id, state) VALUES ($user_id, $movie_id, $state)";
    
    if ($conn->query($sql_insert) === TRUE) {
        echo "Switch state inserted successfully";
    } else {
        echo "Error inserting switch state: " . $conn->error;
    }
}

$conn->close();
?>