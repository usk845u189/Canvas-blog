<?php
require_once("../config/function.php");
require_once("../libs/BlogDAO.php");


$id = filter_input(INPUT_POST, "id");
if ($id === "") {
    header("Location: error.php");
    exit();
}

if (check_author($id) !== false) {
    header("Location: error.php");
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

$blog_text = (string)filter_input(INPUT_POST, "blog_text");
if ($blog_text === "") {
    set_message(MESSAGE_BLOG_POST_ERROR);
    error_log("Invalid blog text.");
    header("Location: index.php");
    exit();
}

$update_date = date('Y-m-d H:i:s');

try {
    $pdo = new_PDO();
    
    $blog_dao = new BlogDAO($pdo);
    $blog_dao->update($update_date, $title, $blog_text, $id);

    header("Location: index.php");
} catch (PDOException $e) {
    error_log("Invalid id.");
    echo "SQL error: " . $e->getMessage();
    header("Location: error.php");
    exit();
}