<?php
require_once("../config/function.php");

if (is_sign_in() === false) {
    set_message(MESSAGE_SIGNIN_REQUIRED);
    header("Location: signin.php");
    exit();
}

$csrf_token = (string)filter_input(INPUT_GET, "csrf_token");
if (validate_csrf_token($csrf_token)  === false) {
    error_log("Invalid csrf token.");
    header("Location: error.php");
    exit();
}

// $id = $id = filter_input(INPUT_GET, "id");  セッションからIDを取得するように変更する
$id = get_account_id();

$pdo = new_PDO();

$blog_dao = new BlogDAO($pdo);
$blog = $blog_dao->selectById($id);

require("../views/update_view.php");