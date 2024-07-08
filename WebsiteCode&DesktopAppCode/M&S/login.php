<?php 
$errors = array('email' => '', 'password' => '', 'loginFlag' => '');
$email = '';

if(isset($_POST['submit'])){
  $email = $_POST['email'];
  $password = $_POST['pwd'];
  
  if(empty($email)){
    $errors['email'] = "Enter your email." ;
  }
  if(empty($password)){
    $errors['password'] = "Enter your password.";
  }
  
  if(!array_filter($errors)){
    include('loginCheck.php');

    if($loginFlag == "false"){
      $errors['loginFlag'] = "Either email or password is incorrect.";
// Clear email and password on incorrect login
      $email = '';

    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
:root {
    --citrine: hsl(57, 97%, 45%);
    --citrine-dark: hsl(57, 97%, 10%);
}

.loginbtn {
    display: block;
    width: 100px;
    padding: 8px 16px;
    font-size: 14px;
    border: none;
    background-color: black;
    color: #fff;
    cursor: pointer;
    border-radius: 4px;
    margin: 0 auto;
    margin-bottom: 10px;
    transition: background-color 0.3s;
}

.loginbtn:hover {
    background-color: var(--citrine-dark);
}
</style>
</head>

<?php include('header.php')  ?>
<title>Log In</title>

<body class="wel-login">
  <div class="container" style="margin-top:100px; margin-bottom:70px;">
    <div class="row">
      <div class="col-md-6">
        <div class="text-center">
          <h2 style="text-align: center; font-size: 40px; color: white;">
            <?php 
              if(@$_GET['alert']){
                echo "Log In to Book Tickets";
              } else {
                echo "Log In";
              }
            ?>
          </h2>
          <medium style="color: white;">Online Ticketing System And Watching Movies</medium>
        </div>
      </div>

      <div class="col-md-6 login">
        <div style="margin-left: 10%; margin-right:10%;">
          <form action="login.php" method="POST">
            <div class="form-group">
              <label for="email"><span style="color: Black;">Email :</span></label>
              <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
              <div class="text-danger"><?php echo $errors['email']; ?></div>
            </div>
            <div class="form-group">
              <label for="pwd"><span style="color: black;">Password :</span></label>
              <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
              <div class="text-danger"><?php echo $errors['password']; ?></div>
            </div>
            <div class="text-danger"><?php echo $errors['loginFlag']; ?></div>
            <div class="row">
              <div class="col-8 text-left">
                <a href="signup.php"><span style="color: black; text-decoration: underline;">Create New Account</span></a>
              </div>
              <div class="col-4 text-right">
                <button type="submit" name="submit" class="loginbtn">Log In</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
