<?php
    include("template/base/header_html.php");
?>

<h1>Title : <?= $title?></h1>
<h1>Content : <?= $content?></h1>

<p><a href="<?= $this->router->getActiviteModifURL($activite->getId())?>">Modifier</a></p>
<p><a href="<?= $this->router->getActiviteSupprimerURL($activite->getId())?>">Supprimer</a></p>

<?php
    include("template/base/footer_html.php");
?>