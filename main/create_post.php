<?php
require_once("../config/function.php");
require_once("../main/libs/BlogDAO.php");

$user_id = (string)filter_input(INPUT_POST, "user_id");
if ($user_id === "") {
    set_message(MESSAGE_BLOG_POST_ERROR);
    header("Location: index.php");
    exit();
}

$title = (string)filter_input(INPUT_POST, "title");
if ($title === "") {
    set_message(MESSAGE_BLOG_POST_ERROR);
    error_log("Invalid title.");
    header("Location: index.php");
    exit();
}

if (mb_strlen($title) > 50) {
    set_message(MESSAGE_BLOG_POST_ERROR);
    error_log("Invalid title.");
    header("Location: index.php");
    exit();
}

$text = (string)filter_input(INPUT_POST, "blog_text");
if ($title === "") {
    set_message(MESSAGE_BLOG_POST_ERROR);
    error_log("Invalid texte.");
    header("Location: index.php");
    exit();
}

try {
    $pdo = new_PDO();

    $blog_dao = new BlogDAO($pdo);
    $blog_dao->insert($user_id, $title, $text);

    header("Location: index.php");
} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
}