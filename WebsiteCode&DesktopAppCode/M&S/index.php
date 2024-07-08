<?php
session_start(); // Start the session

include('header.php');
include('connection.php');
?>






<?php 
$welcomeName='';
if(isset($_SESSION['username'])) {   
    $welcomeName = $_SESSION['username'];
}
?>



<?php
// Initialize the variable to avoid "Undefined variable" notice
$mainToggleSwitchChecked = "";

// Check if the user is logged in
if(isset($_SESSION['usertoken'])) {
    // User is logged in, fetch user status and main toggle switch state from the database
    $user_id = $_SESSION["usertoken"];
    $status_sql = "SELECT status FROM userinfo WHERE id = '$user_id'";
    $status_result = mysqli_query($conn, $status_sql);
    $user_status = "inactive"; // Default status
    if (mysqli_num_rows($status_result) > 0) {
        $row = mysqli_fetch_assoc($status_result);
        $user_status = $row["status"];
    }

    
    
} else {
    // User is not logged in, set default status
    $user_status = "inactive";
}

// Disable toggle switches and buttons if user status is inactive
$switchDisabled = ($user_status === "inactive") ? "disabled" : "";
//$buttonDisabled = ($user_status === "inactive") ? "disabled" : "";
?>





<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
        body {
            font-family: 'Jost', sans-serif;
        }
.movie-button {
  color: var(--white);
  font-size: var(--fs-11);
  font-weight: var(--fw-700);
  text-transform: uppercase;
  letter-spacing: 2px;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 16px 30px;
  border: 2px solid var(--citrine);
  border-radius: 50px;
  transition: var(--transition-1);
  background: var(--rich-black-fogra-29);
}

.movie-button > ion-icon {
  font-size: 18px;
}

.movie-button:is(:hover, :focus) {
  background: var(--citrine);
  color: var(--xiketic);
}



/* Style the switch */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* Style the switch when toggled ON */
.switch input:checked + .slider {
  background-color: var(--citrine); /* Change the background color */
}

/* Rounded sliders */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 34px;
}

/* Rounded sliders: Before */
.slider::before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%;
}


/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}



/* Modal styles */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 30px;
  border: 1px solid #888;
  width: 50%;
  max-width: 500px; /* Adjust the maximum width as needed */
  text-align: center; /* Center align content */
  display: flex;
  flex-direction: column;
}

/* Close button styles */
.close {
  color: #aaa;
  font-size: 28px;
  font-weight: bold;
  align-self: flex-end; /* Align the button to the right */
}

/* Button styles */
.modal-content button {
  width: 150px; /* Adjust the width of the button as needed */
  padding: 10px; /* Adjust the padding of the button as needed */
  margin-top: 20px; /* Add space between text field and button */
  margin-bottom: 20px; /* Add space between text field and button */
  font-size: 16px; /* Adjust the font size of the button as needed */
  border: none;
  border-radius: 5px;
  background-color: var(--citrine); /* Set the background color */
  color: black; /* Set the text color */
  cursor: pointer;
  transition: background-color 0.3s; /* Add transition effect for hover */
  align-self: flex-end; /* Align the button to the right */
}

/* Hover effect */
.modal-content button:hover {
  background-color: yellow; /* Change to desired hover color */
}




.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}



.btn.btn-primary {
  background-color: var(--citrine) !important;
  border-color: var(--citrine) !important;
  color: black !important;
  font-weight: 600 !important; /* Slightly bolder text */
}

.btn.btn-primary:hover {
  background-color: var(--citrine) !important;
  filter: brightness(85%) !important; /* Darken the button slightly when hovered */
}






#controlButton {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#controlButton.green {
    background-color: green;
    color: white;
}

#controlButton.red {
    background-color: red;
    color: white;
}


#controlButton {
    display: block;
    margin: 20px auto; /* This will center the button horizontally and add 20px margin up and down */
}



.footer{
    background-color:black !important;
    
}


    </style>


 <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Film</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="css/stylee.css">


  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">


