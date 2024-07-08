<?php
// Check if email and password are set
if(isset($_POST['email']) && isset($_POST['password'])){
    // Include the necessary files
    require_once "conn.php";
    require_once "validate.php";
    // Call validate, pass form data as parameter and store the returned value
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    // Hash the entered password in PHP
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Create the SQL query string
    $sql = "SELECT * FROM userinfo WHERE email='$email'";
    // Execute the query
    $result = $conn->query($sql);
    // If number of rows returned is greater than 0 (that is, if the record is found), we'll check the password
    if($result->num_rows > 0){
        // Fetch the user data
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct
            echo json_encode(array("status" => "success", "email" => $row['email'], "userID" => $row['id']));
        } else {
            // Password is incorrect
            echo json_encode(array("status" => "failure"));
        }
    } else {
        // If no record is found for the email, print "failure"
        echo json_encode(array("status" => "failure"));
    }
}
?>
