<?php
// Start or resume session
session_start();

// Retrieve the user ID from the session
$user_id = $_SESSION['usertoken'];

// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'Movies&Series';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the request method is POST, update the state in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the m_state parameter from the POST request
    $m_state = $_POST['m_state'];
    
    // Update the state in the database
    $update_sql = "UPDATE parent SET m_state = ? WHERE user_id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("si", $m_state, $user_id);
    if ($stmt_update->execute()) {
        // Send success response to the client
        $response = array("status" => "success");
        echo json_encode($response);
    } else {
        // Send error response to the client
        $response = array("status" => "error", "message" => $conn->error);
        echo json_encode($response);
    }
    // Close update statement
    $stmt_update->close();
} else {
    // If the request method is not POST, fetch the last saved state from the database
    $result = $conn->query("SELECT m_state FROM parent WHERE user_id = '$user_id'");
    
    if ($result->num_rows > 0) {
        // If a record exists, retrieve the last saved state
        $row = $result->fetch_assoc();
        $last_state = $row['m_state'];
        
        // Send success response with the last saved state to the client
        $response = array("status" => "success", "last_state" => $last_state);
        echo json_encode($response);
    } else {
        // If no record exists, insert a new one with state as disabled
        $insert_sql = "INSERT INTO parent (user_id, m_state) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($insert_sql);
        $initial_state = 'disabled';
        $stmt_insert->bind_param("is", $user_id, $initial_state);
        if ($stmt_insert->execute()) {
            // Send success response to the client
            $response = array("status" => "success", "last_state" => $initial_state);
            echo json_encode($response);
        } else {
            // Send error response to the client
            $response = array("status" => "error", "message" => $conn->error);
            echo json_encode($response);
        }
        // Close insert statement
        $stmt_insert->close();
    }
}

// Close connection
$conn->close();
?>