<link rel="stylesheet" href="css/style-starter.css">

</head>
<body>



  <!-- main-slider -->
	<section class="w3l-main-slider position-relative" id="home">
		<div class="companies20-content">
			<div class="owl-one owl-carousel owl-theme">
				<div class="item">
					<li>
						<div class="slider-info banner-view bg bg2"  style="min-height: 400px;">
							<div class="banner-info">
								<h3>Create Your Best Memories With Us!</h3>
								
								<a class="popup-with-zoom-anim play-view1">
									<span class="video-play-icon">
										<span class="fa fa-play"></span>
									</span>
									
								</a>
								
							</div>
						</div>
					</li>
				</div>
				<div class="item">
					<li>
						<div class="slider-info  banner-view banner-top1 bg bg2" style="min-height: 400px;">
							<div class="banner-info">
								<h3>Best Family Content</h3>
								
								<a  class="popup-with-zoom-anim play-view1">
									<span class="video-play-icon">
										<span class="fa fa-play"></span>
									</span>
									
								</a>
								
							</div>
						</div>
					</li>
				</div>
				<div class="item">
					<li>
						<div class="slider-info banner-view banner-top2 bg bg2" style="min-height: 400px;">
							<div class="banner-info">
								<h3>Book With Us!</h3>
								
								<a  class="popup-with-zoom-anim play-view1">
									<span class="video-play-icon">
										<span class="fa fa-play"></span>
									</span>
									
								</a>
								
							</div>
						</div>
					</li>
				</div>
				<div class="item">
					<li>
						<div class="slider-info banner-view banner-top3 bg bg2" style="min-height: 400px;">
							<div class="banner-info">
								<h3>Online Movies</h3>
								
								<a  class="popup-with-zoom-anim play-view1">
									<span class="video-play-icon">
										<span class="fa fa-play"></span>
									</span>
									
								</a>
								
							</div>
						</div>
					</li>
				</div>
			</div>
		</div>
	</section>
	<!-- main-slider -->





















<button id="controlButton" >Main Parental Control</button>








<!-- Modal -->
<div id="passwordModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Enter Password</h2>
    <input type="password" id="passwordInput" placeholder="Enter your password">
    <button id="passwordSubmit">Submit</button>
  </div>
</div>




      <!--
        - #UPCOMING

      -->
      <section class="top-rated">
        <div class="container">

            <p class="section-subtitle">In Cinema</p>
        <h2 class="h2 section-title">NOW SHOWING</h2>

          
         
          <ul class="movies-list">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Movies&Series";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }
            $sql = 'SELECT * FROM movies WHERE movie_status="oncinema"';
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              // output data of each row
              while ($row = $result->fetch_assoc()) {
            ?>
                <!-- Bumble bee starts here -->
                <li>
                  <div class="movie-card">

                    <?php

                    ?>
                    <a href="movie-detail.php?movie_id=<?php echo $row['movie_id'] ?>">
                      <figure class="card-banner">
                        <img src="image/<?php echo $row['movie_image']; ?>">
                      </figure>
                    </a>

                    <div class="title-wrapper">
  <a href="movie-detail.php?movie_id=<?php echo $row['movie_id'] ?>">
    <h3 class="card-title"><?php echo $row['movie_title'] ?></h3>
  </a>

  <time datetime="2022"><?php $release_date = $row['release_date'];
                          echo date('Y',strtotime($release_date))  ?>
    <?php
    // Fetch and display the category name
    $category_id = $row['categorie_id'];
    $category_query = "SELECT categorie_name FROM categories WHERE categorie_id = $category_id";
    $category_result = $conn->query($category_query);
    if ($category_result && $category_row = $category_result->fetch_assoc()) {
      echo " - " . $category_row['categorie_name'];
    }
    ?>
  </time>
</div>


                    <div class="card-meta">
                      

                      <div class="duration">
                        <ion-icon name="time-outline"></ion-icon>

                        <time datetime="PT122M"><?php $du = $row['durations'];
                                                echo $du ?></time>
                      </div>

                      <div class="rating">
                        <ion-icon name="star"></ion-icon>
                        <data><?php $rating = $row['rating'];
                              if ($rating == "") {
                                echo "N/A";
                              } else {
                                echo $rating;
                              } ?></data>
                      </div>
                    </div>

 <button type="button" class="btn btn-primary" onclick="navigateToBook('<?php echo urlencode($row['movie_title']); ?>')">Book</button>


                  </div>
                </li>
            <?php }
            } ?>

          </ul>

        </div>
      </section>
    </article>
