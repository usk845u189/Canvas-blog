<?php
require_once("../config/function.php");

$id = filter_input(INPUT_POST, "id");
if ($id === "") {
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
    $sql = "update blog 
            set created_date = :update_date, 
                title = :title, 
                blog_text = :blog_text 
            where id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(":update_date", $update_date, PDO::PARAM_STR);
    $ps->bindValue(":title", $title, PDO::PARAM_STR);
    $ps->bindValue(":blog_text", $blog_text, PDO::PARAM_STR);
    $ps->bindValue(":id", $id, PDO::PARAM_INT);
    $ps->execute();

    header("Location: index.php");
} catch (PDOException $e) {
    error_log("Invalid id.");
    echo "SQL error: " . $e->getMessage();
    header("Location: error.php");
    exit();
}