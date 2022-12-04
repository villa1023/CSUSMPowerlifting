<?php

if (empty($_POST["name"])) {
    die("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO userinfo (name, email, passwrd)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error:" . $mysqli->error);
}

$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $_POST["password"]);

if ($stmt->execute()) {

    header("Location: AnnouncmentsPage.html");
    exit;
} else {
    if ($mysqli->errno === 1062) {
        die("email already taken");
    }
    die($mysqli->error . " " . $mysqli->errno);
}

// $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
// print_r($_POST);
// var_dump($password_hash);