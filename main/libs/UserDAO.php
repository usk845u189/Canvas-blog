<?php

class UserDAO
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectByUername($username)
    {
        $sql = "select id, username, hash_password from user where username = :username";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":username", $username, PDO::PARAM_STR);
        $ps->execute();
        $account = $ps->fetch();

        return $account;
    }

    public function insert($username, $hash_password)
    {
        $sql = "insert into user (username, hash_password) values (:username, :hash_password)";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":username", $username, PDO::PARAM_STR);
        $ps->bindValue(":hash_password", $hash_password, PDO::PARAM_STR);
        $ps->execute();
    
        set_message(MESSAGE_SIGNUP_SUCCESS);
    }
}