<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Assuming you have a database connection established
require_once "connection.php";

// Retrieve user ID from session
$userId = $_SESSION["usertoken"];

// Query to get user's balance and status
$getBalanceQuery = "SELECT credits, status FROM userinfo WHERE id = '$userId'";
$result = mysqli_query($conn, $getBalanceQuery);
$balance = 0; // Default value
$status = "inactive"; // Default status
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $balance = $row["credits"];
    $status = $row["status"];
}

// Check if the user is currently active
if ($status === 'active') {
    // Mark the subscription for end today
    $markEndQuery = "UPDATE userinfo SET status = 'active', end_subscription_today = 1 WHERE id = '$userId'";
    if (mysqli_query($conn, $markEndQuery)) {
        // Subscription marked for end today
        echo "<script>alert('Your subscription has been marked for end today. It will be ended once a deduction occurs.'); window.location.href = 'subscription.php';</script>";
    } else {
        // Error marking subscription
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // User is already inactive
    echo "<script>alert('Your subscription is already inactive.');</script>";
}

// Close the database connection
mysqli_close($conn);
?>
