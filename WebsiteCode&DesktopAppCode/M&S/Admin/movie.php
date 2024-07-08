<?php
include("db_connect.php");
error_reporting(0);
$edit_state = false;

if (isset($_POST['submit'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $u = "admin";
    $p = 123;

    if ($user == $u && $pass == $p) {
        header("location: movie.php");
    }else {
        header("location: login.php");
    }
}


?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            

            <!-- Sidebar -->
            <div class="sidebar">
                

              
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class=""></i>
                                <p>
                                    Pages
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                

                                <li class="nav-item">
                                    <a href="movie.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Movie</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="oncinema.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>On Cinema</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--  -->
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="row">

                    <div class="col-sm-10 text-center">Add new movies</div>
                    <div class="col-sm-2">
                        <a href="movieadd.php" class="btn btn-success" style="width: 100%;">Add</a>
                    </div>

                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- object/ -->
                        <?php
                        $sql = "SELECT movie_id, movie_title, durations, movie_image, categorie_id, rating, 
                        description, movie_status, release_date, url_trailer FROM movies order by movie_id desc";

                        $result = mysqli_query($connection, $sql);
                        if (mysqli_errno($connection) > 0) {
                            die(mysqli_error($connection));
                        }
                        ?>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">movie_id</th>
                                    <th scope="col">movie_title</th>
                                    <th scope="col">durations</th>
                                    <th scope="col">movie_image</th>
                                    <th scope="col">rating</th>
                                    <th scope="col">movie_status</th>
                                    <th scope="col">release_date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <th scope="row"><?php echo $row["movie_id"]; ?></th>
                                        <th style="max-width: 150px;"><?php echo $row["movie_title"]; ?></th>
                                        <th><?php echo $row["durations"]; ?></th>
                                        <th>
                                            <div class="image"><img src="../image/<?php echo $row["movie_image"]; ?>" alt=""></div>
                                        </th>
                                        <th><?php echo $row["rating"]; ?></th>
                                        <th><?php echo $row["movie_status"]; ?></th>
                                        <th><?php echo $row["release_date"]; ?></th>
                                        <?php ?>

                                        <th>
                                            <input type="hidden" name="des" value="<?php echo $row["description"] ?>">
                                            <form method="POST" action="movieadd.php" enctype="multipart/form-data">
                                                <button type="submit" name="editt" value="<?php echo $row['movie_id'] ?>" class="btn btn-primary edit">Edit</button>
                                                <button type="submit" name="remove" value="<?php echo $row['movie_id'] ?>" class="btn btn-danger">Remove</button>
                                            </form>
                                        </th>
                                    </tr>
                                <?php } ?>
                        </table>


                        <!-- end object -->


                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>