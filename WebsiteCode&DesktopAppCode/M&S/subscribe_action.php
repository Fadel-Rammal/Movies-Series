<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["usertoken"])) {
    header("Location: login.php");
    exit();
}

// Assuming you have a database connection established
require_once "connection.php";

// Retrieve user ID from session
$userId = $_SESSION["usertoken"];

// Check if the user confirms the subscription and the subscription option is provided
if (isset($_GET['confirm']) && isset($_GET['subscription_option'])) {
    $confirmation = $_GET['confirm'];
    $subscription_option = $_GET['subscription_option'];
    
    // If user confirms subscription
    if ($confirmation === 'true') {
        if ($subscription_option === 'daily_deduction') {
            // Check if user has enough coins for daily deduction
            $checkBalanceQuery = "SELECT credits FROM userinfo WHERE id = '$userId'";
            $balanceResult = mysqli_query($conn, $checkBalanceQuery);
            
            if ($balanceResult) {
                $row = mysqli_fetch_assoc($balanceResult);
                $credits = $row['credits'];
                
                if ($credits >= 24) { // Check if user has enough credits for daily deduction
                    // Set end_subscription to NULL for daily subscription
                    // Also set deduction_time to NULL
                    $updateSubscriptionQuery = "UPDATE userinfo SET start_subscription = NOW(), end_subscription = NULL, deduction_time = NULL, status = 'active' WHERE id = '$userId'";
                    $updateResult = mysqli_query($conn, $updateSubscriptionQuery);
                    
                    if ($updateResult) {
                        // Close the database connection
                        mysqli_close($conn);
                        // Redirect back to subscription page with success message
                        echo "<script>alert('Subscription successful.'); window.location.href = 'subscription.php';</script>";
                        exit();
                    } else {
                        // If update failed, show error message
                        mysqli_close($conn);
                        echo "<script>alert('Failed to update subscription.'); window.location.href = 'subscription.php';</script>";
                        exit();
                    }
                } else {
                    // If user doesn't have enough credits, show error message
                    mysqli_close($conn);
                    echo "<script>alert('Insufficient credits. You need at least 24 coins.'); window.location.href = 'subscription.php';</script>";
                    exit();
                }
            } else {
                // If query failed, show error message
                mysqli_close($conn);
                echo "<script>alert('Failed to check balance.'); window.location.href = 'subscription.php';</script>";
                exit();
            }
        } elseif ($subscription_option === 'one_month') {
            // Handle one-month subscription option
            // Deduct 650 coins for one month subscription
            $deductionAmount = 650;
            
            // Check if user has enough coins
            $checkBalanceQuery = "SELECT credits FROM userinfo WHERE id = '$userId'";
            $balanceResult = mysqli_query($conn, $checkBalanceQuery);
            
            if ($balanceResult) {
                $row = mysqli_fetch_assoc($balanceResult);
                $credits = $row['credits'];
                
                if ($credits >= $deductionAmount) {
                    // Deduct coins from user's balance
                    $deductCoinsQuery = "UPDATE userinfo SET credits = credits - $deductionAmount WHERE id = '$userId'";
                    $deductResult = mysqli_query($conn, $deductCoinsQuery);
                    
                    if ($deductResult) {
                        // Record start_subscription as current date and time
                        $startSubscription = date('Y-m-d H:i:s');
                        
                        // Calculate end_subscription after one month (30 days)
                        $endSubscription = date('Y-m-d H:i:s', strtotime($startSubscription . ' + 30 days'));
                        
                        // Update user's start_subscription, end_subscription and set deduction_time to NULL in the database
                        $updateSubscriptionQuery = "UPDATE userinfo SET start_subscription = '$startSubscription', end_subscription = '$endSubscription', deduction_time = NULL, status = 'active' WHERE id = '$userId'";
                        $updateResult = mysqli_query($conn, $updateSubscriptionQuery);
                        
                        if ($updateResult) {
                            // Close the database connection
                            mysqli_close($conn);
                            // Redirect back to subscription page with success message
                            echo "<script>alert('Subscription successful. 650 coins deducted from your balance.'); window.location.href = 'subscription.php';</script>";
                            exit();
                        } else {
                            // If update failed, show error message
                            mysqli_close($conn);
                            echo "<script>alert('Failed to update subscription.'); window.location.href = 'subscription.php';</script>";
                            exit();
                        }
                    } else {
                        // If deduction failed, show error message
                        mysqli_close($conn);
                        echo "<script>alert('Failed to deduct coins for subscription.'); window.location.href = 'subscription.php';</script>";
                        exit();
                    }
                } else {
                    // If user doesn't have enough coins, show error message
                    mysqli_close($conn);
                    echo "<script>alert('Insufficient balance to subscribe for one month.'); window.location.href = 'subscription.php';</script>";
                    exit();
                }
            } else {
                // If query failed, show error message
                mysqli_close($conn);
                echo "<script>alert('Failed to check balance.'); window.location.href = 'subscription.php';</script>";
                exit();
            }
        } else {
            // Invalid subscription option
            echo "<script>alert('Invalid subscription option.'); window.location.href = 'subscription.php';</script>";
            exit();
        }
    } elseif ($confirmation === 'false') {
        // If user cancels, redirect back to subscription page
        header("Location: subscription.php");
        exit();
    } else {
        // Invalid confirmation value
        echo "<script>alert('Invalid confirmation value.'); window.location.href = 'subscription.php';</script>";
        exit();
    }
} else {
    // If confirmation parameter or subscription option is not provided
    // Redirect back to subscription page
    header("Location: subscription.php");
    exit();
}
?>
