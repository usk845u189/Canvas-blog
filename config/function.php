<?php
define("SESSION_ACCOUNT", "SESSION_ACCOUNT");
define("SESSION_MESSAGE", "SESSION_MESSAGE");
define("SESSION_CSRF_TOKEN", "SESSION_CSRF_TOKEN");

define("MESSAGE_SIGNIN_SUCCESS", "Sign in is successful.");
define("MESSAGE_SIGNIN_ERROR", "Sign in is error.");
define("MESSAGE_SIGNUP_SUCCESS", "Sign up is successful.");
define("MESSAGE_SIGNUP_ERROR", "Sign up is error.");
define("MESSAGE_SIGNUP_ERROR_NOT_AVAILABLE_NAME", "Sign up is error. This name is not available.");
define("MESSAGE_SIGNIN_REQUIRED", "Sign in is required.");
define("MESSAGE_BLOG_POSTED", "Blog post has posted");
define("MESSAGE_BLOG_POST_ERROR", "Blog post is failed");
define("MESSAGE_BLOG_UPDATE", "Blog post has updated");
define("MESSAGE_BLOG_DELETE", "Blog post has deleted");

session_start();

function new_PDO()
{
    $dsn = "mysql:dbname=postal_db;host=127.0.0.1:3306";
    $user = "root";
    $password = "";
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    $pdo = new PDO($dsn, $user, $password, $options);

    return $pdo;

}

function h($sql){
    return htmlspecialchars($sql, ENT_QUOTES);
}

function is_sign_in()
{
    return isset($_SESSION[SESSION_ACCOUNT]);
}

function get_account()
{
    if (is_sign_in() === false) {
        return false;
    }
    return $_SESSION[SESSION_ACCOUNT];
}

function get_account_id()
{
    $account = get_account();
    if ($account === false) {
        return false;
    }
    return $account["id"];
}
function set_message($message)
{
    $_SESSION[SESSION_MESSAGE] = $message;
}

function get_message()
{
    if (isset($_SESSION[SESSION_MESSAGE]) === false) {
        return false;
    }
    $message = $_SESSION[SESSION_MESSAGE];
    unset($_SESSION[SESSION_MESSAGE]);
    return $message;
}

function get_username($user_id)
{
    $pdo = new_PDO();
    $sql = "select username from user where id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(":id", $user_id, PDO::PARAM_INT);
    $ps->execute();
    $username = $ps->fetch();
    if ($username === false) {
        return false;
    }

    return $username['username'];
}

function check_author($blog_id){
    $pdo = new_PDO();
    $sql = "select user_id from blog where id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(":id", $blog_id, PDO::PARAM_INT);
    $ps->execute();
    $username_in_blog = $ps->fetch();

    $username_current = get_account_id();

    if ($username_in_blog !== $username_current) {
        return false;
    }

    return true;
}

function generate_csrf_token()
{
    $bytes = random_bytes(32);
    $token = bin2hex($bytes);
    $_SESSION[SESSION_CSRF_TOKEN] = $token;
    return $token;
}

function validate_csrf_token($token)
{
    if (isset($_SESSION[SESSION_CSRF_TOKEN]) === false) {
        return false;
    }
    $result = $_SESSION[SESSION_CSRF_TOKEN] === $token;
    unset($_SESSION[SESSION_CSRF_TOKEN]);
    return $result;
}
