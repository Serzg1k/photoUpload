<?php

require __DIR__ . '/IConnectInfo.php';
require __DIR__ . '/Database.php';

$pdo = Database::getInstance();
$result = $pdo->getHtml(1,10);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Upload Bootstrap</title>

    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://getbootstrap.com/docs/4.0/examples/album/album.css" rel="stylesheet">
</head>
<body>
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <form>
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Min height">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Max height">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Min width">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Max width">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Views">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </nav>
</header>

<main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Album example</h1>

                <form method="post" action="" enctype="multipart/form-data" id="upload-form">
                    <div class="form-group">
                        <input class="form-control-file" type="file" id="file" name="file" />
                        <input type="submit" class="button" value="Upload" id="but_upload">
                    </div>
                </form>
            </div>
        </section>
        <div id="select-result">
            <?= $result ?>
        </div>
    </div>
</main>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="/source/script.js"></script>
