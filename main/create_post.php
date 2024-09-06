<?php
require_once("../config/function.php");

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

$text = (string)filter_input(INPUT_POST, "text");
if ($title === "") {
    set_message(MESSAGE_BLOG_POST_ERROR);
    error_log("Invalid texte.");
    header("Location: index.php");
    exit();
}

try {
    $pdo = new_PDO();

    $sql = "insert into blog (user_id, title, text) values (:user_id, :title, :text)";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $ps->bindValue(":title", $title, PDO::PARAM_STR);
    $ps->bindValue(":text", $text, PDO::PARAM_STR);
    $ps->execute();

    set_message(MESSAGE_BLOG_POSTED);

    header("Location: index.php");
} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
}