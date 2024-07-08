<?php
// Include database connection
include('connection.php');

// Check if cinemaloc and movie parameters are set
if(isset($_GET['cinemaloc']) && isset($_GET['movie'])) {
    // Retrieve cinemaloc and movie parameters
    $cinemaloc = $_GET['cinemaloc'];
    $movie = $_GET['movie'];

    // Fetch additional information based on the selected cinema location and movie parameter
    $sql = "SELECT DISTINCT cinemanam FROM changemovie WHERE cinemaloc = '$cinemaloc' AND movie_name = '$movie'"; // Filter by movie
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if($result) {
        // Return dropdown options
        echo "<option value='' selected>Select Cinema Name</option>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['cinemanam']}'>{$row['cinemanam']}</option>";
        }
    } else {
        echo "Error fetching cinema names information.";
    }
} else {
    echo "Invalid request.";
}
?>
