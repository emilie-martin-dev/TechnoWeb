<?php
    include("template/base/header_html.php");
?>


<?= $errorDiv?>

<form class="form-center w12" action="<?= $urlAction?>" method="POST">
    
    <h2><?= $title?></h2>
    <label for="<?= BuilderConfig::FIELD_LIBELLE?>"><?=$libelleFieldValue?> (secondes)</label>
    <input name="<?= BuilderConfig::FIELD_VALEUR?>" placeholder="Valeur" id="<?= BuilderConfig::FIELD_VALEUR?>" value="<?= $valeurFieldValue?>"/>
    
    <input type="submit" value="Valider"/>
</form>

<?php
    include("template/base/footer_html.php");
?>
