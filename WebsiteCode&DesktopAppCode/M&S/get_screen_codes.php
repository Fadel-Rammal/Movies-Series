<?php
// Include necessary files
include('connection.php');

// Check if location and cinemanam parameters are set in the URL
if(isset($_GET['cinemaloc']) && isset($_GET['cinemanam'])) {
    // Retrieve location and cinemanam parameters from the URL
    $cinemaloc = $_GET['cinemaloc'];
    $cinemanam = $_GET['cinemanam'];

    // Retrieve movie parameter from the URL
    $movie = $_GET['movie'];

    // Fetch distinct room numbers based on the provided cinemaloc, cinemanam, and movie parameters
    $sql = "SELECT DISTINCT roomnb FROM changemovie WHERE cinemaloc = '$cinemaloc' AND cinemanam = '$cinemanam' AND movie_name = '$movie'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if($result) {
        // Create dropdown options based on the fetched room numbers
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['roomnb']}'>{$row['roomnb']}</option>";
        }
    } else {
        echo "Error fetching screen codes.";
    }
} else {
    echo "Location and name parameters are missing.";
}
?>