<!-- 
    - #NOW SHOWING
  -->

<section class="top-rated">
    <div class="container">
        <p class="section-subtitle">Offline</p>
        <h2 class="h2 section-title">Watch Now</h2>
        <ul class="movies-list">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Movies&Series";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = 'SELECT * FROM movies WHERE movie_status="online"';
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // Check if the user is logged in
                if(isset($_SESSION['usertoken'])) {
                    // User is logged in, fetch user status from the database
                    $user_id = $_SESSION["usertoken"];
                    $status_sql = "SELECT status FROM userinfo WHERE id = '$user_id'";
                    $status_result = mysqli_query($conn, $status_sql);
                    $user_status = "inactive"; // Default status
                    if (mysqli_num_rows($status_result) > 0) {
                        $row = mysqli_fetch_assoc($status_result);
                        $user_status = $row["status"];
                    }
                } else {
                    // User is not logged in, set default status
                    $user_status = "inactive";
                }
                
                // Loop through each movie and determine button disabled status
                while ($row = $result->fetch_assoc()) {
                    // Initialize $user_id here
                    $user_id = isset($_SESSION['usertoken']) ? $_SESSION["usertoken"] : null;
                
                    // Fetch the state of the toggle switch for this user and movie
                    $movie_id = $row["movie_id"];
                    $state_sql = "SELECT state FROM allowed WHERE user_id = '$user_id' AND movie_id = '$movie_id'";
                    $state_result = mysqli_query($conn, $state_sql);
                    // If state not found, assume it's OFF
                    $state = 0;
                    if (mysqli_num_rows($state_result) > 0) {
                        $state_row = mysqli_fetch_assoc($state_result);
                        $state = $state_row["state"];
                    }
                
                    // Check if the user status is "inactive" and the toggle switch is OFF
                    if ($user_status === "inactive" && $state === 0) {


                        $buttonDisabled = "disabled"; // Disable the button
 


                    } else {

                        $buttonDisabled = ""; // Enable the button


                    }




                    ?>
                    
                    <li>
                        <div class="movie-card">
                            <a href="movie-detail.php?movie_id=<?php echo $row['movie_id'] ?>">
                                <figure class="card-banner">
                                    <img src="image/<?php echo $row['movie_image']; ?>">
                                </figure>
                            </a>
                            <div class="title-wrapper">
    <a href="movie-detail.php?movie_id=<?php echo $row['movie_id'] ?>">
        <h3 class="card-title"><?php echo $row['movie_title'] ?></h3>
    </a>
    <time datetime="2022"><?php $release_date = $row['release_date'];
                            echo date('Y', strtotime($release_date)) ?>
        <?php
        // Fetch and display the category name
        $category_id = $row['categorie_id'];
        $category_query = "SELECT categorie_name FROM categories WHERE categorie_id = $category_id";
        $category_result = $conn->query($category_query);
        if ($category_result && $category_row = $category_result->fetch_assoc()) {
            echo " - " . $category_row['categorie_name'];
        }
        ?>
    </time>
</div>

                            <div class="card-meta">

                                <!-- Toggle switch for each movie -->
<label class="switch">
    <input type="checkbox" id="movie_<?php echo $movie_id; ?>" <?php if ($state == 1) echo "checked"; ?> <?php echo $switchDisabled; ?>>
    <span class="slider round"></span>
</label>




                                <div class="duration">
                                    <ion-icon name="time-outline"></ion-icon>
                                    <time datetime="PT122M"><?php $du = $row['durations'];
                                                            echo $du ?></time>
                                </div>
                                <div class="rating">
                                    <ion-icon name="star"></ion-icon>
                                    <data><?php $rating = $row['rating'];
                                            echo $rating ?></data>
                                </div>
                            </div>

                        
<!--<button class="movie-button" data-movie-id="<?php echo $movie_id; ?>" <?php echo $buttonDisabled; ?>>Watch</button>-->


<?php
// Check if the user is logged in
if(isset($_SESSION['usertoken'])) {
    echo '<button class="movie-button" data-movie-id="' . $movie_id . '" ' . $buttonDisabled . '>Watch</button>';
} else {
    echo '<button class="movie-button" onclick="alert(\'Please login first.\')">Watch</button>';
}
?>




                        </div>
                    </li>
            <?php }
            } ?>
        </ul>
    </div>
