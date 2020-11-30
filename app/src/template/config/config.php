<?php
    include("template/base/header_html.php");
?>

<h1><?= $title?></h1>

<?= $errorDiv?>

<form action="<?= $urlAction?>" method="POST">
    <label for="<?= BuilderConfig::FIELD_LIBELLE?>">Valeur du <?=$libelleFieldValue?> </label>
    <input name="<?= BuilderConfig::FIELD_VALEUR?>" placeholder="Valeur" id="<?= BuilderConfig::FIELD_VALEUR?>" value="<?= $valeurFieldValue?>"/>
    <label>secondes</label>  
    <input type="submit" value="Valider"/>
</form>

<?php
    include("template/base/footer_html.php");
?>
