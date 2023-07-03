<?php

if (strlen($_POST["password"]) < 8){
    die("password minimal harus 8");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}
if ( ! preg_match("/[0-9]/i", $_POST["password"])) {
    die("Password must contain number");
}
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);    

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (NAME, EMAIL, PASSWORD_HASH)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)){
    die("SQL error:" . $mysqli->error);
}

$name = $_POST["name"];
$email = $_POST["email"];

$stmt->bind_param("sss",
                    $_POST["name"],
                    $_POST["email"],
                    $password_hash);

$stmt->execute();                    

echo "signup succes";