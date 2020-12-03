<!DOCTYPE html>
<html>
    <head>
        <title><?= empty($title) ? WEBSITE_DEFAULT_NAME : $title . " - " . WEBSITE_DEFAULT_NAME?></title>
        <link rel="stylesheet" href="/css/style.css">
    </head>

    <body class="backGroung contour-center container">
        <header class="row">
            <img src="img/header/logo.jpg" class="col w1">
            <h1 class="col center-text titreSite w10"><?=WEBSITE_DEFAULT_NAME?></h1>


        </header>
        <main>
            <?= $this->generateFeedbackDiv() ?>
