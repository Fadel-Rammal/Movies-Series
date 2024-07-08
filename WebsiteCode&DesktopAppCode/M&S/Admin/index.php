<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="dist/css/adminlte.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body>
    <div class="login">
        <div class="log-wraper">
            <center><h1>ADMINISTRATOR</h1></center>
            <form action="movie.php" method="POST" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="text" name="username" id="form2Example1" class="form-control" required />
                    <label class="form-label" for="form2Example1">Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example2" class="form-control" required />
                    <label class="form-label" for="form2Example2">Password</label>
                </div>

               

                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Log in</button>

                
            </form>
        </div>
    </div>

</body>

</html>