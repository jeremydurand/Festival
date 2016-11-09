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
        $idTypeChambre = 'C1';
        $id = array('idEtab' => $idEtab, 'idTypeChambre' => $idTypeChambre);
        Bdd::connecter();

        echo "<h2>Test OffreDAO</h2>";
        // Test n°1
        echo "<h3>1- getOneById</h3>";
        try {
            $id2 = array('idEtab' => $idEtab, 'idTypeChambre' => 'C2');
            $objet = OffreDAO::getOneById($id2);
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
            $objet = array('idEtab' => $idEtab, 'idTypeChambre' => $idTypeChambre, 'nbChambresDemandees' => 6);
            $ok = OffreDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion : ajout de 6 chambres de type C1 pour l'établissement d'id 0350773A ooo</h4>";
                $objetLu = OffreDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>>ooo réussite du test : la requête d'insertion a échoué ooo</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>>ooo réussite du test : la requête d'insertion a échoué ooo</h4>" . $ex->getMessage();
        }


        // Test n°4
        echo "<h3>4- update</h3>";
        try {
            $objet = 7;
            $ok = OffreDAO::update($id, $objet);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour de l'etablissement d'id 0350773A il a désormais 7 pour les chambres de type C1 ooo</h4>";
                $objetLu = OffreDAO::getOneById($id);
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
            $ok = OffreDAO::delete($id);
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de la suppression ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        /*// Test n°6
        echo "<h3>6-getNbCh - obtenir le nombre de chambre </h3>";
        try {
            $objet = OffreDAO::getNbCh($idEtab, 'C2');
            echo $objet;
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }*/
        // Test n°7
        echo "<h3>7- obtenirNbOffre - obtenir le nombre d'offres</h3>";
        try {
            $objet = OffreDAO::obtenirNbOffre($idEtab, 'C2');
            echo "Nombre d'offres : ".$objet;
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        // Test n°8
        echo "<h3>8- estModifOffreCorrecte - verifier si la modification de l'offre est correcte| CAS CORRECT</h3>";
        try {
            $objet = OffreDAO::estModifOffreCorrecte($idEtab, 'C2', 8);
            if($objet){
                echo "<h4>L'offre est correcte : test conforme</h4>";
            }else{
                echo "<h4>L'offre est incorrecte : test non conforme</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        } 
        
        // Test n°8
        echo "<h3>8- estModifOffreCorrecte - verifier si la modification de l'offre est correcte | CAS INCORRECT</h3>";
        try {
            $objet = OffreDAO::estModifOffreCorrecte($idEtab, 'C2', 1);
            if($objet){
                echo "<h4>L'offre est correcte : test non conforme</h4>";
            }else{
                echo "<h4>L'offre est incorrecte : test conforme</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        } 
        
       /*// Test n°3
        echo "<h3>3- insert</h3>";
        try {
            $idEtab = '9999999Z';
            $objet = new Offre($idEtab, 'C2', 5);
            $ok = OffreDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = OffreDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>>ooo réussite du test : la requête d'insertion a échoué ooo</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>>ooo réussite du test : la requête d'insertion a échoué ooo</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- insert déjà présent</h3>";
        try {
            $objet = new Offre($idEtab, 'C2', 5);
            $ok = OffreDAO::insert($objet);
            if ($ok) {
                echo "<h4>*** échec du test : l'insertion ne devrait pas réussir  ***</h4>";
                $objetLu = OffreDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>>ooo réussite du test : la requête d'insertion a logiquement échoué ooo</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>>ooo réussite du test : la requête d'insertion a logiquement échoué ooo</h4>" . $ex->getMessage();
        }*/


        /*// Test n°4
        echo "<h3>4- update</h3>";
        try {
            $idTypeChambre = "C1";
            $idEtab = "0350773A";
            $nbChambres = 44;
            $ok = OffreDAO::update($idEtab, $idTypeChambre, $nbChambres);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour de l'etablissement d'id 0350773A il a désormais ".$nbChambres." pour les chambres de type C1 ooo</h4>";
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
        }*/

        /*// Test n°6
        echo "<h3>6-1- isAnExistingId - id existant</h3>";
        try {
            $id = "0350773A"; // id existant
            $ok = OffreDAO::isAnExistingId($id);
            if ($ok == 1) {
                echo "<h4>ooo réussite du test, l'id existe ooo</h4>";
            } else {
                echo "<h4>*** échec du test, l'id n'existe pas ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        echo "<h3>6-2- isAnExistingId - id inexistant</h3>";
        try {
            $id = "0350773x"; // id inexistant
            $ok = OffreDAO::isAnExistingId($id);
            //$ok = $ok && !OffreDAO::isAnExistingId('AZERTY');
            if ($ok == 1) {
                echo "<h4>*** échec du test, l'id existe ***</h4>";
                
            } else {
                echo "<h4>ooo réussite du test, l'id n'existe pas ooo</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }*/
        
        Bdd::deconnecter();
        ?>


    </body>
</html>
