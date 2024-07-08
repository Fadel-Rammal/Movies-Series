<?php include('header.php'); ?>
<?php 
include('connection.php');

// Getting User's money balance 
$userid = $_SESSION['usertoken'];
$sql = "SELECT credits FROM userinfo WHERE id='$userid'";
$result = mysqli_query($conn,$sql);
$car = mysqli_fetch_array($result,MYSQLI_ASSOC);

$balance = $car['credits'];


// Define the SQL query to retrieve maplink
$cinemanam = $_SESSION['cinemanam'];
$sql_location = "SELECT maplink FROM changemovie WHERE cinemanam = ?";
$stmt_location = $conn->prepare($sql_location);
$stmt_location->bind_param("s", $cinemanam);
$stmt_location->execute();
$result_location = $stmt_location->get_result();
$maplink_row = $result_location->fetch_assoc();
$maplink = $maplink_row['maplink'];


if(isset($_POST['makepayment'])){

    //booking process
    $userid = $_SESSION['usertoken'] ;
    $roomnb = $_SESSION['roomnb'];
    $shownb = $_SESSION['shownb'];
$cinemaloc = $_SESSION['cinemaloc'];
$cinemanam = $_SESSION['cinemanam'];

$start_datetime = $_SESSION['start_time'];
$end_datetime = $_SESSION['end_time'];
    
$firstName = $_SESSION['firstName'];
$movie = $_SESSION['movie'];


    $data  =$_SESSION['seatname'];
        //$getTitle = "SELECT cinemaloc FROM changemovie WHERE roomnb=$roomnb";

	//$getTitle = "SELECT cinemanam FROM changemovie WHERE roomnb=$roomnb AND shownb = $shownb AND cinemaloc = $cinemaloc";

        //$result = mysqli_query($conn,$getTitle);

        //$titleResult = mysqli_fetch_array($result);

        //$movie_title = $titleResult['cinemanam'];

        
        
        $sql = "INSERT INTO bookings (seat_id,user_id,roomnb,shownb,movietitle, locationlink, cinemaloc, cinemanam, user, start_time, end_time) 
VALUES ('$data','$userid','$roomnb','$shownb','$movie', '$maplink', '$cinemaloc', '$cinemanam', '$firstName', '$start_datetime', '$end_datetime')";

        if ($conn->query($sql) === TRUE) {
            //seatbooked
            $last_id = $conn->insert_id;
            $_SESSION['booking_id'] = $last_id;

            //deductBalance
            $totalcost = $_SESSION['totalcost'];
            $balance-=$totalcost;
            
            $up = "UPDATE userinfo SET credits=$balance WHERE id=$userid";
            if(mysqli_query($conn, $up)){ 
                
            } else { 
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn); 
            } 




            header('Location:confirmation.php?$last_id');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
}

if(isset($_POST['submit'])){
    $promo_error="";
    $promo_flag="unset";
    if(empty($_POST['seats'])){
        //checks if user submits empty
        
        header('location:select_seat.php?error_seat=select atleast one seat');
    }else{

        $totalseats = $_POST['seats'];
        $totalcost=0;
        $numberofseats=0;


        foreach($totalseats as $seat){
            $totalcost+=50;
            $numberofseats+=1;
        }
        
        $_SESSION['totalcost'] = $totalcost;
        $_SESSION['noseats'] = $numberofseats;
        $bookedSeats = $_POST['seats'];
        $data = array();

        foreach($bookedSeats as $seat)
        
            // $data[] = "(" . addslashes($seat) . ")";
            $data[] = addslashes($seat);
        
        $data = implode("," , $data);
        $_SESSION['seatname'] = $data;
    }

}

?>



<!DOCTYPE html>
<html lang="en">

<head>

<style>

.wel-pay {
    font-family: 'Jost', sans-serif;
    margin-top: 170px; /* Adjust the margin-top value as needed */
}


body {
    /* Set the background image */
    background-image: url('images/coins.png');

    /* Specify background image size and behavior */
    background-size: cover; /* Ensure the entire background image is visible */
    
    background-repeat:no-repeat; /* Do not repeat the background image */
}


:root {
    --citrine: hsl(57, 97%, 45%);
    --citrine-dark: hsl(57, 97%, 55%); /* Define a darker shade of citrine */
	--citrine-darkk: hsl(57, 97%, 15%);
}


.paybtn {
    display: block;
    width: 100px;
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

.paybtn:hover {
    background-color: var(--citrine-dark);
}

.text-success {
    color: var(--citrine-darkk) !important; /* Set the text color to green */
}


</style>


</head>
    
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
    <body class="wel-pay">
        <div class="container" style="margin-bottom: 70px;">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-5">
                    <div class="card">
                        <div class="card-inner">
                        <div class="card-title">
                            <h4>Make Payment To Book Your Tickets</h4>
                            <hr style="border:#464E59 solid 0.5px">
                            <?php 
                            
                            if($balance < $_SESSION['totalcost']){
                                echo "<h6 style='color:red;'>Your credits are lower than total cost of tickets!</h6>";
                            }
                            
                            ?>
                        </div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td><b>Cost / Ticket :</b> 50</td>
                                </tr>
                                <tr>
                                    <td><b>Total Seats :</b> <?php echo $_SESSION['noseats']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Total Cost  : </b> <?php echo $_SESSION['totalcost']; ?></td>
                                </tr>
                                <tr>

                                </tr>
                                <br>
                                
                            </table>
                            
                         
                        </div>
                        <hr style="border:#464E59 solid 0.5px">

                        <div class="row">
                            <div class="col-8">
                            
                            <?php 
                                    if($balance >= $_SESSION['totalcost']){
                                        echo "<h5 style='padding-left:20px;' class='text-success'>Your Balance : $balance</h5>";
                                    }else{
                                        echo "<h5 style='padding-left:20px;' class='text-danger'>Your Balance : $balance</h5>";

                                    }
                            
                                ?> 
                            </div>
                            <div class="col-4">

                                <form action="payment.php" method="POST">
                                <?php 
                                    if($balance >= $_SESSION['totalcost']){
                                        echo "<input class='paybtn' style='float: right;' type='submit' name='makepayment' value='Pay' >";
                                    }else{
                                        echo '<a href="index.php" class="btn btn-danger" style="float:right;">Go Back</button></a>';
                                    }
                            
                                ?> 
                                </form>

                            </div>
                        </div>
                        
                        
                            
                        
                        </div>
                        
                    

        
    </body>
</html>