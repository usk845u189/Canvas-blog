<?php
require_once("../config/function.php");
require_once("../libs/BlogDAO.php");

if (is_sign_in() === false) {
    set_message(MESSAGE_SIGNIN_REQUIRED);
    header("Location: signin.php");
    exit();
}

$id = (string)filter_input(INPUT_GET, "id");
if ($id === "") {
    header("Location: error.php");
    exit();
}

$csrf_token = generate_csrf_token();

$pdo = new_PDO();

$blog_dao = new BlogDAO($pdo);
$blog = $blog_dao->selectById($id);

require("../views/show_view.php");