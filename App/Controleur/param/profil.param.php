<?php

// on inclus les parametres du formulaire d'inscription
include PARAM . 'inscription.param.php';


// traitement selon le profil
$_id = $_SESSION['user']['id'];
// état de présentation
// edition pour modification
$_modifier = (isset($_POST['valide']) && $_POST['valide'] == $_trad['defaut']['modifier'])? true : false;
// validation du formaulare
$_valider = (isset($_POST['valide']) && $_POST['valide'] == $_trad['defaut']['MiseAJ'])? true : false;

//unset($_formulaire['mdp']['rectification']);
unset($_formulaire['email']['rectification']);

// interdir une balise pour modification
$_formulaire['pseudo']['type'] = 'null';
// id champ cachée
$_formulaire['id'] = array(
	'type' => 'hidden',
	'content' => 'int',
	'acces' => 'private',
	'defaut' => $_id);

//$_formulaire['mdp']['acces'] = 'private';

// affichage du boutton de validation
$_formulaire['valide']['defaut'] = $_trad['defaut']['modifier'];
$_formulaire['valide']['annuler']  = $_trad['Out'];
$_formulaire['valide']['origin']  = (
	isset($_POST['valide']) &&
	$_POST['valide'] == $_trad['defaut']['modifier']
	)? $_trad['defaut']['MiseAJ'] : '';
