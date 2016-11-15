<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>AttributionDAO : test</title>
    </head>

    <body>

        <?php

        use modele\dao\AttributionDAO;
        use modele\dao\Bdd;
        use modele\metier\Attribution;

        require_once __DIR__ . '/../includes/autoload.php';

        $idEtab = '0350773A';
        $idTypeChambre = 'C2';
        $idGroupe = 'g001';
        $nombreChambres = 7;
        $id = array('idEtab' => $idEtab, 'idTypeChambre' => $idTypeChambre, 'idGroupe' => $idGroupe);
        Bdd::connecter();

        echo "<h2>Test AttributionDAO</h2>";
        // Test n°1
        echo "<h3>1- getOneById</h3>";
        try {
            $id2 = array('idEtab' => '0350773A', 'idTypeChambre' => 'C2', 'idGroupe' => 'g004');
            $objet = AttributionDAO::getOneById($id2);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- getAll</h3>";
        try {
            $lesObjets = AttributionDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        // Test n°3
        echo "<h3>3- insert</h3>";
        try {
            $objet = array('idEtab' => $idEtab, 'idTypeChambre' => $idTypeChambre, 'idGroupe' => $idGroupe,'nombreChambres' => $nombreChambres);
            $ok = AttributionDAO::insert($objet);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion : ajout de 6 chambres de type C1 pour l'établissement d'id 0350773A ooo</h4>";
                $objetLu = AttributionDAO::getOneById($id);
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
            $objet = 5;
            $ok = AttributionDAO::update($id, $objet);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour de l'etablissement d'id 0350773A il a désormais 7 pour les chambres de type C1 ooo</h4>";
                $objetLu = AttributionDAO::getOneById($id);
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
            $ok = AttributionDAO::delete($id);
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de la suppression ***</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°6
        echo "<h3>6-obtenirNbDispo - obtenir la disponibilité des chambres </h3>";
        try {
            $objet = AttributionDAO::obtenirNbDispo($idEtab, $idTypeChambre);
            echo $objet;
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        // Test n°7
        echo "<h3>7- obtenirNbOccupGroupe - obtenir le nombre de chambre occupé par groupe </h3>";
        try {
            $objet = AttributionDAO::obtenirNbOccupGroupe('0350773A' , 'C2', 'g004');
            echo "Nombre d'attributions : ".$objet;
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        // Test n°8
        echo "<h3>8- existeAttributionsEtab - verifier si l'attribution axiste pour un établissement | CAS EXISTANT</h3>";
        try {
            $objet = AttributionDAO::existeAttributionsEtab($idEtab);
            if($objet){
                echo "<h4>L'attribution existe : test conforme</h4>";
            }else{
                echo "<h4>L'attribution existe pas : test non conforme</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        } 
        
        // Test n°8-2
        echo "<h3>8-2 existeAttributionsEtab - verifier si l'attribution existe pour un établissement | CAS NON EXISTANT</h3>";
        try {
            $objet = AttributionDAO::existeAttributionsEtab('nonexistant');
            if($objet){
                echo "<h4>L'attribution existe : test non conforme</h4>";
            }else{
                echo "<h4>L'attribution existe pas : test conforme</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }
        
        // Test n°9
        echo "<h3>9- existeAttributionsTypeChambre - verifier si l'attribution existe pour un type chambre | CAS EXISTANT</h3>";
        try {
            $objet = AttributionDAO::existeAttributionsTypeChambre($idTypeChambre);
            if($objet){
                echo "<h4>L'attribution existe : test conforme</h4>";
            }else{
                echo "<h4>L'attribution existe pas : test non conforme</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        } 
        
        // Test n°9-2
        echo "<h3>9-2 existeAttributionsTypeChambre - verifier si l'attribution existe pour un type chambre | CAS NON EXISTANT</h3>";
        try {
            $objet = AttributionDAO::existeAttributionsTypeChambre('nonexistant');
            if($objet){
                echo "<h4>L'offre existe : test non conforme</h4>";
            }else{
                echo "<h4>L'offre existe pas : test conforme</h4>";
            }
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        } 
        
        // Test n°10
        echo "<h3>10- obtenirNbAttribGrp - obtenir le nombre d'attributions par groupe </h3>";
        try {
            $objet = AttributionDAO::obtenirNbAttribGrp('0350773A' , 'C2', 'g004');
            echo "<h4>$objet</h4>";
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        } 
        
        // Test n°11
        echo "<h3>11- obtenirNbOccup </h3>";
        try {
            $objet = AttributionDAO::obtenirNbOccup('0350773A' , 'C2');
            echo $objet;
        } catch (Exception $ex) {
            echo "<h4>>ooo réussite du test : la requête d'insertion a logiquement échoué ooo</h4>" . $ex->getMessage();
        }


        /*// Test n°4
        echo "<h3>4- update</h3>";
        try {
            $idTypeChambre = "C1";
            $idEtab = "0350773A";
            $nbChambres = 44;
            $ok = AttributionDAO::update($idEtab, $idTypeChambre, $nbChambres);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour de l'etablissement d'id 0350773A il a désormais ".$nbChambres." pour les chambres de type C1 ooo</h4>";
                $objetLu = AttributionDAO::getOneById($idEtab);
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
            $ok = AttributionDAO::delete($idEtab);
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
            $ok = AttributionDAO::isAnExistingId($id);
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
            $ok = AttributionDAO::isAnExistingId($id);
            //$ok = $ok && !AttributionDAO::isAnExistingId('AZERTY');
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
