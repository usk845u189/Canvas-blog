<?php
require_once("../config/function.php");

if (is_sign_in() === false) {
    set_message(MESSAGE_SIGNIN_REQUIRED);
    header("Location: signin.php");
    exit();
}

try {
    $pdo = new_PDO();

    $sql = "select * from blog ";
    $st = $pdo->query("select * from blog ");
    $blogs = $st->fetchAll();

} catch (PDOException $e) {
    error_log($e->getMessage());
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
        <div class="container my-3 py-3 bg-light"> 
            <div class="row">
                <div class="col-md-6 m-auto ">
                    <h1>ブログ管理</h1>
                </div>
            </div>
            <button class="btn btn-secondery text-right"><a href="signout.php">Sign out</a></button>
        </div>
    </header>
    <section id="menu">
        <div class="container my-3 py-3 bg-light">
            <div class="row">
                <div class="col-md-3">
                    <a href="create.php" class="btn btn-success w-100">ブログ作成</a>
                </div>
            </div>
        </div>
    </section>
    <section id="list">
        <div class="container my-3">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h4>最新の投稿</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped text-nowrap">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>タイトル</th>
                                        <th>作成日</th>
                                        <th>著者</th>
                                        <th>詳細</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 繰り返し処理によってブログ内容を表示 -->
                                    <?php foreach ($blogs as $blog) { ?>
                                    <tr>
                                        <td><?= h($blog["id"]) ?></td>
                                        <td><?= h($blog["title"]) ?></td>
                                        <td><?= h($blog["created_date"]) ?></td>
                                        <td><?= h(get_username($blog["id"])) ?></td>
                                        <td><a href="show_post.php?id=<?= h($blog["id"]) ?>" class="btn btn-secondary">
                                                詳細
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>