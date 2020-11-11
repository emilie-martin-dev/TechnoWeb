<!DOCTYPE html>
<html>
    <head>
        <title>Hello World HTML</title>
    </head>

    <body>
        <h1>Title : <?= $this->title?></h1>
        <h1>Content : <?= $this->content?></h1>

        <p><a href="<?= $this->router->getActiviteModifURL($activite->getId())?>">Modifier</a></p>
        <p><a href="<?= $this->router->getActiviteSupprimerURL($activite->getId())?>">Supprimer</a></p>
    </body>
</html>