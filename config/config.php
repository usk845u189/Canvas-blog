<?php

$dsn = "mysql:dbname=postal_db;host=127.0.0.1:3306";
$user = "root";
$password = "";
$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    $query = $pdo->query("SHOW TABLES");
    $tables = $query->fetchAll(PDO::FETCH_ASSOC);

}catch(PDOException $e) {
    print("Error:". $e->getMessage() ."");
    exit();
}