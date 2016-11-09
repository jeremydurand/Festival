<?php
namespace modele\dao;

use modele\metier\Attribution;
use PDO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AttributionDAO
 *
 * @author btssio
 */
class AttributionDAO {
    protected static function enregVersMetier($enreg) {
        $idEtab = $enreg['idEtab'];
        $idTypeChambre = $enreg['idTypeChambre'];
        $idGroupe = $enreg[strtoupper('$idGroupe')];
        $nbChambres = $enreg[strtoupper('$nombreChambres')];

        $uneAttribution = new Attribution($idEtab, $idTypeChambre, $idGroupe, $nbChambres);

        return $uneAttribution;
    }

    /**
     * Valorise les paramètre d'une requête préparée avec l'état d'un objet Etablissement
     * @param type $objetMetier un Etablissement
     * @param type $stmt requête préparée
     */
    protected static function metierVersEnreg($objetMetier, $stmt) {
        // On utilise bindValue plutôt que bindParam pour éviter des variables intermédiaires
        $stmt->bindValue(':idEtab', $objetMetier->getIdEtab());
        $stmt->bindValue(':idTypeChambre', $objetMetier->getIdTypeChambre());
        $stmt->bindValue(':idGroupe', $objetMetier->getIdGroupe());
        $stmt->bindValue(':nbChambres', $objetMetier->getNbChambres());
    }
     /**
     * Insérer un nouvel enregistrement dans la table à partir de l'état d'un objet métier
     * @param Etablissement $objet objet métier à insérer
     * @return boolean =FALSE si l'opérationn échoue
     */
    public static function insert($objet) {
        $requete = "INSERT INTO Attribution VALUES (:idEtab, :idTypeChambre, :idGroupe, :nbChambres)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Mettre à jour enregistrement dans la table à partir de l'état d'un objet métier
     * @param string identifiant de l'enregistrement à mettre à jour
     * @param Etablissement $objet objet métier à mettre à jour
     * @return boolean =FALSE si l'opérationn échoue
     */
    public static function update($id, $objet) {
        $ok = false;
        $requete = "UPDATE  Attribution SET nombreChambres=:nbChambres WHERE idEtab=:idEtab AND idGroupe=:idGroupe AND idTypeChambre=:idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idGroupe', $idGroupe);
        $stmt->bindParam(':idTypeChambre', $idTypeChambre);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    public static function delete($id) {
        $ok = false;
        $requete = "DELETE FROM Attribution WHERE idEtab=:idEtab AND idGroupe=:idGroupe AND idTypeChambre=:idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idGroupe', $idGroupe);
        $stmt->bindParam(':idTypeChambre', $idTypeChambre);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
        //return false;
    }

    public static function getAll() {
        $lesObjets = array();
        $requete = "SELECT * FROM Attribution";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    public static function getOneById($id) {
        $objetConstruit = null;
        $requete = "SELECT * FROM Attribution WHERE idEtab=:idEtab AND idGroupe=:idGroupe AND idTypeChambre=:idTypeChambre";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idGroupe', $idGroupe);
        $stmt->bindParam(':idTypeChambre', $idTypeChambre);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }
    
    public static function getAllByEtablissement($idEtab) {
        $lesGroupes = array();
        $requete = "SELECT * FROM Attribution
                    WHERE ID IN (
                    SELECT DISTINCT ID FROM Attribution a
                            INNER JOIN Attribution a ON a.IDGROUPE = g.ID 
                            WHERE IDETAB=:id
                    )";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $idEtab);
        $ok = $stmt->execute();
        if ($ok) {
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $lesGroupes[] = self::enregVersMetier($enreg);
            }
        } 
        return $lesGroupes;
    }
    
    public static function obtenirNbOccup($idEtab, $idTypeChambre) {
        $req = "SELECT IFNULL(SUM(nombreChambres), 0) AS totalChambresOccup FROM Attribution WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
        $stmt = Bdd::getPdo()->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        return $nb;
    }
}
