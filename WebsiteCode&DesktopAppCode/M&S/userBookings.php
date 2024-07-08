<?php 

include('header.php');

?>



<?php
include('connection.php');

if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM bookings WHERE booking_id = $id_to_delete";

    if(mysqli_query($conn, $sql)){
        header('Location: index.php');
    } else {
        echo 'query error: '. mysqli_error($conn);
    }

}



// Retrieve user token from session
$userToken = $_SESSION['usertoken'];

// Query to get user's money balance
$sql = "SELECT credits FROM userinfo WHERE id='$userToken'";
$result = mysqli_query($conn, $sql);
$car = mysqli_fetch_array($result, MYSQLI_ASSOC);
$balance = $car['credits'];

// Query to retrieve bookings
$sql = "SELECT user_id, booking_id, time_booking, seat_id, roomnb, shownb, movietitle, cinemanam, cinemaloc, user, start_time, end_time FROM bookings ORDER BY time_booking DESC";
$result = mysqli_query($conn, $sql);

if($result) {
    // Fetch data as an associative array
    $booking = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo 'query error: '. mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>





  
</head>





<body class="wel-mybooking">
    <div class="container">
        <div class="row">
            <div class="col-5"></div>
            <div class="col-7">
                <div class="balance text-center" style="border: solid green 1px; padding-top:10px; margin-left:30%; margin-right:30%; border-radius:5px;">
                    <h5>Balance : <?php echo $balance; ?></h5>
                </div>
                <div class="container">
                    <?php foreach($booking as $bok) { ?>
                        <?php if($bok['user_id'] == $userToken) { ?>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col"></div>
                                <div class="col-10">
                                    <div class="card" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                                        <div class="card-body" style="background-color:#F2F2F2;">
                                            <p class="card-text text-success">
						<h6><b>Cinema Location : </b> <?php echo htmlspecialchars($bok['cinemanam']); ?></h6>
                                                <h6><b>Cinema Name : </b> <?php echo htmlspecialchars($bok['movietitle']); ?></h6>
						<h6><b>Movie Title : </b> <?php echo htmlspecialchars($bok['cinemaloc']); ?></h6>
                                                <h6><b>User ID : </b> <?php echo htmlspecialchars($bok['user_id']); ?></h6>
						<h6><b>User Name : </b> <?php echo htmlspecialchars($bok['user']); ?></h6>
                                                <div><b>Booking ID : </b><?php echo htmlspecialchars($bok['booking_id']); ?></div>
                                                <div><b>Screen Code : </b><?php echo htmlspecialchars($bok['roomnb']); ?></div>
						<div><b>Show Code : </b><?php echo htmlspecialchars($bok['shownb']); ?></div>
                                                <div><b>Start Time: </b><?php echo htmlspecialchars($bok['start_time']); ?></div>
                                                <div><b>Seat No: </b><?php echo htmlspecialchars($bok['seat_id']); ?></div>
                                                <div><b>Booking Time : </b>  <?php echo htmlspecialchars($bok['time_booking']); ?></div>  
						<div><b>End Time: </b><?php echo htmlspecialchars($bok['end_time']); ?></div>
                                            </p>
                                            <div class="text-right">
                                                <form action="userBookings.php" method="POST">
                                                    <input type="hidden" name="id_to_delete" value="<?php echo $bok['booking_id']; ?>">
                                                    <input type="submit" name="delete" value="Clear" class="btn btn-outline-danger btn-sm">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>
