<?php
    include("template/base/header_html.php");
?>

<?= $errorDiv?>

<form class="form-center w6" action="<?= $urlAction?>" method="POST">
    <h2>Connexion</h2>
    <label for="<?= BuilderLogin::FIELD_LOGIN?>">Login</label>
    <input name="<?= BuilderLogin::FIELD_LOGIN?>" placeholder="Login" id="<?= BuilderUtilisateur::FIELD_LOGIN?>" value="<?= $loginFieldValue?>"/>

    <label for="<?= BuilderLogin::FIELD_PASSWORD?>">Mot de passe</label>
    <input name="<?= BuilderLogin::FIELD_PASSWORD?>" placeholder="Mot de passe" id="<?= BuilderUtilisateur::FIELD_PASSWORD?>" type="password"/>
    
    <input name="<?= BuilderLogin::FIELD_STAY_CONNECTED?>" id="<?= BuilderLogin::FIELD_STAY_CONNECTED?>" type="checkbox"/>
    <label for="<?= BuilderLogin::FIELD_STAY_CONNECTED?>">Rester connecté</label>
    <input type="submit" value="Connexion"/>
</form>
<?php
    include("template/base/footer_html.php");
?>
