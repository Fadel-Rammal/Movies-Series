<?php
include("db_connect.php");
error_reporting(0);
$edit_state = false;

function hoursandmins($time)
{
    if ($time < 1) {
        return;
    } else {
        $hour = floor($time / 60);
        $min = ($time % 60);
        if ($min == 1) {
            $format = '%01dh %02d minute';
        } else {
            $format = '%01dh %02d minutes';
            if ($hour < 1) {
                $format = '%02d minutes';
                return sprintf($format, $min);
            }
        }
        return sprintf($format, $hour, $min);
    }
}


//delete
if (isset($_POST["remove"])) {
    $id = $_POST['remove'];
    try {
        $queryimg = "SELECT movie_image from movies where movie_id = $id limit 1";
        $result = $connection->query($queryimg);
        $row = $result->fetch_assoc();
        unlink('../dist/img/' . $row['movie_image']);
        $sql = "DELETE FROM movies where movie_id = $id limit 1";
        mysqli_query($connection, $sql);
        // header("location: movie.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    header("location: movie.php");
}
//edit
if (isset($_POST['editt'])) {
    $edit_state = true;
    $movie_id = $_POST['editt'];
    try {
        $sql = "SELECT movie_id, movie_title, durations, movie_image, categorie_id, rating, 
                description, movie_status, release_date, url_trailer FROM movies where movie_id = $movie_id limit 1";

        $result = mysqli_query($connection, $sql);
        $row = $result->fetch_assoc();
        $movie_id = $row['movie_id'];
        $movie_title = $row['movie_title'];
        $durations = $row['durations'];
        $durations = hoursandmins($durations);
        $movie_image = $row['movie_image'];
        $categorie_id = $row['categorie_id'];
        $rating = $row['rating'];
        $description = $row['description'];
        $description = mysqli_real_escape_string($connection, $description);
        $movie_status = $row['movie_status'];
        $release_date = $row['release_date'];
        $url_trailer = $row['url_trailer'];



        $query = "SELECT categorie_name from categories where categorie_id = $categorie_id limit 1";
        $resultt = $connection->query($query);
        $row = $resultt->fetch_assoc();
        $categorie_name = $row['categorie_name'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
//update
if (isset($_POST['updatem'])) {
    $edit_state = false;
    $movie_id = $_POST['updatem'];
    $title = $_POST['txt_title'];
    $durations = $_POST['txt_durations'];
    $durations = hoursandmins($durations);
    $rating = $_POST['rating'];
    $description = $_POST['description'];
    $description = mysqli_real_escape_string($connection, $description);
    $release_date = $_POST['release_date'];
    $release_date = date('Y-m-d', strtotime($release_date));
    $url_trailer = $_POST['url_trailor'];
    $url_trailer = mysqli_real_escape_string($connection, $url_trailer);
    $categorie = $_POST['categorie'];
    

    $sql = "UPDATE movies SET movie_title = '$title',durations = '$durations', 
    description = '$description', release_date = '$release_date', url_trailer = '$url_trailer',
    rating = '$rating', categorie_id = '$categorie'
    WHERE movie_id = $movie_id LIMIT 1";
    mysqli_query($connection, $sql);
    if (mysqli_errno($connection) > 0) {
        die(mysqli_error($connection));
    }
    $description = "";
    header("location: movie.php");
}
// If upload button is clicked ...
if (isset($_POST['uploadm'])) {
    $title = $_POST['txt_title'];
    $durations = $_POST['txt_durations'];
    $durations = hoursandmins($durations);
    $rating = $_POST['rating'];
    $description = $_POST['description'];
    $description = mysqli_real_escape_string($connection, $description);
    $release_date = $_POST['release_date'];
    $release_date = date('Y-m-d', strtotime($release_date));
    $url_trailer = $_POST['url_trailor'];
    $url_trailer = mysqli_real_escape_string($connection, $url_trailer);
    $movie_status = $_POST['movie_status'];
    //escape single quote

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "../image/" . $filename;
    $categorie = $_POST['categorie'];
    $title = trim($title);
    $sql = "INSERT INTO movies (movie_title, durations, movie_image, categorie_id,rating,description,release_date,movie_status,url_trailer) 
    VALUES ('$title','$durations','$filename',$categorie,$rating,'$description','$release_date','$movie_status','$url_trailer')";
    // Execute query
    mysqli_query($connection, $sql);
    move_uploaded_file($tempname, $folder);
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
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="dist/css/adminlte.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

<style>
button[type="button"] {
            width: 10%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

</style>


</head>

<body >
    

        

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">

                    <!-- object/ -->
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8">
                            <form method="POST" action="" enctype="multipart/form-data">

                                <?php

                                $sql = "SELECT categorie_id, categorie_name  FROM categories";
                                $result = $connection->query($sql);

                                if ($result->num_rows > 0) {
                                ?>
                                    <label for="exampleFormControlSelect1">Categories</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="categorie">
                                        <?php while ($row = $result->fetch_assoc()) {
                                            if ($row['categorie_id'] == $categorie_id) { ?>

                                                <option selected value="<?php echo $row['categorie_id'] ?>"> <?php echo $row['categorie_name'] ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $row['categorie_id'] ?>"> <?php echo $row['categorie_name'] ?></option>
                                        <?php }
                                        } ?>

                                    </select>
                                <?php
                                }
                                ?>
                                <br>
                                <div class="form-group">
        <input class="form-control" type="text" name="txt_title" value="<?php echo $movie_title ?>" placeholder="Title" required />
    </div>
    <div class="form-group">
        <input class="form-control" type="text" name="txt_durations" value="<?php echo $durations ?>" placeholder="How many minutes long are the movies?" required />
    </div>
    <div class="form-group">
        <label for="image_front">Image</label>
        <input class="form-control" type="file" name="uploadfile" id="image_front" required />
    </div>
    <div class="form-group">
        <input class="form-control" type="text" name="rating" value="<?php echo $rating ?>" placeholder="rating" required />
    </div>
                                <div class="form-group">
                                    <input type="hidden" name="desc" value="<?php echo addslashes($description); ?>">
                                    <textarea id="desc" class="form-control" name="description" rows="4" placeholder="Description"></textarea>

                                </div>
                                <div class="form-group">
        <input class="form-control" type="date" name="release_date" value="<?php echo $release_date ?>" placeholder="release date" required />
    </div>
    <div class="form-group">
        <input class="form-control" type="text" name="url_trailor" value='<?php echo $url_trailer; ?>' placeholder="url trailor" required />
    </div>
    <select class="form-control" id="exampleFormControlSelect1" name="movie_status" value="<?php echo $movie_status ?>" required>
        <option value="oncinema">oncinema</option>
        <option value="online">online</option>
    </select><br>

    <div class="form-group">
    <?php if ($edit_state == false) { ?>
        <button class="btn btn-success" type="submit" name="uploadm">SAVE</button>
    <?php } else { ?>
        <button class="btn btn-success" type="submit" value="<?php echo $movie_id ?>" name="updatem">UPDATE</button>
    <?php } ?>
    <!-- Clear button -->
    <button class="btn btn-secondary" type="reset">CLEAR</button>
</div>

                            </form>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
<a href="movie.php"><button type="button">Back to Movies</button></a>


                    <!-- end object -->




    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <script>
        var des = $('input[name="desc"]').val();

        document.getElementById('desc').value = des;
    </script>
</body>

</html>