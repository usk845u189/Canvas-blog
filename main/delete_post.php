<?php
require_once("../config/function.php");
require_once("../libs/BlogDAO.php");

$id = filter_input(INPUT_GET, "id");
if ($id === "") {
    header("Location: error.php");
    exit();
}
if (check_author($id) !== false) {
    header("Location: error.php");
    exit();
}

$csrf_token = (string)filter_input(INPUT_GET, "csrf_token");
if (validate_csrf_token($csrf_token)  === false) {
    error_log("Invalid csrf token.");
    header("Location: error.php");
    exit();
}

try {
    $pdo = new_PDO();
    
    $blog_dao = new BlogDAO($pdo);
    $blog_dao->deleteByID($id);

    header("Location: index.php");
} catch (PDOException $e) {
    error_log("Invalid id.");
    header("Location: error.php");
    exit();
}