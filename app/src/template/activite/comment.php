<p>Espace commentaires</p>

<?php

?>

<form action="<?= $urlAction?>" method="POST">
	<label for="<?= BuilderComment::FIELD_TEXTE?>">Commentaire</label><input name="<?= BuilderComment::FIELD_TEXTE?>" placeholder="Donnez votre avis !" id="<?= BuilderComment::FIELD_TEXTE?>"/>
    <input type="submit" value="Valider"/>
</form>


<?php



?>
        <?=$commentaire?>
<?php

?>
