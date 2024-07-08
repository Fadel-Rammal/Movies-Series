

<?php 
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
   exit(); // Add exit to prevent further execution if user is not logged in
}

// Include your database connection file here
include 'connection.php';

$userName = $_SESSION['firstName'];

// Check if movie_id is set in the URL
if(isset($_GET['movie_id'])) {
    // Get the movie ID from the URL
    $movie_id = $_GET['movie_id'];

    // Query to fetch the movie title from the database based on the movie ID
    $sql = "SELECT movie_title FROM movies WHERE movie_id = $movie_id";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result->num_rows > 0) {
        // Fetch the movie title
        $row = $result->fetch_assoc();
        $movie_title = $row['movie_title'];
    } else {
        $movie_title = "Unknown Movie";
    }
} else {
    $movie_title = "Unknown Movie";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Page</title>

    <link rel="stylesheet" type="text/css" href="css/radiobuttons.css">
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>

	body {
    /* Set the background image */
    background-image: url('images/cinemaaa.jpg');

    /* Specify background image size and behavior */
    background-size: contain; /* Ensure the entire background image is visible */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Do not repeat the background image */
}


        /* Your existing CSS styles */


        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            text-align: center;
		margin-bottom: 30px
        }

        .rating > label {
            display: inline-block;
            position: relative;
            width: 1.1em;
            font-size: 1.5em;
            color: #ccc;
            cursor: pointer;
        }

        .rating > label:hover,
        .rating > label:hover ~ label,
        .rating > input:checked ~ label {
            color: #ffca08;
        }

        .rating > label:hover:before,
        .rating > label:hover ~ label:before,
        .rating > input:checked ~ label:before,
        .rating > input:checked ~ label:before {
            content: '★';
            position: absolute;
        }

        .rating > label:before {
            content: '☆';
            position: absolute;
        }

        /* Hide the radio buttons */
        .rating > input {
            display: none;
        }

        /* Adjusted styling for container */
        .container {
            margin-top: 40px;
        }


/* Video */
#video1 {
    display: block;
    margin: 250px auto 0; /* Adds a margin of 50px on top, and centers horizontally */
}





:root {
    --citrine: hsl(57, 97%, 45%);
    --citrine-dark: hsl(57, 97%, 35%); /* Define a darker shade of citrine */
}

h1 {
            text-align: center;
        }

.feedbackbtn {
    display: block;
    width: 300px;
    padding: 8px 16px;
    font-size: 14px;
    border: none;
    background-color: var(--citrine);
    color: #000;
    cursor: pointer;
    border-radius: 4px;
    margin: 0 auto; /* Center the button horizontally */
    margin-bottom: 10px;
    transition: background-color 0.3s;
}

.feedbackbtn:hover {
    background-color: var(--citrine-dark);
}



.downloadbtn {
    display: block;
    width: 300px;
    padding: 8px 16px;
    font-size: 14px;
    border: none;
    background-color: var(--citrine);
    color: #000;
    cursor: pointer;
    border-radius: 4px;
    margin: 0 auto; /* Center the button horizontally */
    margin-bottom: 10px;
    transition: background-color 0.3s;
}

.downloadbtn:hover {
    background-color: var(--citrine-dark);
}

h1{

color: white;

}

.text-center{

color: white;

}

 /* Center the download button */
        .download-btn {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
		margin-top: 30px;
        }

    </style>
</head>
<body>
<?php include('header.php'); ?>
<h1></h1>
       <br>
<h1><?php echo $movie_title; ?></h1>


<video id="video1" width="900" height="500" controls controlsList="nodownload" oncontextmenu="return false;">
    <!-- Add controlsList attribute to disable download button -->
    <?php
    // Assuming $movie_title contains the movie title fetched from the database
    // Construct the video file name based on the movie title
    $video_file_name = 'movies/' . strtolower(str_replace(' ', '', $movie_title)) . ".mp4";
    ?>
    <source src="<?php echo htmlspecialchars($video_file_name); ?>" type="video/mp4">
    Your browser does not support the video tag.
</video>




<!-- Download button under the video -->
<form class="download-btn" action="encrypt_video.php" method="post">
    <input type="hidden" name="download" value="true">
    <!-- Add a hidden input to indicate download -->

    <!-- Add hidden input fields for movie title and video file path -->
    <input type="hidden" name="movie_title" value="<?php echo htmlspecialchars($movie_title); ?>">
    <input type="hidden" name="video_file" value="<?php echo htmlspecialchars($video_file_name); ?>">

    <button class="downloadbtn" type="submit">Download Video</button>
</form>



<!-- Rating  -->
<div class="container">
    <div class="row justify-content-center">
        <!-- Centering the row -->
        <div class="col-6">
            <!-- Feedback  -->
            <h6 class="text-center">Feedback</h6>
            <hr style="border:#464E59 solid 0.5px">
            <medium class="text-center">Write Your Feedback About the Movie</medium>
            <div class="text-center">
                <form action="feedback_process.php" method="POST">
                    <div class="rating">
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5"></label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4"></label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3"></label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2"></label>
                        <input type="radio" id="star1" name="rating" value="1" required>
                        <label for="star1"></label>
                    </div>
                    <!-- Add this input field inside your form -->
                    <input type="hidden" name="movie_title" value="<?php echo htmlspecialchars($movie_title); ?>">
                    <textarea maxlength="150" placeholder="Feedback" class="form-control" rows="3"
                              name="feedbackForm" required></textarea>
                    <input style="margin-top: 10px; margin-bottom: 30px; width:30%;" type="submit" name="feedback_submit"
                           class="feedbackbtn">
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        var video = document.getElementById('video1');
        video.volume = 0.25; // Set volume to 25% (0.25)
    });
</script>



</body>
</html>
