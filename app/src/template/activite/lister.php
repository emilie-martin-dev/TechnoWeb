<!DOCTYPE html>
<html>
    <head>
        <title>Hello World HTML</title>
    </head>

    <body>
        <?php
            foreach($activites as $k =>$a) {
        ?>
                <p><a href="<?= $this->router->getActiviteUrl($a->getId())?>"><?=$a->getNom()?></a> - <?=$a->getLieu()?> : <?=$a->getShortDescription()?></p>
                <hr/>
        <?php
            }
        ?>
    </body>
</html>