</section>


  <style>
  .upcoming {
    background-color: black; /* Set the background color to black */
    color: white; /* Set the text color to white for better visibility */
    padding: 50px 0; /* Add some padding to the section */
    
  }

  .top-rated {
    background-color: black; /* Set the background color to black */
    color: white; /* Set the text color to white for better visibility */
    padding: 50px 0; /* Add some padding to the section */
    
  }
</style>



<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM content loaded');
    document.querySelectorAll('.switch input[type="checkbox"]').forEach(switchInput => {
        switchInput.addEventListener('change', function() {
            const movieId = this.id.split('_')[1];
            const switchState = this.checked;
            const passwordRequired = true; // Always prompt for password
            openPasswordModal(movieId, this, passwordRequired, switchState);
        });
    });

    // Add event listeners to buttons
document.querySelectorAll('.movie-button').forEach(button => {
    button.addEventListener('click', function() {
        const movieId = this.getAttribute('data-movie-id');
        const switchInput = document.getElementById(`movie_${movieId}`);
        
        // Check if the user is inactive
        if (<?php echo json_encode($user_status); ?> === "inactive") {
            
		

            return; // Exit the function and prevent navigation
        }
        
        // Check if the switch is OFF
        if (!switchInput.checked) {
            // If switch is OFF, navigate to watch.php
            window.location.href = `watch.php?movie_id=${movieId}`;
        } else {
            // If switch is ON, do nothing (button is disabled)
           
        }
    });
});


    // Modal functionality
    const modal = document.getElementById('passwordModal');
    const passwordInput = document.getElementById('passwordInput');
    const passwordSubmit = document.getElementById('passwordSubmit');
    const closeBtn = document.getElementsByClassName('close')[0];

    // Open the modal
    function openPasswordModal(movieId, checkbox, passwordRequired, switchState) {


        modal.style.display = 'block';

        passwordSubmit.onclick = function() {
            const enteredPassword = passwordInput.value;
            if (enteredPassword === '') {
                // Empty input, do nothing
                return;
            }
            toggleSwitchAndUpdateDatabase(movieId, checkbox, enteredPassword, switchState);
            passwordInput.value = ''; // Clear the text field
            modal.style.display = 'none';
        }

        closeBtn.onclick = function() {
            modal.style.display = 'none';
            // Cancelled password prompt, revert switch state
            checkbox.checked = !switchState;
            passwordInput.value = ''; // Clear the text field
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
                // Cancelled password prompt, revert switch state
                checkbox.checked = !switchState;
                passwordInput.value = ''; // Clear the text field
            }
        }
    }
});

function toggleSwitchAndUpdateDatabase(movieId, checkbox, password, switchState) {
    fetch('verify_password.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `password=${password}`
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === 'correct') {
            updateMovieState(movieId, switchState ? 1 : 0);
            const alertMessage = switchState ? 'Parental control is ON' : 'Parental control is OFF';
            alert(alertMessage);
            if (!switchState) {
                // If parental control is turned off, refresh the page
                //window.location.reload();
            }
        } else if (data.trim() === 'incorrect') {
            alert('Incorrect password. Please try again.');
            // Reset the switch state if the password is incorrect
            checkbox.checked = !switchState;
        } else {
            alert('An error occurred while verifying the password.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while verifying the password.');
    });
}


