<?php
    include("template/base/header_html.php");
?>

<?= $errorDiv?>

<form action="<?= $urlAction?>" method="POST">
    <label for="<?= BuilderActivite::FIELD_NOM?>">Nom</label><input name="<?= BuilderActivite::FIELD_NOM?>" placeholder="Nom" id="<?= BuilderActivite::FIELD_NOM?>" value="<?= $nomFieldValue?>"/>
    <label for="<?= BuilderActivite::FIELD_LIEU?>">Lieu</label><input name="<?= BuilderActivite::FIELD_LIEU?>" placeholder="Lieu" id="<?= BuilderActivite::FIELD_LIEU?>" value="<?= $lieuFieldValue?>"/>
    <label for="<?= BuilderActivite::FIELD_SHORT_DESCRIPTION?>">Description courte</label><textarea name="<?= BuilderActivite::FIELD_SHORT_DESCRIPTION?>" placeholder="Description courte" id="<?= BuilderActivite::FIELD_SHORT_DESCRIPTION?>" ><?= $shortDescriptionFieldValue?></textarea>
    <label for="<?= BuilderActivite::FIELD_DESCRIPTION?>">Description</label><textarea name="<?= BuilderActivite::FIELD_DESCRIPTION?>" placeholder="Description" id="<?= BuilderActivite::FIELD_DESCRIPTION?>"><?= $descriptionFieldValue?></textarea>

    <input type="submit" value="Valider"/>
</form>

<?php
    include("template/base/footer_html.php");
?>