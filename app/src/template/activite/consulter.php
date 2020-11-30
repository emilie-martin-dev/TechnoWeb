<?php
    include("template/base/header_html.php");
?>

<h1 class="center-text"><?= $title?></h1>

<p class="description"><?= $shortDesc?></p>

<div class="row">
    <div class="col w3">
        <?= $img ?>

        <p><a href="<?= $this->router->getActiviteUploadPictureURL($activite->getId())?>">Upload</a></p>
        <p><a href="<?= $this->router->getActiviteModifURL($activite->getId())?>">Modifier</a></p>
        <p><a href="<?= $this->router->getActiviteSupprimerURL($activite->getId())?>">Supprimer</a></p>
    </div>

    <div class="col w8" id="shortDesc">
        <p><?= $desc ?></p>
    </div>
</div>

<?php
include_once("template/activite/comment.php");
?>

<?php
    include("template/base/footer_html.php");
?>
