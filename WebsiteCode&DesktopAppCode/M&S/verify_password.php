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
        echo "correct"; // Password is correct
    } else {
        echo "incorrect"; // Password is incorrect
    }
} else {
    echo "error"; // Password is not provided in the request
}
?>
