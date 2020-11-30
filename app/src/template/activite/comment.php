<?php
    include("template/base/header_html.php");
?>

<h1><?= $title?></h1>

<?php
if($builder != null){
?>

<form action="<?= $urlAction?>" method="POST">
	<label for="<?= BuilderComment::FIELD_TEXTE?>">Commentaire</label><input name="<?= BuilderComment::FIELD_TEXTE?>" placeholder="Donnez votre avis !" id="<?= BuilderComment::FIELD_TEXTE?>"/>
    <input type="submit" value="Valider"/>
</form>

<?php
}else{
?>

<p>Vous voulez ajouter un commentaire ? <a href="<?= $this->router->getLoginUrl()?>">Connectez-vous !</a> - ou - <a href="<?= $this->router->getSignUpUrl()?>">Inscrivez-vous !</a></p>

<?php
}
if($comment != null){
    foreach($comment as $c) {
?>
        <p><?=$c->getUtilisateur()->getNom()?> <?=$c->getUtilisateur()->getPrenom()?> a écrit:</p>

        <p><?=$c->getTexte()?></p>

        <hr/>
<?php
    }
}
?>

<?php
    include("template/base/footer_html.php");
?>
