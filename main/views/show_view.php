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
                    <h1 class="fst-italic"><?php echo h($blog["title"]) ?></h1>
                    <hr>
                    <p><?php echo h(date('Y-m-d', strtotime($blog['created_date']))) ?></p>
                    <p><?php echo h(get_username($blog["user_id"])) ?></p>
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
                        <p class="mb-3"><?php echo h($blog["blog_text"]) ?></p>
                    </div>
                </section>
                <!--メニュー-->
                <section id="menu">
                    <div class="container my-3 py-4 bg-light">
                        <div class="row">
                            <?php if (get_account_id() === $blog["user_id"]) { ?>
                                <div class="col-md-3 mb-3">
                                    <a href="update.php?csrf_token=<?php echo $csrf_token; ?>&id=<?php echo $id; ?>" class="btn btn-success w-100">更新</a>
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
                    <form action="delete_post.php" method='GET'>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <input type="submit" class="btn btn-danger" value="削除">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>