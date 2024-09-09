<?php
require_once("../config/function.php");

$id = filter_input(INPUT_GET, "id");
if ($id === "") {
    header("Location: error.php");
    exit();
}

try {
    $pdo = new_PDO();
    $sql = "delete from blog where id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(":id", $id, PDO::PARAM_INT);
    $ps->execute();

    header("Location: index.php");
} catch (PDOException $e) {
    error_log("Invalid id.");
    header("Location: error.php");
    exit();
}