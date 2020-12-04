<?php
    include("template/base/header_html.php");
?>

<p>Confirmer?</p>
<form action="<?= $urlAction?>" method="POST">
    <input type="submit" value="Valider"/>
</form>

<?php
    include("template/base/footer_html.php");
?>