<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("../main/views/_head_view.php") ?>
</head>
<body>
    <section id="blog_post">
        <div class="container my-3 ">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h4>ブログ投稿</h4>
                        </div>
                        <div class="card-body">
                            <form action="create_post.php" method="post">
                                <input type="hidden" name="user_id" value="<?= h(get_account_id()) ?>">
                                <div class="form-group mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="text">Text</label>
                                    <textarea class="form-control form-control-lg" id="blog_text" name="blog_text"></textarea>
                                </div>
                                <button type="submit" class="btn btn-secondary">投稿</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        CKEDITOR.replace( 'text' );
    </script>
</body>
</html>