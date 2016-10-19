<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>OffreDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\OffreDAO;
        use modele\dao\Bdd;
        use modele\metier\Offre;

        require_once __DIR__ . '/../includes/autoload.php';

        $idEtab = '0350773A';
        Bdd::connecter();

        echo "<h2>Test OffreDAO</h2>";
        // Test n°1
        echo "<h3>1- getOneById</h3>";
        try {
            $objet1 = OffreDAO::getOneById($idEtab);
            echo "<p>Voici le libelle d'identifiant $idEtab : " . $objet->getTypeChambre() . "</p>";
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- getAll</h3>";
        try {
            $lesObjets = OffreDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- insert</h3>";
        try {
            $idEtab = '0350773A';
            $objet = new Offre($idEtab, 'C2', 5);
            $ok = OffreDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = OffreDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }


        // Test n°4
        echo "<h3>4- update</h3>";
        try {
            $objet->setTypeChambre('C1');
            $ok = OffreDAO::update($idEtab, $objet);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = OffreDAO::getOneById($idEtab);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de la mise à jour ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°5
        echo "<h3>5- delete</h3>";
        try {
            $ok = OffreDAO::delete($idEtab);
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°6
        echo "<h3>6-1- isAnExistingId - id existant</h3>";
        $id = "C1"; // id existant
        try {
            $ok = OffreDAO::isAnExistingId($idEtab);
            if ($ok == 1) {
                echo "<h4>ooo réussite du test, l'id existe ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        echo "<h3>6-2- isAnExistingId - id inexistant</h3>";
        $id = "Cx"; // id absent
        try {
            $ok = OffreDAO::isAnExistingId($idEtab);
            if ($ok == 1) {
                echo "<h4>*** échec du test, l'id ne devrait pas exister ***</h4>";
                
            } else {
                echo "<h4>ooo réussite du test, l'id n'existe pas ooo</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        Bdd::deconnecter();
        ?>


    </body>
</html>
