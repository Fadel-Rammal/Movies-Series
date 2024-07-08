<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming you have a database connection established
    require_once "connection.php";

    // Retrieve user ID from session
    $userId = $_SESSION["usertoken"];

    // Get amount to be added from POST request
    $amountToAdd = $_POST["amountToAdd"];

    // Update user's balance in the database
    $updateBalanceQuery = "UPDATE userinfo SET credits = credits + $amountToAdd WHERE id = '$userId'";
    $result = mysqli_query($conn, $updateBalanceQuery);

    if ($result) {
        // If update successful, send success message
        echo '<script>alert("Balance added successfully."); window.close();</script>';
        exit();
    } else {
        // If update failed, send failure message
        echo '<script>alert("Failed to add balance."); window.close();</script>';
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Balance</title>
<style>
/* Add your CSS styles here */
</style>
</head>
<body>

<form id="paymentForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <label for="amount">Enter Amount:</label>
  <input type="number" id="amount" name="amountToAdd" required>
  <button type="submit">Pay</button>
</form>

</body>
</html>
