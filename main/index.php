<?php
require_once("../config/function.php");

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

    $sql = "select count(*) from blog ";
    $total_posts = $pdo->query($sql)->fetchColumn();
    
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
                                        <td><?= h(date('Y-m-d', strtotime($blog['created_date']))) ?></td>
                                        <td><?= h(get_username($blog["user_id"])) ?></td>
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

                    <!-- ページネーション -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <!-- Previous -->
                            <?php if($page > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo; Previous</span>
                                </a>
                            </li>
                            <?php } else { ?>
                            <li class="page-item disabled">
                                <a class="page-link" aria-disabled="true">&laquo; Previous</a>
                            </li>
                            <?php } ?>

                            <!-- ページ番号-->
                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                            <?php } ?>

                            <!-- Next -->
                            <?php if($page < $total_pages) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">Next &raquo;</span>
                                </a>
                            </li>
                            <?php } else { ?>
                            <li class="page-item disabled">
                                <a class="page-link" aria-disabled="true">Next &raquo;</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</body>
</html>