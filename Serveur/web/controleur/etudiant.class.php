<?php

require_once dirname(__FILE__) . '/../commun/php/base.inc.php';
inclure_fichier('commun', 'bd.inc', 'php');

class CV {

    //****************  Attributs  ******************//
    private $ID_ETUDIANT;
    private $NOM_ETUDIANT;
    private $PRENOM_ETUDIANT;
    private $SEXE_ETUDIANT;
    private $ADRESSE1_ETUDIANT;
    private $ADRESSE2_ETUDIANT;
    private $ID_VILLE;
    private $ville;
    private $TEL_ETUDIANT;
    private $MAIL_ETUDIANT;
    private $ANNIV_ETUDIANT;
    private $ID_VILLE_NAISSANCE;
    private $ville_naissance;
    private $NATIONALITE_ETUDIANT;
    private $ID_MARITAL;
    private $marital;
    private $ID_PERMIS;
    private $permis;
    private $PHOTO_ETUDIANT;
    private $ID_CV;

    //****************  Fonctions statiques  ******************//
    //recuperation de l'objet CV par l'ID de l'étudiant
    public static function GetCVByEtudiantID($_id) {
        if (is_numeric($_id)) {
            return BD::Prepare('SELECT * FROM ETUDIANT WHERE id_etudiant = :id', array('id' => $_id), BD::RECUPERER_UNE_LIGNE, PDO::FETCH_CLASS, __CLASS__);
        }
        return NULL;
    }

    public static function GetListePermis() {
        return BD::Prepare('SELECT * FROM PERMIS', '', BD::RECUPERER_TOUT);
    }

    //****************  Fonctions  ******************//
    //****************  Getters & Setters  ******************//
    public function getId() {
        return $this->ID_ETUDIANT;
    }

    public function getNom() {
        return $this->NOM_ETUDIANT;
    }

    public function getPrenom() {
        return $this->PRENOM_ETUDIANT;
    }

    public function getSexe() {
        return $this->SEXE_ETUDIANT;
    }

    public function getAdresse() {
        $adresse = $this->ADRESSE1_ETUDIANT;
        if ($this->ADRESSE2_ETUDIANT != '') {
            $adresse.=' - ' . $this->ADRESSE2_ETUDIANT;
        }
        return $adresse;
    }

    public function getVille() {
        if ($this->ville == NULL) {
            $this->ville = BD::Prepare('SELECT * FROM VILLE WHERE id_ville = :id', array('id' => $this->ID_VILLE), BD::RECUPERER_UNE_LIGNE);
        }
        return $this->ville;
    }

    public function getVilleNaissance() {
        if ($this->ville_naissance == NULL) {
            $this->ville_naissance = BD::Prepare('SELECT * FROM VILLE WHERE id_ville = :id', array('id' => $this->ID_VILLE_NAISSANCE), BD::RECUPERER_UNE_LIGNE);
        }
        return $this->ville_naissance;
    }

    public function getTel() {
        return $this->TEL_ETUDIANT;
    }

    public function getMail() {
        return $this->MAIL_ETUDIANT;
    }

    public function getAnniv() {
        return $this->ANNIV_ETUDIANT;
    }

    public function getNationalite() {
        return $this->NATIONALITE_ETUDIANT;
    }

    public function getIDMarital() {
        return $this->ID_MARITAL;
    }

    public function getIDPermis() {
        return $this->ID_PERMIS;
    }

    public function getPhotos() {
        return $this->PHOTO_ETUDIANT;
    }

    public function getIdCV() {
        return $this->ID_CV;
    }

}

?>
