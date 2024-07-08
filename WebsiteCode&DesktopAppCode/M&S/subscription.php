<?php
session_start();


include('header.php');

// Check if user is logged in
if (!isset($_SESSION["usertoken"])) {
    header("Location: login.php");
    exit();
}

// Assuming you have a database connection established
require_once "connection.php";

// Retrieve user ID from session
$userId = $_SESSION["usertoken"];
$firstName = $_SESSION["firstName"];
// Query to get user's balance, status, and end_subscription
$getSubscriptionQuery = "SELECT credits, status, end_subscription FROM userinfo WHERE id = '$userId'";
$result = mysqli_query($conn, $getSubscriptionQuery);
$balance = 0; // Default value
$status = "inactive"; // Default status
$endSubscription = null; // Default end_subscription value
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $balance = $row["credits"];
    $status = $row["status"];
    $endSubscription = $row["end_subscription"];
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Subscription</title>

<style>



/* subscription.css */
/* subscription.css */

:root {
    --citrine: hsl(57, 97%, 45%);
    --citrine-dark: hsl(57, 97%, 35%); /* Define a darker shade of citrine */
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

.container {
    max-width: 350px;
    margin: 100px auto; /* Centering the container vertically */
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
}

p {
    font-size: 18px;
    margin-bottom: 20px;
}

button {
    display: block; /* Change the display property to block */
    width: 300px; /* Set a specific width for the buttons */
    padding: 8px 16px; /* Adjust padding */
    font-size: 14px; /* Decrease font size */
    border: none;
    background-color: var(--citrine); /* Use CSS variable for background color */
    color: #000;
    cursor: pointer;
    border-radius: 4px;
    margin-bottom: 10px; /* Add margin between buttons */
    transition: background-color 0.3s; /* Add transition for smooth hover effect */
}

button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

button:hover {
    background-color: var(--citrine-dark); /* Change to a darker shade of citrine on hover */
}


</style>




</head>
<body>


<div class="container">
<p>Welcome, <?php echo $firstName; ?>!</p>
  <p>Your current balance is: <?php echo $balance; ?> coins</p>

<p>
   Currently state is, <?php echo ucfirst($status); ?>
</p>




<!-- Button for Payment -->
<button id="payment">Payment</button>

<button class="subscribe-btn" data-subscription-option="daily_deduction">Subscribe with Daily Deduction</button>
<button class="subscribe-btn" data-subscription-option="one_month" >Subscribe for One Month Directly</button>


<!-- Button to end subscription -->
<button id="endSubscription" <?php if ($status === 'inactive' || $endSubscription !== null) echo 'disabled'; ?>>End Subscription Today</button>


<button onclick="window.location.href='index.php'">Back</button>

</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event listener for Payment button
    document.getElementById('payment').addEventListener('click', function() {
        // Open add_balance.php in a new window
        const newWindow = window.open('add_balance.php', '_blank');
    });

    // Function to handle subscription confirmation
    function confirmSubscription(option) {
        if (option === 'daily_deduction' && <?php echo $balance; ?> < 1) {
            alert("Insufficient balance to subscribe for one day. Please add more coins.");
        } else if (option === 'one_month' && <?php echo $balance; ?> < 650) {
            alert("Insufficient balance. You need 650 coins.");
        } else {
            // Display a confirmation alert before redirecting to subscribe_action.php
            if (confirm("Are you sure you want to subscribe? \n \n End Subscription Today Only Available in Daily Deduction")) {
                // Redirect to subscribe_action.php with the chosen subscription option
                window.location.href = `subscribe_action.php?confirm=true&subscription_option=${option}`;
            }
        }
    }

    // Event listener for Subscribe buttons
    const subscribeButtons = document.querySelectorAll('.subscribe-btn');
    subscribeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Get the subscription option from the button's data attribute
            const subscriptionOption = button.getAttribute('data-subscription-option');
            
            // Check if a subscription option is provided
            if (subscriptionOption) {
                // Check if user is already subscribed
                if ("<?php echo $status; ?>" === 'active') {
                    alert("You are already subscribed.");
                } else {
                    // Call the confirmSubscription function with the chosen option
                    confirmSubscription(subscriptionOption);
                }
            } else {
                alert("Subscription option not provided.");
            }
        });
    });

    // Event listener for End Subscription button
    document.getElementById('endSubscription').addEventListener('click', function() {
        // Check if user is inactive or end_subscription is not null
        if ("<?php echo $status; ?>" === 'inactive' ) {
            alert("You are already inactive or subscription has already ended.");
        } else {
            // Confirm if the user wants to end the subscription today
            if (confirm("Are you sure you want to end your subscription today?")) {
                // Perform action to end subscription
                // For now, just redirecting to end_subscription.php
                window.location.href = 'end_subscription.php';
            }
        }
    });

});
</script>


</body>
</html>
