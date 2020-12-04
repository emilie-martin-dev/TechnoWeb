<?php
    include("template/base/header_html.php");
?>

<?php
    foreach($activites as $k =>$a) {
?>
    <div class="row">
        <div class="nomLister center-text col w12">
            <p><a href="<?= $this->router->getActiviteUrl($a->getId())?>"><?=$a->getNom()?></a></p>

            <p class="littleSize">
                <?=$a->getLieu()?>
            </p>
        </div>

        <div class="col w8">
            <p>
                <?=$a->getShortDescription()?>
            </p>
        </div>
        <hr/>
    </div>
<?php
    }
?>

<?php
    include("template/base/footer_html.php");
?>
