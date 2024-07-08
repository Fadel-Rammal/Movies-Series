<?php 
include('connection.php');

// Check for SQL errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT movie_title, rating, feedback, username 
        FROM feedbackform";


$result = mysqli_query($conn, $sql);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch all rows from the result set
$feedback_entries = mysqli_fetch_all($result, MYSQLI_ASSOC);

include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<body>
    
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <?php 
            // Check if there are any feedback entries
            if ($feedback_entries) {
                foreach($feedback_entries as $entry) { ?>
                    <div class="col-4">
                        <div class="card" style="margin: 20px;box-shadow: 0 4px 8px 0 rgba(255,98,90, 0.2);">
                            <div class="card-body">
                                <p> <b> <?php echo $entry['username']; ?><br> </b> <?php echo $entry['movie_title']; ?> <br><?php 
                                    $stars = intval($entry['rating']);
                                    for ($i = 1; $i <= $stars; $i++) {
                                        echo '<span style="color: #ffca08; display: inline-block;">★</span>';
                                    }
                                    ?>   </p>
                               
                              
                                <p><?php echo $entry['feedback']; ?></p>
                            </div>
                        </div>
                    </div>
            <?php 
                }
            } else {
                echo "<p>No feedback entries found.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
