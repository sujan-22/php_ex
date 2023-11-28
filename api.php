<?php
//index.php
session_start();

if(isset($_SESSION['user'])) {
header("Location: user_profile.php");
exit();
}

?>


<html>
    <h1> Log in my friend! </h1>
    <form action="login.php" method="post">
        <input type="text" name="uname"> <br>
        <input type="text" name="pass"> <br>
        <input type="submit" value="Log In">
    </form>
    <h1> Register New User </h1>
    <form action="register.php" method="post">
        <input type="text" name="uname"> <br>
        <input type="text" name="pass"> <br>
        <input type="submit" value="Register User">
    </form>
    <button action="delete.php" method="post">Delete profile</button>
</html>