<?php
require_once("../config/function.php");

$csrf_token = (string)filter_input(INPUT_POST, "csrf_token");
if (validate_csrf_token($csrf_token)  === false) {
    error_log("Invalid csrf token.");
    header("Location: error.php");
    exit();
}

$username = (string) filter_input(INPUT_POST, "username");
if ($username === "") {
    set_message(MESSAGE_SIGNUP_ERROR);
    header("Location: signup.php");
    exit();
}
if (mb_strlen($username) > 30) {
    set_message(MESSAGE_SIGNUP_ERROR);
    error_log("Invalid name.");
    header("Location: signup.php");
    exit();
} 

$password = (string) filter_input(INPUT_POST, "password");
if ($password === "") {
    set_message(MESSAGE_SIGNUP_ERROR);
    error_log("Invalid password.");
    header("Location: signup.php");
    exit();
}
if (mb_strlen($password) > 30) {
    set_message(MESSAGE_SIGNUP_ERROR);
    error_log("Invalid password.");
    header("Location: signup.php");
    exit();
}

$hash_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo = new_PDO();

    $sql = "insert into user (username, hash_password) values (:username, :hash_password)";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(":username", $username, PDO::PARAM_STR);
    $ps->bindValue(":hash_password", $hash_password, PDO::PARAM_STR);
    $ps->execute();

    set_message(MESSAGE_SIGNUP_SUCCESS);

    header("Location: signin/php");
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        set_message(MESSAGE_SIGNUP_ERROR_NOT_AVAILABLE_NAME);
        header("Location: signup.php");
        exit();
    }
    error_log($e->getMessage());
    header("Location: error.php");
}
