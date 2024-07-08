<?php
session_start();
$loginFlag = "false";

if(isset($_POST['email'], $_POST['pwd'])){
    $inputEmail = $_POST['email'];
    $inputPassword = $_POST['pwd'];
    
    include('connection.php');

    $sql = "SELECT * FROM userinfo WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inputEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $user = $result->fetch_assoc();
        if(password_verify($inputPassword, $user['password'])){
            $_SESSION['username'] = $user['username'];
            $_SESSION['usertoken'] = $user['id'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION["user"] = array(
                "email" => $user["email"],
                "encryption_key" => $user["encryption_key"]
            );

            header('Location: index.php');
            exit;
        }
    }
}
$loginFlag = "false";
?>
