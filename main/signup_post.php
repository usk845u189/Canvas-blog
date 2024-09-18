<?php
require_once("../config/function.php");
require_once("../main/libs/UserDAO.php");

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

    $user_dao = new UserDAO($pdo);
    $user_dao->insert($username, $hash_password);

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
