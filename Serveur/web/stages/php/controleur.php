<?php

require_once dirname(__FILE__) . '/../../commun/php/base.inc.php';
inclure_fichier('commun', 'requete.inc', 'php'); // Ajouter dans base.inc ?

/**
 * Cette classe s'occupe de tous les appels pouvant être effectués
 * sur le module Stages, à savoir la recherche de stages.
 *
 * Auteur : benjamin.bouvier@gmail.com (2011/2012)
 */
class Stages {

	/**
	 * Recherche des stages appropriés selon les paramètres donnés.
	 *
	 * $mots_cles : tableau contenant les mots clés sous forme de
	 * chaînes (une case du tableau par mot clé)
	 * $annee : valeur parmi 3, 4 ou 5
	 * $duree : valeur comprise entre 1 et 12 inclus (12 peut indiquer
	 * 	plus de 12 mois, le cas échéant). 
	 * $lieu : chaîne
	 * $entreprise : chaîne
	 */

	static function rechercher($mots_cles, $annee, $duree,
				$lieu, $entreprise) {

		$requete = new Requete("SELECT titre, annee, description, " .
		"duree, lieu, entreprise, contact, lien_fichier FROM Stage");

		if ( isset($annee) ) {
			switch($annee) {
			// En bdd, les valeurs des années peuvent être 3, 4, 5, 7, 9.
			// Outre les valeurs auxquelles on peut s'attendre, les valeurs
			// 7 correspondent à 3ème et 4ème année (3+4=7) et 9 à 4ème et
			// 5ème année (4+5=9). Il faut donc adapter les requêtes
			// de recherche en conséquent
				case '3':
					$condition = '(annee = 3 OR annee = 7)';
					break;
				case '4':
					$condition = '(annee = 4 OR annee = 7 OR annee = 9)';
					break;
				case '5':
					$condition = '(annee = 5 OR annee = 9)';
					break;
			}
			$requete->ajouterCondition($condition);
			// $requete->ajouterConditionEgale('annee', $annee);	
		}

		/* TODO durée encore non prise en compte */
		/*
		if ( isset($duree) ) {
			$requete->ajouterConditionEgale('duree', $duree);
		}
		 */

		if ( isset($lieu) ) {
			$requete->ajouterConditionComme('lieu', $lieu);
		}

		if ( isset($entreprise) ) {
			$requete->ajouterConditionComme('entreprise', $entreprise);
		}

		if ( isset($mots_cles) ) {
			$requete->rechercherSur(
				array('titre','description', 'mots_cles'),
				$mots_cles);	
		}

		// Pré-traitement des résultats
		$resultats = $requete->lire();
		$nb_resultats = count($resultats);
		for ($i = 0; $i < $nb_resultats; ++$i) {
			// Reformater les années correctement.
			if ($resultats[$i]->annee == 7) {
				$resultats[$i]->annee = '3 et 4';
			} else if ($resultats[$i]->annee == 9) {
				$resultats[$i]->annee = '4 et 5';
			}

			// L'indiquer si la description est vide.
			if (!$resultats[$i]->description) {
				$resultats[$i]->description = '(pas de description)';
			}
		}
		return $resultats; 
	}
}

?>
