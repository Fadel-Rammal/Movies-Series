<?php
// Include necessary files
include('connection.php');

// Check if cinemaloc, cinemanam, and roomnb parameters are set
if(isset($_GET['cinemaloc']) && isset($_GET['cinemanam']) && isset($_GET['roomnb'])) {
    // Retrieve cinemaloc, cinemanam, and roomnb parameters from the URL
    $cinemaloc = $_GET['cinemaloc'];
    $cinemanam = $_GET['cinemanam'];
    $roomnb = $_GET['roomnb'];
    
    // Retrieve movie parameter from the URL
    $movie = $_GET['movie'];
    
    // Fetch show times based on the selected cinemaloc, cinemanam, and roomnb
    $sql = "SELECT * FROM changemovie WHERE cinemaloc = '$cinemaloc' AND cinemanam = '$cinemanam' AND roomnb = '$roomnb' AND movie_name = '$movie'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if($result) {
        // Fetch the data and encode it as JSON
        $rows = array();
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo "Error fetching show times.";
    }
} else {
    echo "Invalid request.";
}
?>
