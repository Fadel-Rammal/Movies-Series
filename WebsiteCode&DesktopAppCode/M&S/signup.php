<?php
$errors = array('first_name' => '', 'last_name' => '', 'email' => '', 'password' => '');

if (isset($_POST['submit'])) {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["pwd"];
    
    // Validation
    if (empty($first_name)) {
        $errors['first_name'] = "Enter your First Name.";
    } elseif (empty($last_name)) {
        $errors['last_name'] = "Enter your Last Name.";
    } elseif (empty($email)) {
        $errors['email'] = "Enter your mail id.";
    } elseif (empty($password)) {
        $errors['password'] =  "Enter your password.";
    } else {
        // Generate encryption key
        $encryptionKey = bin2hex(random_bytes(16)); // 16 bytes = 128 bits
        
        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Database Interaction
        require_once "connection.php";

        $sql = "SELECT * FROM userinfo WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $errors['email'] = "Email already exists!";
            } else {
                // Insert into the database
                $sql = "INSERT INTO userinfo (firstName, lastName, email, password, encryption_key, credits, status) VALUES (?, ?, ?, ?, ?, '0', 'inactive')";
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $passwordHash, $encryptionKey);
                    if (mysqli_stmt_execute($stmt)) {
                        echo "New record created successfully";
                        header('Location: login.php');
                        exit; // Ensure script stops execution after redirection
                    } else {
                        echo "Error inserting user data";
                    }
                } else {
                    echo "Database query error";
                }
            }
        } else {
            echo "Database query error";
        }
        mysqli_close($conn);
    }
}
?>

    


<!DOCTYPE html>
<html>



<head>

<style>

.wel-signup{
    overflow: hidden;
    padding-bottom: 100px; padding-top:100px; 
    background-image: url('images/signupbg.jpg'); 
    background-attachment: fixed;
    background-size: cover;
    background-repeat:no-repeat;
    font-family: 'Jost', sans-serif;
    margin-bottom: 50px;
}

:root {
    --citrine: hsl(57, 97%, 45%);
    --citrine-dark: hsl(57, 97%, 10%); /* Define a darker shade of citrine */
}

.signupbtn {
    display: block;
    width: 100px;
    padding: 8px 16px;
    font-size: 14px;
    border: none;
    background-color: black;
    color: #fff;
    cursor: pointer;
    border-radius: 4px;
    margin: 0 auto; /* Center the button horizontally */
    margin-bottom: 10px;
    transition: background-color 0.3s;
}

.signupbtn:hover {
    background-color: var(--citrine-dark);
}


</style>


</head>
   
  <?php include('header.php')?>
  <title>Sign Up</title>
    <body class="wel-signup">
       

        <!-- Sign Up form -->
        <div class="container">
            <div class="row">

                

                <div class="col-md-6 login" >
                  <div style="margin-left: 10%; margin-right:10%;">
                              <!-- title of page -->
                  <div class="text-center ">
                          <h2 style="text-align: center; font-size: 40px; color: white;">Sign Up</h2><hr>
                          
                          
                  </div>
                  
                    <form style="margin-top: 30px; margin-bottom:30px;" action="signup.php" method="POST">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            
                            <input type="text" class="form-control" id="first_name" placeholder="Enter First Name" name="first_name" required>
<div class="text-danger"><?php echo $errors['first_name']; ?></div>

                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                           
                            <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name" name="last_name" required>
<div class="text-danger"><?php echo $errors['last_name']; ?></div>

                          </div>
                        </div>
                      </div>
                        
                        
                        <div class="form-group">
                            
                            <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
                            <div class="text-danger"><?php echo $errors['email']; ?></div>
                        </div>

                        <div class="row">
                        <div class="col-9">
                          <div class="form-group">
                            
                              
                                  <input type="password" class="form-control" id="pwd" placeholder="Enter Password" name="pwd" required>

                        
                              <div class="text-danger"><?php echo $errors['password']; ?></div>
                          </div>  
                        </div>
                        <div class="col-3">
                          <button style="float: right;" type="submit" class="signupbtn" name="submit">Sign Up</button>
                        </div>
                      </div>
                      <p style="font-size:15px; text-align:center;">Already have an account?<a href="login.php" style="color: black; text-decoration: underline;"> Log In</a>.</p>



          
    
                    </form>
                  </div>
                  
                        

                </div>

                <div class="col-md-6">
                   

                </div>



            </div>
            
          </div>





       
    </body>
</html>