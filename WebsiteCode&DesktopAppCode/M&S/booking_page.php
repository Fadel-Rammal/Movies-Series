<?php
// Include necessary files
include('header.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Title</title>
   


<style>




        body {
            background-image: url('images/popcorn.jpg');
            background-size: cover;
            /* Add any additional background properties here */
        }


/* style.css */
form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

select, input[type="button"] {
    width: 200px;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#showtimes {
    margin-top: 10px;
}

input[type="radio"] {
    margin-right: 5px;
}



#form-container {
    /* position: fixed; */ /* Remove this line */
    /* Adjust positioning */
    position: relative;
    margin: 20px auto; /* Adjust margin as needed */
    
    
    right: 20%;
    width: 20%; /* Adjust width as needed */
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); /* Shadow effect */
}


:root {
    --citrine: hsl(57, 97%, 45%);
    
}


input[type="button"]:hover {
    background-color:var(--citrine); /* Change background color on hover */
    color: white; /* Change text color on hover */
    cursor: pointer; /* Change cursor to pointer on hover */
}


select {
    width: 220px; /* Adjust the width as needed */
    padding: 8px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.clear-button {
    width: 100px; /* Adjust the width as needed */
    padding: 8px;
    margin-top: 5px; /* Adjust margin spacing */
    background-color: transparent;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px; /* Adjust font size */
    cursor: pointer;
    transition: background-color 0.3s; /* Smooth transition for hover effect */
}



    </style>


</head>
<body>





<br>


<div id="form-container">
<?php
include('connection.php');

// Function to append parameters to the URL
function appendParametersToURL($url, $params) {
    $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($params);
    return $url;
}

// Check if movie parameter is set in the URL
if(isset($_GET['movie'])) {
    $movie = $_GET['movie'];

   
    $sql = "SELECT DISTINCT cinemaloc FROM changemovie WHERE movie_name = '$movie'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if($result) {
        
        echo "<form id='showTimeForm'>"; // Updated form id
        echo "<label for='cinemaloc'>Select Cinema Location:</label>";
        echo "<select name='cinemaloc' id='cinemaloc' onchange='getMoreInfo()'>";
        echo "<option value=''>Select Cinema Location</option>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['cinemaloc']}'";
            if(isset($_GET['cinemaloc']) && $_GET['cinemaloc'] === $row['cinemaloc']) {
                echo " selected";
            }
            echo ">{$row['cinemaloc']}</option>";
        }
        echo "</select>";

     
        echo "<label for='cinemanam'>Select Cinema Name:</label>";
        echo "<select name='cinemanam' id='cinemanam' onchange='getRoomNumbers()'>";
        echo "<option value='' selected>Select Cinema Name</option>"; // Set default value
        echo "</select>";

        // Display Screen Code dropdown list
        echo "<label for='roomnb'>Select Room Number:</label>";
        echo "<select name='roomnb' id='roomnb' onchange='getShowTimes()'>";
        echo "<option value='' selected>Select Room Number</option>"; // Set default value
        echo "</select>";

        // Display Show Times
        echo "<label for='showtime'>Select Show Time:</label>";
        echo "<div id='showtimes'></div>";
        echo "<input type='button' value='Submit' onclick='submitForm()'>"; // Changed input type to button
        echo "<br>"; // Add a line break
        echo "<input type='button' value='Clear' onclick='clearForm()'>"; //Clear button

        echo "</form>";
    } else {
        echo "Error fetching cinema locations.";
    }
} else {
    echo "Movie parameter is missing.";
}

// Save selected values in session variables and append to URL when submitted
if(isset($_GET['cinemaloc']) && isset($_GET['roomnb']) && isset($_GET['showtime'])) {
    $_SESSION['cinemaloc'] = $_GET['cinemaloc'];
    $_SESSION['roomnb'] = $_GET['roomnb'];
    // Extract the selected shownb from the radio button
    if(isset($_GET['shownb'])) {
        // Split the value to get the shownb (assuming it's separated by '|')
        $shownb = explode('|', $_GET['shownb'])[0];
        $_SESSION['shownb'] = $shownb;
    }
    $_SESSION['showtime'] = $_GET['showtime'];

    // Redirect to select_seat.php with parameters in the URL
    header("Location: select_seat.php?" . http_build_query($_GET));
    exit();
}
?>
</div>

<script>
// Function to fetch More Information based on selected location
function getMoreInfo() {
    var cinemaloc = document.getElementById('cinemaloc').value;
    var movie = getUrlParameter('movie'); // Get the movie parameter from the URL
    if (cinemaloc !== '') {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_more_info.php?cinemaloc=' + cinemaloc + '&movie=' + encodeURIComponent(movie), true); // Pass the movie parameter
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('cinemanam').innerHTML = xhr.responseText;
                // Reset Screen Code dropdown
                document.getElementById('roomnb').innerHTML = '<option value="" selected>Select Room Number</option>';
                // Clear Show Times
                document.getElementById('showtimes').innerHTML = '';
            }
        };
        xhr.send();
    } else {
        // If cinemaloc is not selected, reset the More Information dropdown to default
        document.getElementById('cinemanam').innerHTML = '<option value="" selected>Select Cinema</option>';
        // Reset Screen Code dropdown
        document.getElementById('roomnb').innerHTML = '<option value="" selected>Select Room Number</option>';
        // Clear Show Times
        document.getElementById('showtimes').innerHTML = '';
    }
}

