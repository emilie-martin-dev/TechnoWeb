<?php
    include("template/base/header_html.php");
?>

<?php
    foreach($activites as $k =>$a) {
?>
        <p><a href="<?= $this->router->getActiviteUrl($a->getId())?>"><?=$a->getNom()?></a> - <?=$a->getLieu()?> : <?=$a->getShortDescription()?></p>
        <hr/>
<?php
    }
?>

<?php
    include("template/base/footer_html.php");
?>
