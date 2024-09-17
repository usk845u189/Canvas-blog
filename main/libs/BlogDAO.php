<?php

class BlogDAO
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function searchall()
    {
        $sql = "select count(*) from blog ";
        $total_posts = $this->pdo->query($sql)->fetchColumn();
        return $total_posts;
    }

    public function selectById($id)
    {
        $sql = "select * from blog where id = :id";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":id", $id, PDO::PARAM_INT);
        $ps->execute();
        $blog = $ps->fetch();
        if ($blog === false) {
            header("Location: error.php");
            exit();
        }

        set_message(MESSAGE_BLOG_POSTED);

        return $blog;

    }

    public function insert($user_id, $title, $text)
    {
        $sql = "insert into blog (user_id, title, blog_text) values (:user_id, :title, :blog_text)";
        $ps = ($this->pdo)->prepare($sql);
        $ps->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $ps->bindValue(":title", $title, PDO::PARAM_STR);
        $ps->bindValue(":blog_text", $text, PDO::PARAM_STR);
        $ps->execute();
    
        set_message(MESSAGE_BLOG_POSTED);
    }

    public function deleteByID($id)
    {
        $sql = "delete from blog where id = :id";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":id", $id, PDO::PARAM_INT);
        $ps->execute();

        set_message(MESSAGE_BLOG_DELETE);
    }

    public function update($update_date, $title, $blog_text, $id)
    {
        $sql = "update blog 
        set created_date = :update_date, 
            title = :title, 
            blog_text = :blog_text 
        where id = :id";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":update_date", $update_date, PDO::PARAM_STR);
        $ps->bindValue(":title", $title, PDO::PARAM_STR);
        $ps->bindValue(":blog_text", $blog_text, PDO::PARAM_STR);
        $ps->bindValue(":id", $id, PDO::PARAM_INT);
        $ps->execute();

        set_message(MESSAGE_BLOG_UPDATE);
    }
}