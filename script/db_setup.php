<?php
set_time_limit(0);

require_once("../config/config.php");

$username = "Adimn_user";
$password = password_hash("123", PASSWORD_DEFAULT);

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS user(
        id INT AUTO_INCREMENT PRIMARY KEY, 
        username TEXT UNIQUE NOT NULL, 
        hash_password TEXT NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS blog(
        id INT AUTO_INCREMENT PRIMARY KEY, 
        user_id INT NOT NULL, 
        created_date DATETIME DEFAULT CURRENT_TIMESTAMP, 
        title VARCHAR(80) NOT NULL, 
        blog_text TEXT NOT NULL
    )");

    $pdo->beginTransaction();
    $pdo->prepare("inser into user (username, password_hash) values (:username, :hash_password)");
    $ps->bindValue(":username", $username, PDO::PARAM_STR);
    $ps->bindValue(":hash_password", $password, PDO::PARAM_STR);
    $ps->execute();

    $pdo->commit();
    echo "テーブルの作成が完了しました。" . PHP_EOL;
} catch(PDOException $e){
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "テーブルの作成に失敗しました。". $e->getMessage() . PHP_EOL;
}