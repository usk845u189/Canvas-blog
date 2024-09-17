<?php
require_once("../config/function.php");
require_once("../libs/BlogDAO.php");

if (is_sign_in() === false) {
    set_message(MESSAGE_SIGNIN_REQUIRED);
    header("Location: signin.php");
    exit();
}

$perpage = 10;

$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, [
    'options' => [
        'default' => 1, 
        'min_range' => 1,
    ]
]);

try {
    $pdo = new_PDO();

    $blog_dao = new BlogDAO($pdo);
    $total_posts = $blog_dao->$blog_dao->searchall();
    
    $total_pages = ceil($total_posts / $perpage);

    // どこから表示するかの計算
    $offset = ($page - 1) * $perpage;

    // 投稿を取得
    $sql = "select * from blog order by created_date desc limit :perpage offset :offset";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':perpage', $perpage, PDO::PARAM_INT);
    $ps->bindValue(':offset', $offset, PDO::PARAM_INT);
    $ps->execute();
    $blogs = $ps->fetchAll();

    require("../views/index_view.php");

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
    exit();
}