function updateMovieState(movieId, state) {
    fetch('update_switch_state.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `movie_id=${movieId}&state=${state}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        console.log('State updated successfully:', data);
    })
    .catch(error => {
        console.error('Error updating state:', error);
        alert('An error occurred while updating the state.');
    });
}

</script>












  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="script.js"></script>



<script>
function navigateToBook(movieTitle) {
    window.location.href = "booking_page.php?movie=" + movieTitle;
}
</script>








<script>
  document.addEventListener('DOMContentLoaded', function() {
    const controlButton = document.getElementById('controlButton');
    const switchInputs = document.querySelectorAll('.switch input[type="checkbox"]');
    const watchButtons = document.querySelectorAll('.movie-button');
    const modal = document.getElementById('passwordModal');
    const passwordInput = document.getElementById('passwordInput');
    const passwordSubmit = document.getElementById('passwordSubmit');
    const closeBtn = document.getElementsByClassName('close')[0];

// Check if the user is logged in
<?php if(!isset($_SESSION['usertoken'])) { ?>
    controlButton.style.backgroundColor = 'var(--citrine)';
<?php } ?>



    // Fetch initial state from the database
    fetchInitialState();

    // Function to fetch initial state from the database
    function fetchInitialState() {
        fetch('save_state_to_database.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const initialState = data.last_state;
                if (initialState === 'disabled') {
                    unlockControls();
                } else {
                    lockControls();
                }
            } else {
                console.error('Failed to fetch initial state from the database.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            //alert('An error occurred while fetching initial state from the database.');
        });
    }

    // Function to lock toggle switches only
function lockControls() {
    switchInputs.forEach(input => {
        input.checked = true; // Turn on the toggle switches
    });
    controlButton.classList.remove('red');
    controlButton.classList.add('green');
    controlButton.textContent = 'Main Parental Control is ON';
}

// Function to unlock toggle switches and watch buttons
function unlockControls() {






    switchInputs.forEach(input => {
        // Check if the user is inactive
        if (<?php echo json_encode($user_status); ?> === "inactive") {
            input.disabled = true; // Disable the switch inputs
        } else {
            input.disabled = false;
        }
    });
    watchButtons.forEach(button => {
        button.addEventListener('click', function() {

// Check if the user is logged in
            <?php if(!isset($_SESSION['usertoken'])) { ?>
                // User is not logged in, show an alert
                alert('Login First');
                return;
            <?php } ?>






            // Check if the user is inactive
            if (<?php echo json_encode($user_status); ?> === "inactive") {
                // User is inactive, show an alert
                alert('Subscribe to Watch.');
            } else {
                // User is active, proceed with watching the movie
                // You can add your logic here to watch the movie
                const movieId = this.getAttribute('data-movie-id');
                const switchInput = document.getElementById(`movie_${movieId}`);
                if (!switchInput.checked) {
                    // If switch is OFF, navigate to watch.php
                    window.location.href = `watch.php?movie_id=${movieId}`;
                } else {
                    // If switch is ON, do nothing (button is disabled)
                }
            }
        });
    });
    controlButton.classList.remove('green');
    controlButton.classList.add('red');
    controlButton.textContent = 'Main Parental Control is OFF';
}



    // Toggle button functionality
    controlButton.addEventListener('click', function() {



        openPasswordModal();
    });

    // Open the password modal
function openPasswordModal() {
    // Check if the user is inactive
    if (<?php echo json_encode($user_status); ?> === "inactive") {
        // Check if the user is logged in
        <?php if(isset($_SESSION['usertoken'])) { ?>
            // User is inactive but logged in
            alert('Subscribe First');
        <?php } else { ?>
            // User is inactive and not logged in
            alert('Login First');
        <?php } ?>




        return;
    }

    // Display the modal
    modal.style.display = 'block';

    // Rest of the function remains the same
    passwordSubmit.onclick = function() {
        const enteredPassword = passwordInput.value;
        if (enteredPassword === '') {
            // Empty input, do nothing
            return;
        }
        verifyPassword(enteredPassword);
        passwordInput.value = ''; // Clear the text field
        modal.style.display = 'none';
    }

    closeBtn.onclick = function() {
        modal.style.display = 'none';
        passwordInput.value = ''; // Clear the text field
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
            passwordInput.value = ''; // Clear the text field
        }
    }
}


    // Function to verify password
function verifyPassword(password) {
    fetch('verify1_password.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `password=${password}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'correct') {
            alert('Password verified successfully!');

	window.location.reload();

		

            if (controlButton.classList.contains('red')) {
                // If button is currently disabled, enable it
                saveStateToDatabase('enabled');
            } else {
                // If button is currently enabled, disable it
                saveStateToDatabase('disabled');
            }
        } else if (data.status === 'incorrect') {
            alert('Incorrect password. Please try again.');
        } else {
            alert('An error occurred while verifying the password.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while verifying the password.');
    });
}


    // Function to save state to the database
    function saveStateToDatabase(state) {
        fetch('save_state_to_database.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `m_state=${state}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log('State saved successfully to the database!');
                if (state === 'enabled') {
                    lockControls(); // lock controls if state is enabled
                } else {
                    unlockControls(); // unLock controls if state is disabled
                }
            } else {
                console.error('Failed to save state to the database.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            //alert('An error occurred while saving state to the database.');
        });
    }
});


