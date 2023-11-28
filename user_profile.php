<?php

// user_profile.php

session_start();

$background_color = '#ffffff';
$font_size = '16px';

if (isset($_POST['logout']) || !isset($_SESSION['user'])) {

    session_unset();
    session_destroy();
    header("Location: api.php");
    exit();
}

if (isset($_POST['savePreferences'])) {

    $background_color = $_POST['background_color'];
    setcookie('background_color', $background_color, time() + (86400 * 30), '/'); // Cookie expires in 30 days


} else {
    $background_color = isset($_COOKIE['background_color']) ? $_COOKIE['background_color'] : '#ffffff';
}

if (isset($_SESSION['user'])) {


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profilePicture'])) {
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES['profilePicture']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES['profilePicture']['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['profilePicture']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        
        $newFileName = $targetDirectory . 'profile_pic.' . $imageFileType;
        // Upload the file
        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $newFileName)) {
            echo "The file " . basename($_FILES['profilePicture']['name']) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}


?>
    <html>
        <head>
            <style>
                body {
                    background-color: <?php echo $background_color; ?>;
                }
            </style>
        </head>

         <h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>

        <?php
        $profilePicPath = "uploads/profile_pic.*";

        $profilePic = glob($profilePicPath);

        if (!empty($profilePic)) {
            echo "<img src='" . $profilePic[0] . "' alt='Profile Picture'>";
        } else {
            echo "<p>No profile picture available.</p>";
        }

        ?>
        <br>
        <br>
        <br>
        <h2> User Preferences </h2>

       <form action="user_profile.php" method="post" enctype="multipart/form-data">
            <label for="profilePicture">Upload Profile Picture:</label>
            <input type="file" name="profilePicture" id="profilePicture">
            <input type="submit" value="Upload" name="submit">
        </form>
        
        <form action="user_profile.php" method="post">
            <label for="background_color">Background Color:</label>
            <input type="color" name="background_color" value="<?php echo $background_color; ?>">
            <input type="submit" name="savePreferences" value="Change Background">
        </form>
        
        <form action="user_profile.php" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
    </html>

<?php
}
?>