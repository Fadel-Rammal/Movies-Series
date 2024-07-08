<?php
// Database configuration
$server = "localhost";
$username = "root";
$password = "";
$database = "Movies&Series";

// Create connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user ID is provided
if(isset($_GET['userID'])) {
    $userID = $_GET['userID'];


    // Prepare and execute SQL query to fetch bookings for the given user ID
    $sql = "SELECT * FROM bookings WHERE user_id = '$userID'";
    $result = $conn->query($sql);

    // Check if bookings are found
    if ($result->num_rows > 0) {
        // Array to hold bookings data
        $bookings = array();

        // Fetch each row of the result
        while($row = $result->fetch_assoc()) {
            // Add the row to the bookings array
            $bookings[] = $row;
        }

        // Return the bookings data as JSON
        echo json_encode($bookings);
    } else {
        // If no bookings found, return an empty JSON array
        echo json_encode(array());
    }
} else {
    // If user ID is not provided, return an error message
    echo "User ID not provided";
}

// Close connection
$conn->close();
?>
