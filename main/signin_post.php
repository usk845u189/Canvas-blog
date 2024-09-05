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
    set_message(MESSAGE_SIGNIN_ERROR);
    header("Location: signin.php");
    exit();
}
if (mb_strlen($username) > 30) {
    set_message(MESSAGE_SIGNIN_ERROR);
    error_log("Invalid name.");
    header("Location: signin.php");
    exit();
} 

$password = (string) filter_input(INPUT_POST, "password");
if ($password === "") {
    set_message(MESSAGE_SIGNIN_ERROR);
    error_log("Invalid password.");
    header("Location: signin.php");
    exit();
}
if (mb_strlen($password) > 30) {
    set_message(MESSAGE_SIGNIN_ERROR);
    error_log("Invalid password.");
    header("Location: signin.php");
    exit();
}

try {
    $pdo = new_PDO();

    $sql = "select id, username, hash_password from user where username = :username";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(":username", $username, PDO::PARAM_STR);
    $ps->execute();
    $account = $ps->fetch();

    if ($account === false) {
        set_message(MESSAGE_SIGNIN_ERROR);
        header("Location: signin.php");
        exit();
    }
    if (password_verify($password, $account["hash_password"]) === false) {
        set_message(MESSAGE_SIGNIN_ERROR);
        error_log("Wrong password");
        header("Location: signin.php");
        exit();
    }

    // ログイン処理はここ
    session_regenerate_id();
    $_SESSION[SESSION_ACCOUNT] = $account;

    set_message(MESSAGE_SIGNIN_SUCCESS);

    header("Location: index.php");

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
}