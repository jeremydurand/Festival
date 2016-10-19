<?php
namespace modele\metier;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Offre
 *
 * @author btssio
 */
class Offre {
    private $id;
    private $typeChambre;
    private $nbChambres;
    function __construct($id, $typeChambre, $nbChambres) {
        $this->id = $id;
        $this->typeChambre = $typeChambre;
        $this->nbChambres = $nbChambres;
    }
    function getId() {
        return $this->id;
    }

    function getTypeChambre() {
        return $this->typeChambre;
    }
    
     function getNbChambres() {
        return $this->nbChambres;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTypeChambre($typeChambre) {
        $this->typeChambre = $typeChambre;
    }
    
    function setNbChambres($nbChambres) {
        $this->nbChambres = $nbChambres;
    }

}
