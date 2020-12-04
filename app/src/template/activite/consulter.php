<?php
    include("template/base/header_html.php");
?>

<h1 class="center-text"><?= $title?></h1>

<p id="shortDesc"><?= $shortDesc?></p>

<div class="row">
    <div class="col w3">
        <?= $img ?>

        <?= $actions ?>
    </div>

    <div class="col w8" id="description">
        <p><?= $desc ?></p>
    </div>
</div>

<?php
    include_once("template/activite/comment.php");

    include("template/base/footer_html.php");
?>
