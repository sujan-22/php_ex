<?php

// login.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$u = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_EMAIL);

if ($u === false || $u === NULL) {
    echo "invalid user input";
    exit(-1);
}
$p = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);

if ($p === false || $p === NULL) {
    echo "invalid user input";
    exit(-1);
}


try {
    $dbh = new PDO("mysql:host=localhost;dbname=userdb","root","");
} catch (Exception $e) {
    echo "Error: Could not connect. {$e->getMessage()}";
    exit(-1);
}

$hash = password_hash($p, PASSWORD_DEFAULT);

echo "Computed hash : $hash <br>";

$cmd = "SELECT * FROM credentials WHERE username = ?";
$stmt = $dbh->prepare($cmd);
$success = $stmt->execute([$u]);
if ($success) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($p, $result['password'])) {
        $_SESSION['user'] = $u;
        header("Location: user_profile.php");
        exit();
    } else {
        echo "login not successful";
    }
}
?>