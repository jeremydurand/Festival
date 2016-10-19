<?php

namespace modele\dao;

use modele\metier\Offre;
use PDOStatement;
use PDO;

/**
 * Description of TypeChambreDAO
 * Classe métier  :  TypeChambre
 * @author btssio
 */
class OffreDAO implements IDAO {

    /**
     * crée un objet métier à partir d'un enregistrement
     * @param array $enreg Description
     * @return TypeChambre objet métier obtenu
     */
    protected static function enregVersMetier($enreg) {
        $idEtab = $enreg[strtoupper('idEtab')];
        $typeChambre = $enreg[strtoupper('typeChambre')];
        $nbChambres  = $enreg[strtoupper('nbChambres')];;
        $objetMetier = new Offre($idEtab, $typeChambre, $nbChambres);
        return $objetMetier;
    }

    /**
     * Complète une requête préparée
     * les paramètres de la requête associés aux valeurs des attributs d'un objet métier
     * @param \modele\metier\Offre $objetMetier
     * @param \PDOStatement $stmt
     */
    protected static function metierVersEnreg(Offre $objetMetier, PDOStatement $stmt) {
        $stmt->bindValue(':idEtab', $objetMetier->getIdEtab());
        $stmt->bindValue(':typeChambre', $objetMetier->getTypeChambre());
        $stmt->bindValue(':nbChambres', $objetMetier->getNbChambres());
    }

    public static function getOneById($idEtab) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Offre WHERE ID = :idEtab";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }

    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Offre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    public static function insert($objet) {
        $ok = false;
        $requete = "INSERT INTO Offre VALUES (:idEtab, :typeChambre, :nbChambres)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        $ok = $ok && $stmt->rowCount() > 0;
        return $ok;
    }

    public static function update($idEtab, $objet) {
        $ok = false;
        $requete = "UPDATE Offre SET TYPECHAMBRE = :typeChambre WHERE ID = :idEtab";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':idEtab', $idEtab);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

    public static function delete($idEtab) {
        $ok = false;
        $requete = "DELETE FROM Offre WHERE ID = :idEtab";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }


    /**
     * Recherche un identifiant d'Etablissement existant
     * @param string $idEtab de l'etablissement recherché
     * @return int le nombre d'offres à cet id 
     */
    public static function isAnExistingId($idEtab) {
        $requete = "SELECT COUNT(*) FROM Offre WHERE ID=:idEtab";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }

}

