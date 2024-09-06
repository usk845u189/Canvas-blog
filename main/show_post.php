<?php
require_once("../config/function.php");

$id = (string)filter_input(INPUT_GET, "id");
if ($id === "") {
    header("Location: error.php");
    exit();
}

$pdo = new_PDO();
$sql = "select user_id, created_date, title, blog_text where id = :id";
$ps = $pdo->prepare($sql);
$ps->bindValue(":id", $id, PDO::PARAM_INT);
$ps->execute();
$blog = $ps->fetch();
if ($blog === false) {
    header("Location: error.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("../main/views/_head_view.php") ?>    
</head>
<body>
    <header id="page-header">
        <div class="container my-3 bg-light">
            <div class="row">
                <div class="col-md-9 m-auto text-center">
                    <h1 class="fst-italic"><?php $blog["title"] ?></h1>
                    <hr>
                    <p><?php h($blog["created_date"]) ?></p><br>
                    <p><?php h(get_username($blog["id"])) ?></p>
                </div>
            </div>
        </div>
    </header>
    <div class="container my-3">
        <div class="row mb-2">
            <!--コンテンツ-->
            <div class="col-md-8">
                <!--ブログ投稿-->
                <section id="blog_post">
                    <div class="container py-2 bg-light">
                        <p class="mb-3"><?php h($blog["text"]) ?></p>
                    </div>
                </section>
                <!--メニュー-->
                <section id="menu">
                    <div class="container my-3 py-4 bg-light">
                        <div class="row">
                            <?php if (get_account() === $blog["user_id"]) { ?>
                                <div class="col-md-3 mb-3">
                                    <a href="update_post.php?id=<?php h($blog["id"]) ?>" class="btn btn-success w-100">更新</a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#del_modal">削除</button>
                                </div>
                                <?php } ?>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-secondary w-100" onclick="history.back()">戻る</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="del_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">削除確認</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    このブログ投稿を削除しますか？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <form action="delete_post.php?id=<?php $blog["id"] ?>" method='GET'>
                        <input type="submit" class="btn btn-danger" value="削除">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>