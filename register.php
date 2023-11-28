<?php


// register.php

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



if (strlen($u) < 8) {
    echo "User Name too short!";
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

$cmd = "INSERT into credentials (username, password) VALUES (?, ?)";
$stmt = $dbh->prepare($cmd);
$success = $stmt->execute([$u,$hash]);

if ($success) {
    echo "User was successfully added!";
} else {
    echo "Adding the new user failed for some reason!";
}
?>