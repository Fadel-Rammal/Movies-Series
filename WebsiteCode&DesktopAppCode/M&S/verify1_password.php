<?php
session_start();

// Check if the password is provided in the request
if (isset($_POST['password'])) {
    // Retrieve the hashed password from the session
    $hashedPassword = isset($_SESSION["password"]) ? $_SESSION["password"] : "";
    
    // Retrieve the entered password from the request
    $enteredPassword = $_POST['password'];
    
    // Verify the entered password against the hashed password
    if (password_verify($enteredPassword, $hashedPassword)) {
        // Password is correct
        echo json_encode(["status" => "correct"]);
    } else {
        // Password is incorrect
        echo json_encode(["status" => "incorrect"]);
    }
} else {
    // Password is not provided in the request
    echo json_encode(["status" => "error"]);
}
?>