</script>



	
  <?php include('ChatBot.html') ?>
 
   

    <?php include('get_feedback.php'); ?>

<?php include('footer.php'); ?>
    
</body>
</html>





<!-- responsive tabs -->
<script src="assets/js/jquery-1.9.1.min.js"></script>
<script src="assets/js/easyResponsiveTabs.js"></script>

<!--/theme-change-->
<script src="assets/js/theme-change.js"></script>
<script src="assets/js/owl.carousel.js"></script>
<!-- script for banner slider-->
<script>
	$(document).ready(function () {
		$('.owl-one').owlCarousel({
			stagePadding: 280,
			loop: true,
			margin: 20,
			nav: true,
			responsiveClass: true,
			autoplay: true,
			autoplayTimeout: 5000,
			autoplaySpeed: 1000,
			autoplayHoverPause: false,
			responsive: {
				0: {
					items: 1,
					stagePadding: 40,
					nav: false
				},
				480: {
					items: 1,
					stagePadding: 60,
					nav: true
				},
				667: {
					items: 1,
					stagePadding: 80,
					nav: true
				},
				1000: {
					items: 1,
					nav: true
				}
			}
		})
	})
</script>
<script>
	$(document).ready(function () {
		$('.owl-three').owlCarousel({
			loop: true,
			margin: 20,
			nav: false,
			responsiveClass: true,
			autoplay: true,
			autoplayTimeout: 5000,
			autoplaySpeed: 1000,
			autoplayHoverPause: false,
			responsive: {
				0: {
					items: 2,
					nav: false
				},
				480: {
					items: 2,
					nav: true
				},
				667: {
					items: 3,
					nav: true
				},
				1000: {
					items: 5,
					nav: true
				}
			}
		})
	})
</script>
<script>
	$(document).ready(function () {
		$('.owl-mid').owlCarousel({
			loop: true,
			margin: 0,
			nav: false,
			responsiveClass: true,
			autoplay: true,
			autoplayTimeout: 5000,
			autoplaySpeed: 1000,
			autoplayHoverPause: false,
			responsive: {
				0: {
					items: 1,
					nav: false
				},
				480: {
					items: 1,
					nav: false
				},
				667: {
					items: 1,
					nav: true
				},
				1000: {
					items: 1,
					nav: true
				}
			}
		})
	})
</script>