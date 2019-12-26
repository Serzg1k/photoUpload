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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <form id="form-filter">
                <div class="row">
                    <div class="col">
                        <input type="text" id="min-height" class="form-control" placeholder="Min height">
                    </div>
                    <div class="col">
                        <input type="text" id="max-height" class="form-control" placeholder="Max height">
                    </div>
                    <div class="col">
                        <input type="text" id="min-width" class="form-control" placeholder="Min width">
                    </div>
                    <div class="col">
                        <input type="text" id="max-width" class="form-control" placeholder="Max width">
                    </div>
                    <div class="col">
                        <input type="text" id="views" class="form-control" placeholder="Views">
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
                <div class="alert alert-danger" role="alert" style="display: none">
                    File is empty
                </div>
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
<div class="modal fade myModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="load-image">
            <img src="https://flevix.com/wp-content/uploads/2019/07/Ring-Preloader.gif" alt="" width="500px">
        </div>
    </div>
</div>
<script src="/source/script.js"></script>
