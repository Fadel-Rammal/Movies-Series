<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

	button[type="button"] {
            width: 10%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button[type="button"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Add Movie</h2>



    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="roomnb">Room Number:</label><br>
            <input type="number" id="roomnb" name="roomnb" class="form-control" required><br>
        </div>


        <div class="form-group">
    <label for="cinemaloc">Cinema Location:</label><br>
    <select id="cinemalocDropdown" name="cinemalocDropdown" class="form-control" onchange="updateTextField()">
        <option value="">Select Location</option> <!-- Default option -->


        <?php
        // Step 1: Establish a connection to the database
        $servername = "localhost";
        $username = "root"; // Replace with your database username
        $password = ""; // Replace with your database password
        $dbname = "Movies&Series";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Step 2: Retrieve the cinema locations from the database
        $sql = "SELECT DISTINCT cinemaloc FROM changemovie";
        $result = $conn->query($sql);

        // Step 3: Display cinema locations as options in the dropdown
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["cinemaloc"] . "'>" . $row["cinemaloc"] . "</option>";
            }
        } else {
            echo "<option value='' disabled>No cinema locations found</option>";
        }

        // Close the connection
        $conn->close();
        ?>
     </select><br>
    <label for="cinemaloc">Or Enter Manually:</label><br>
    <input type="text" id="cinemaloc" name="cinemaloc" class="form-control"><br>
</div>



<div class="form-group">
    <label for="cinemanam">Cinema Name:</label><br>
    <select id="cinemanamDropdown" name="cinemanamDropdown" class="form-control" onchange="updateNameField()">
        <option value="">Select Name</option> <!-- Default option -->


        <?php
        // Step 1: Establish a connection to the database
        $servername = "localhost";
        $username = "root"; // Replace with your database username
        $password = ""; // Replace with your database password
        $dbname = "Movies&Series";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Step 2: Retrieve the cinema locations from the database
        $sql = "SELECT DISTINCT cinemanam FROM changemovie";
        $result = $conn->query($sql);

        // Step 3: Display cinema locations as options in the dropdown
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["cinemanam"] . "'>" . $row["cinemanam"] . "</option>";
            }
        } else {
            echo "<option value='' disabled>No cinema Names found</option>";
        }

        // Close the connection
        $conn->close();
        ?>
     </select><br>
    <label for="cinemanam">Or Enter Manually:</label><br>
    <input type="text" id="cinemanam" name="cinemanam" class="form-control"><br>
</div>




        <div class="form-group">
            <label for="maplink">Maps URL:</label><br>
            <input type="text" id="maplink" name="maplink" class="form-control" required><br>
        </div>


        <div class="form-group">
    <label for="movie_name">Film Name:</label><br>
    <select id="movie_name" name="movie_name" class="form-control" required>
        <option value="">Select Film</option> <!-- Default option -->

        <?php
        // Database connection
        $servername = "localhost";
        $username = "root"; // Replace with your database username
        $password = ""; // Replace with your database password
        $dbname = "Movies&Series";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch movie names from the "movies" table where movie_status matches a specific value
        $status = "oncinema"; // Specify the movie status you want to filter by
        $sql = "SELECT movie_title FROM movies WHERE movie_status = '$status'";
        $result = $conn->query($sql);

        // Display movie names as options in the dropdown
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["movie_title"] . "'>" . $row["movie_title"] . "</option>";
            }
        } else {
            echo "<option value='' disabled>No movies found</option>";
        }

        // Close the connection
        $conn->close();
        ?>
    </select><br>
</div>




       
        <div class="form-group">
            <label for="start_time">Start Time:</label><br>
            <input type="datetime-local" id="start_time" name="start_time" class="form-control" required><br>
        </div>
        <div class="form-group">
            <label for="end_time">End Time:</label><br>
            <input type="datetime-local" id="end_time" name="end_time" class="form-control" required><br>
        </div>
        <div class="form-group">
            <label for="shownb">Show Number:</label><br>
            <input type="number" id="shownb" name="shownb" class="form-control" required><br>
        </div>
        <button type="submit" name="submit">Submit</button>
		
    </form>
<a href="movie.php"><button type="button">Back to Movies</button></a>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Movies&Series";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve form data
        $roomnb = $_POST['roomnb'];
        $cinemaloc = $_POST['cinemaloc'];
        $cinemanam = $_POST['cinemanam'];
        $maplink = $_POST['maplink'];
        $movie_name = $_POST['movie_name'];
        
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $shownb = $_POST['shownb'];

        // SQL to insert data into the table
        $sql = "INSERT INTO changemovie (roomnb, cinemaloc, cinemanam, maplink, movie_name, start_time, end_time, shownb) 
                VALUES ('$roomnb', '$cinemaloc', '$cinemanam', '$maplink', '$movie_name', '$start_time', '$end_time', '$shownb')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
    }
    ?>

    <?php
    // Step 1: Establish a connection to the database
    $servername = "localhost";
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "Movies&Series";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 2: Retrieve the data from the changemovie table
    $sql = "SELECT * FROM changemovie";
    $result = $conn->query($sql);

    ?>
    <h2>View Movies</h2>
    <?php
    // Step 3: Display the data in a tabular format
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Room Number</th><th>Cinema Location</th><th>Cinema Name</th><th>Movie Name</th><th>Change ID</th><th>Start Time</th><th>End Time</th><th>Show Number</th></tr>";
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["roomnb"] . "</td>";
            echo "<td>" . $row["cinemaloc"] . "</td>";
            echo "<td>" . $row["cinemanam"] . "</td>";
           
            echo "<td>" . $row["movie_name"] . "</td>";
            echo "<td>" . $row["changeID"] . "</td>";
            echo "<td>" . $row["start_time"] . "</td>";
            echo "<td>" . $row["end_time"] . "</td>";
            echo "<td>" . $row["shownb"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    ?>
    <?php
    // Close the connection
    $conn->close();
    ?>




<script>
    function updateTextField() {
        var dropdown = document.getElementById("cinemalocDropdown");
        var selectedOption = dropdown.options[dropdown.selectedIndex].value;
        if (selectedOption !== "") {
            document.getElementById("cinemaloc").value = selectedOption;
        } else {
            document.getElementById("cinemaloc").value = ""; // Reset the text field if "Select Location" is chosen
        }
    }

    function updateNameField() {
        var dropdown = document.getElementById("cinemanamDropdown");
        var selectedOption = dropdown.options[dropdown.selectedIndex].value;
        if (selectedOption !== "") {
            document.getElementById("cinemanam").value = selectedOption;
        } else {
            document.getElementById("cinemanam").value = ""; // Reset the text field if "Select Location" is chosen
        }
    }


</script>



</body>
</html>