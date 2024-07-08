<?php include("db_connect.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/movie-detail.css" />
  <title>Movie Details</title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Heebo&family=Outfit:wght@300&family=Righteous&family=Squada+One&family=Staatliches&display=swap");
    /* CSS for actors section */
    #actors {
      display: flex;
      flex-wrap: wrap;
    }

	:root {
--citrine: hsl(57, 97%, 45%);
}

    .actor {
      flex: 0 0 calc(33.33% - 20px); /* Adjust width as needed */
      margin: 10px;
      text-align: center;
    }

    .actor img {
      width: 100px; /* Adjust image size */
      height: 150px;
      object-fit: cover;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <div id="main">
    <div id="description">
      <div class="content">
      <?php
if (isset($_REQUEST['movie_id'])) {
  $id = $_REQUEST['movie_id'];
  $sql1 = 'SELECT movies.movie_title, movies.description, movies.rating, movies.release_date, movies.durations, movies.movie_image, categories.categorie_name, movies.url_trailer 
          FROM movies 
          LEFT JOIN categories ON categories.categorie_id = movies.categorie_id 
          WHERE movies.movie_id = ' . $id;
  $result = $connection->query($sql1);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Fetch ratings for the movie from feedbackform table
    $sql2 = "SELECT AVG(rating) AS avg_rating FROM feedbackform WHERE movie_title = '" . $row['movie_title'] . "'";
    $ratingResult = $connection->query($sql2);
    $ratingRow = $ratingResult->fetch_assoc();
    $averageRating = $ratingRow['avg_rating'];
?>
    <div id="movie-image">
      <img src="image/<?php echo $row['movie_image'] ?>" alt="" />
    </div>
    <div id="middle">
      <div id="movie-title"> <?php echo $row['movie_title'] ?></div>
      <div id="movie-datetime"> <?php echo $row['release_date'] ?> <br /> <?php echo $row['durations'] ?></div>
      <div id="movie-genre">
    <?php echo $row['categorie_name'] ?><br>
    <?php if ($averageRating !== null) { ?>
        <br> <span style="color: var(--citrine);">M&S Average Rating: <?php echo number_format($averageRating, 1) ?>/5</span>
    <?php } else { ?>
        <br> <span style="color: var(--citrine);">No M&S Rating</span>
    <?php } ?>
</div>
<div id="movie-description"> <?php echo $row['description'] ?></div>
<div id="btnShowtime">

        <a href="index.php">Go Back</a>
      </div>
    </div>

            <div id="movie-screen-types">
              
            </div>
      </div>
  
    </div>
    <div class="trialer"><?php echo $row['url_trailer']?></div>
    <?php 
          $movieTitle = $row['movie_title'];
          // Embed imdb.html and pass the movie title as a query parameter
        
         echo '<iframe src="imdb.html?movie_title=' . urlencode($movieTitle) . '" width="100%" height="500px" frameborder="0" style="border: none;"></iframe>';


        }
      } 
    ?>
  </div>
</body>

</html>