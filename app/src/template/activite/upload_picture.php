<?php
    include("template/base/header_html.php");
?>

<form class="form-center w8" enctype="multipart/form-data" action="<?= $urlAction?>" method="POST">
    <h2>Sélectionner l'image à ajouter</h2>
    <input type="file" name="file"/>

    <input type="submit" value="Valider"/>
</form>

<?php
    include("template/base/footer_html.php");
?>
