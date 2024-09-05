<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Blog</title>
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
                    <a href="#" class="btn btn-success w-100">ブログ作成</a>
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
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><a href="#" class="btn btn-secondary">
                                                詳細
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- ループ処理中止 -->
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