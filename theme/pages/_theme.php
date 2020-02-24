<!doctype html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="<?= url('/theme/js/jQuery.js') ?>"></script>
    <link rel="stylesheet" href="<?= url('/theme/css/bootstrap.min.css'); ?>">
    <script src="<?= url('/theme/js/bootstrap.min.js') ?>"></script>


    <title><?= $title; ?></title>
</head>
<body>

<?php if ($v->section("sidebar")): ?>
    <?= $v->section("sidebar"); ?>
<?php else: ?>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <a class="navbar-brand" href="#">Phrases Analysis</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= url(); ?>">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url("/blackList"); ?>">BlackList</a>
                    </li>
                    <!--                <li class="nav-item">-->
                    <!--                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>-->
                    <!--                </li>-->
                </ul>
            </div>
        </nav>
    </div>
    <br><br>
<?php endif; ?>
<br>
<?= $v->section("content"); ?>

<?= $v->section("scripts"); ?>
</body>
</html>
