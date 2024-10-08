<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("../main/views/_head_view.php") ?>
</head>
<body>
<main class="container py-4">
    <?php require("../main/views/_message.php"); ?>
    <div class="row mt-3">
        <div class="col-6">
            <h3>Sign in</h3>
            <hr>
            <form action="signin_post.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>" />
                <div class="form-group">
                    <label for="username">Name</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"><br>
                </div>
                <button type="submit" class="btn btn-secondary">Sign in</button>
            </form>
            <hr>
            <a href="signup.php">Sign up an account</a>
        </div>
    </div>
</main>
</body>
</html>