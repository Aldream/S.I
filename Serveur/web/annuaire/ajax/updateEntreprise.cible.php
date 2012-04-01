<?php
/**
 * -----------------------------------------------------------
 * AJOUTENTREPRISE - CIBLE PHP
 * -----------------------------------------------------------
 * Auteur : Benjamin (Bill) Planche - Aldream (4IF 2011/12)
 *          Contact - benjamin.planche@aldream.net
 * ---------------------
 * Cible pour l'ajout d'une entreprise.
 * Est donc appel�e par le moteur JS (Ajax) de la page Annuaire quand une entreprise est s�lectionn�e dans la liste des noms.
 * Le principe (repris de Bnj Bouv) est tr�s simple :
 * 1) On r�cup�re l'ensemble des variables qui ont �t� ins�r�es.
 * 2) On appelle le contr�leur 
 * 3) On renvoit les r�sultats en JSON
 * Le r�sultat sera de la forme :
 		{
			code : "ok", // ou "error" - si error, le champ id n'est pas pr�sent
			id : 1 		// ID de l'entreprise ajout�e
		}
 */

require_once dirname(__FILE__) . '/../../commun/php/base.inc.php';
inclure_fichier('controleur', 'entreprise.class', 'php');

/*
 * R�cup�rer et transformer le JSON
 */
/* string */ $nom_entreprise = NULL;
/* string */ $secteur_entreprise = NULL;
/* string */ $desc_entreprise = NULL;
/* string */ $com_entreprise = NULL;
/* int */ $id_entreprise = 0;

if (verifierPresent('nom')) {
	$nom_entreprise = Protection_XSS($_POST['nom']);
}
if (verifierPresent('secteur')) {
	$secteur_entreprise = Protection_XSS($_POST['secteur']);
}
if (verifierPresent('description')) {
	$desc_entreprise = Protection_XSS($_POST['description']);
}
if (verifierPresent('commentaire')) {
	$com_entreprise = Protection_XSS($_POST['commentaire']);
}
if (verifierPresent('id')) {
	$id_entreprise = intval($_POST['id']);
}

/*
 * Appeler la couche du dessous
 */
 
/* int */ $id = Entreprise::UpdateEntreprise($id_entreprise, $nom_entreprise, $desc_entreprise, $secteur_entreprise, $com_entreprise);

/*
 * Renvoyer le JSON
 */
$json['code'] = ($id != -1) ? 'ok' : 'error';
// FIXME comment distinguer s'il n'y a pas de r�sultats ou une erreur ?
if ($id != -1) {
	$json['id'] = $id;
}
echo json_encode($json);


?>
