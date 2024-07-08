


<!DOCTYPE html>
<html lang="en">

<head>

<style>

.wel-confirm{

    padding-top:100px; 
    background-image: url('images/banner2.jpg') !important; 
    background-attachment: fixed;
    background-size: cover;
    background-repeat:no-repeat;
    font-family: 'Jost', sans-serif;

}


  

</style>



</head>



    <title>Confirmation</title>
    <link rel="stylesheet" type="text/css" href="css/radiobuttons.css">

 <?php include('header.php'); ?>
 <?php
    $username = '';
    $username = $_SESSION['username'];
    $userToken = $_SESSION['usertoken'];
    $booking_id = $_SESSION['booking_id'];
	$cinemanam = $_SESSION['cinemanam'];
	$cinemaloc = $_SESSION['cinemaloc'];
	$movie = $_SESSION['movie'];

$start_datetime = $_SESSION['start_time'];
$end_datetime = $_SESSION['end_time'];
    
$firstName = $_SESSION['firstName'];

// Split date and time
    list($start_date, $start_time) = explode(" ", $start_datetime);
    list($end_date, $end_time) = explode(" ", $end_datetime);

    // Function to convert time to AM/PM format
    function format_time($time) {
        return date("h:i A", strtotime($time));
    }


 ?>

 <?php 
    include('connection.php'); 
    $sql = "SELECT user_id,booking_id,time_booking,seat_id,roomnb,shownb,movietitle FROM bookings WHERE booking_id = $booking_id";
    $result = mysqli_query($conn,$sql);

    $booking = mysqli_fetch_all($result);
 
    foreach($booking as $bok){
        $roomnb = $bok[4];
        $timeBook = $bok[2];
        $seatno = $bok[3];
        $shownb = $bok[5];
        $movie_title = $bok[6];
    }
 
 
 
 
 
 ?>



    <body>
        
        <!-- title of page -->
        
        <div class="row wel-confirm" style="padding-bottom: 100px;">

            <div class="col-md-4"></div>
            <div class="col-md-4">

                <div class="card text-center">
                    <div class="card-header text-success">
                       <b> Booked!</b>
                    </div>
                    <div class="card-body text-left">
                        <h5 class="card-title"><b>User :</b> <?php echo $firstName; ?></h5>
                        <p class="card-text"><b>Movie Title :</b> <?php  echo $movie;  ?></p>
			<p class="card-text"><b>Cinema Name:</b> <?php  echo $cinemanam;  ?></p>
			<p class="card-text"><b>Cinema Location:</b> <?php  echo $cinemaloc;  ?></p>
                        <p class="card-text"><b>Booking ID :</b> <?php  echo $booking_id;  ?></p>
                        <p class="card-text"><b>Screen No :</b> <?php  echo $roomnb;  ?></p>
                        <p class="card-text"><b>Show Time :</b> <?php 


			
    echo date("M j, Y", strtotime($start_date)) . " " . format_time($start_time) . " - " . date("M j, Y", strtotime($end_date)) . " " . format_time($end_time); 

			



                        
                       ?> </p>
                        <p class="card-text"><b>Seat No :</b> <?php  echo $seatno;  ?></p>
                        <p class="card-text"><b>Time of Booking :</b> <?php  echo $timeBook;  ?></p>
                        
                    </div>
                    <div class="card-footer text-success">
                        Thank you <?php echo $_SESSION['firstName']; ?> for booking with us!
                    </div>
                 </div>
                 <br>
                   <h6 style="color: white; text-align:center;">Scroll Down</h6>
            </div>
            <div class="col-md-4"></div>

        </div>
     
        
           


       <!-- Google Maps and Rating  -->
<div class="container">
    <div class="row justify-content-center" style="margin-top: 20px; margin-bottom: 40px;">
        <div class="col-6 text-center">
            <!-- Direction  -->
            <h6>Our Location</h6>
            <hr style="border:#464E59 solid 0.5px">
            <?php
            // Fetch the map link from the changemovie table based on the movie_title
            $sql_location = "SELECT maplink FROM changemovie WHERE cinemanam = '$cinemanam'";
            $result_location = mysqli_query($conn, $sql_location);
            $row_location = mysqli_fetch_assoc($result_location);
            $map_link = $row_location['maplink'];

            // Display the map link as an embedded iframe
            echo '<iframe src="' . $map_link . '" width="100%" height="250" frameborder="0" style="border: 2px solid #000;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>';
            ?>
        </div>
    </div>
</div>



                     
    </body>

</html>







