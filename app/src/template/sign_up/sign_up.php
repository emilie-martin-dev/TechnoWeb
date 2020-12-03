<?php
    include("template/base/header_html.php");
?>

<?= $errorDiv?>

<form class="form-center w6" action="<?= $urlAction?>" method="POST">
    <h2>Inscription</h2>
    <label for="<?= BuilderUtilisateur::FIELD_NOM?>">Nom</label>
    <input name="<?= BuilderUtilisateur::FIELD_NOM?>" placeholder="Nom" id="<?= BuilderUtilisateur::FIELD_NOM?>"/>
    
    <label for="<?= BuilderUtilisateur::FIELD_PRENOM?>">Prénom</label>
    <input name="<?= BuilderUtilisateur::FIELD_PRENOM?>" placeholder="Prénom" id="<?= BuilderUtilisateur::FIELD_PRENOM?>"/>
    
    <label for="<?= BuilderUtilisateur::FIELD_LOGIN?>">Login</label>
    <input name="<?= BuilderUtilisateur::FIELD_LOGIN?>" placeholder="Login" id="<?= BuilderUtilisateur::FIELD_LOGIN?>"/>
    
    <label for="<?= BuilderUtilisateur::FIELD_PASSWORD?>">Mot de passe</label>
    <input name="<?= BuilderUtilisateur::FIELD_PASSWORD?>" placeholder="Mot de passe" id="<?= BuilderUtilisateur::FIELD_PASSWORD?>" type="password"/>
    
    <input type="submit" value="Valider"/>
</form>

<?php
    include("template/base/footer_html.php");
?>
