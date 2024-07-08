<?php
session_start();

// Check if the download button is clicked and user is logged in
if (isset($_POST["download"]) && isset($_SESSION["user"])) {
    // Get the video file path from the form data
    $videoFile = $_POST["video_file"];
    
    // Check if the video file exists
    if (!file_exists($videoFile)) {
        echo '<script>alert("Error: File not found."); window.location.href = "watch.php";</script>';
        exit(); // Exit to prevent further execution
    }

    // Read the video file content
    $videoContent = file_get_contents($videoFile);
    
    // Get the encryption key from the session
    $encryptionKey = $_SESSION["user"]["encryption_key"];
    
    // XOR encrypt the video content using the encryption key
    $encryptedVideo = xorEncrypt($videoContent, $encryptionKey);
    
    // Construct the filename with the user's first name and movie title
    $userName = $_SESSION['firstName'];
    $movieTitle = str_replace(' ', '_', $_POST["movie_title"]); // Replace spaces with underscores
    $fileName = $userName . "_" . $movieTitle . ".mp4";
    
    // Set appropriate headers for download
    header("Content-type: video/mp4");
    header("Content-Disposition: attachment; filename=\"" . $fileName . "\"");
    
    // Output the encrypted video content
    echo $encryptedVideo;
    
    // Exit to prevent further execution
    exit();
}

// XOR encryption function
function xorEncrypt($input, $key) {
    $output = '';
    $keyLength = strlen($key);
    for ($i = 0; $i < strlen($input); $i++) {
        $output .= $input[$i] ^ $key[$i % $keyLength];
    }
    return $output;
}
?>
