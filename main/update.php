<?php
require_once("../config/function.php");

$id = $id = filter_input(INPUT_GET, "id");
if ($id === "") {
    header("Location: error.php");
    exit();
}

$pdo = new_PDO();
$sql = "select * from blog where id = :id";
$ps = $pdo->prepare($sql);
$ps->bindValue(":id", $id, PDO::PARAM_INT);
$ps->execute();
$blog = $ps->fetch();

?>
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
                            <form action="update_post.php" method="post">
                                <input type="hidden" name="id" value="<?php h($blog["id"]); ?>">
                                <div class="form-group mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo h($blog["title"]); ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="text">Text</label>
                                    <textarea class="form-control form-control-lg" id="blog_text" name="blog_text" ><?php echo h($blog["blog_text"]); ?></textarea>
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