// Function to fetch Screen Codes based on selected More Information
function getRoomNumbers() {
    var cinemaloc = document.getElementById('cinemaloc').value;
    var moreInfo = document.getElementById('cinemanam').value;
    var movie = getUrlParameter('movie'); // Get the movie parameter from the URL
    if (moreInfo !== '') {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_screen_codes.php?cinemaloc=' + cinemaloc + '&cinemanam=' + moreInfo + '&movie=' + encodeURIComponent(movie), true); // Pass the movie parameter
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Clear previous options and set the default option
                document.getElementById('roomnb').innerHTML = '<option value="" selected>Select Room Number</option>';
                // Populate options if data is received
                var response = xhr.responseText.trim();
                if (response !== '') {
                    document.getElementById('roomnb').innerHTML += response;
                }
            }
        };
        xhr.send();
    } else {
        // If More Information is not selected, reset the Screen Code dropdown to default
        document.getElementById('roomnb').innerHTML = '<option value="" selected>Select Room Number</option>';
        // Clear Show Times
        document.getElementById('showtimes').innerHTML = '';
    }
}

// Function to fetch Show Times based on selected Screen Code
function getShowTimes() {
    var cinemaloc = document.getElementById('cinemaloc').value;
    var moreInfo = document.getElementById('cinemanam').value;
    var roomnb = document.getElementById('roomnb').value;
    var movie = getUrlParameter('movie'); // Get the movie parameter from the URL

    // Check if the user has interacted with the roomnb dropdown
    // If not, don't make the request
    if (roomnb === '') {
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_show_times.php?cinemaloc=' + cinemaloc + '&cinemanam=' + moreInfo + '&roomnb=' + roomnb + '&movie=' + encodeURIComponent(movie), true); // Pass the movie parameter
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var showtimes = JSON.parse(xhr.responseText);
            var showtimesDiv = document.getElementById('showtimes');
            showtimesDiv.innerHTML = ''; // Clear previous content
            // Loop through the received showtimes and create radio buttons for each
            showtimes.forEach(function(showtime) {
                var radioBtn = document.createElement('input');
                radioBtn.type = 'radio';
                radioBtn.name = 'shownb';
                radioBtn.value = showtime.shownb; // Set the shownb as the value
                var label = document.createElement('label');

label.innerHTML = `Shownb: ${showtime.shownb}<br>Start Time: ${showtime.start_time}<br>End Time: ${showtime.end_time}`;


                // Append radio button and label to the container
                showtimesDiv.appendChild(radioBtn);
                showtimesDiv.appendChild(label);
                // Add a line break for readability
                showtimesDiv.appendChild(document.createElement('br'));
            });
        }
    };
    xhr.send();
}

// Function to submit the form with selected values appended to the URL
function submitForm() {
    var cinemaloc = document.getElementById('cinemaloc').value; // Get selected cinema location
    var moreInfo = document.getElementById('cinemanam').value; // Get selected more information
    var roomnb = document.getElementById('roomnb').value; // Get selected screen code
    var shownb = document.querySelector('input[name="shownb"]:checked').value; // Get selected shownb

    // Get the start time and end time from the selected radio button
    var selectedRadio = document.querySelector('input[name="shownb"]:checked + label').textContent;
    var startTime = selectedRadio.split('Start Time: ')[1].split('End Time: ')[0];
    var endTime = selectedRadio.split('End Time: ')[1];

    var url = 'select_seat.php?' + 'cinemaloc=' + encodeURIComponent(cinemaloc) + '&cinemanam=' + encodeURIComponent(moreInfo) + '&roomnb=' + encodeURIComponent(roomnb) + '&shownb=' + encodeURIComponent(shownb) + '&start_time=' + encodeURIComponent(startTime) + '&end_time=' + encodeURIComponent(endTime) + '&movie=' + encodeURIComponent(getUrlParameter('movie'));
    window.location.href = url; // Redirect to the constructed URL
}


// Function to get URL parameters
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}
</script>

<!-- JavaScript -->
<script>
// Function to clear the form fields
function clearForm() {
    
    document.getElementById('cinemaloc').selectedIndex = 0;
    // Reset More Information dropdown
    document.getElementById('cinemanam').selectedIndex = 0;
    // Reset Screen Code dropdown
    document.getElementById('roomnb').selectedIndex = 0;
    // Clear Show Times
    document.getElementById('showtimes').innerHTML = '';
}
</script>








</body>
</html>