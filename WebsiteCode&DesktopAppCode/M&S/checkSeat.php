<?php 
   
    include('connection.php');
    $roomnb = $_SESSION['roomnb'];
    $shownb = $_SESSION['shownb'];
    $cinemanam = $_SESSION['cinemanam']; // changed variable name from $cinemanam to $cinemanam
    
    // Select seat_id from bookings where roomnb, shownb, and cinemanam match the provided values
    $sql = "SELECT seat_id FROM bookings WHERE roomnb = '$roomnb' AND shownb = '$shownb' AND cinemanam = '$cinemanam'";
    
    $result = mysqli_query($conn, $sql);

    $seatid = mysqli_fetch_all($result);
    
    $bookedSeat = array();
    foreach($seatid as $id){
        $bookedSeat[] = $id[0];
    }

    $ajay = '';
    for($i = 0; $i < count($bookedSeat); $i++){
        $ajay = $ajay . $bookedSeat[$i] . ",";
    }

    $ajaycomma = explode(",", $ajay);
    
    function checkme($seatidd, $ajaycomma){
        $disabled = '';
       
        foreach($ajaycomma as $m){
            if($seatidd == $m) {
                $disabled = $disabled . "disabled";

            }
        }

        echo $disabled;
    }
?>
