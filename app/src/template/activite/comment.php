<div id="espace-com">

    <p class="titre">Espace commentaires</p>

    <form action="<?= $urlAction?>" method="POST">
        <label for="<?= BuilderComment::FIELD_TEXTE?>">Commentaire</label>
        <input name="<?= BuilderComment::FIELD_TEXTE?>" placeholder="Donnez votre avis !" id="<?= BuilderComment::FIELD_TEXTE?>"/>
        
        <input type="submit" value="Envoyer"/>
    </form>

    <?= $commentairesDiv ?>
</div>