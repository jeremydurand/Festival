<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Attribution Test</title>
    </head>
    <body>
        <?php
        use modele\metier\Attribution;
        require_once __DIR__ . '/../includes/autoload.php';
        echo "<h2>Test unitaire de la classe métier Attribution/h2>";
        $objet = new Offre('9999999A', 'C2', '5fsq',4);
        var_dump($objet);
        ?>
    </body>
</html>

