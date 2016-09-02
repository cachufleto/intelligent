<?php
# FORMULAIRE D'INSCRIPTION

// Items du formulaire
$_formulaire = array();

$_formulaire['prenom'] = array(
	'type' => 'text',
	'content' => 'text',
	'defaut' => $_trad['defaut']['Monprenom'],
	'obligatoire' => true);

$_formulaire['nom'] = array(
	'type' => 'text',
	'content' => 'text',
	'defaut' => $_trad['defaut']['Monnom'],
	'obligatoire' => true);

$_formulaire['pseudo'] = array(
	'type' => 'text',
	'content' => 'text',
	'maxlength' => 14,
	'defaut' => $_trad['champ']['pseudo'],
	'obligatoire' => true);

$_formulaire['email'] = array(
	'type' => 'email',
	'content' => 'mail',
	'defaut' => "e.mail@webmail.net",
	'obligatoire' => true,
	'rectification' => true);

$_formulaire['telephone'] = array(
	'type' => 'text',
	'content' => 'tel',
	'length' => 10,
	'defaut' => $_trad['defaut']['telephone']);

$_formulaire['gsm'] = array(
	'type' => 'text',
	'content' => 'tel',
	'length' => 10,
	'defaut' => $_trad['defaut']['gsm']);

$_formulaire['sexe'] = array(
	'type' => 'radio',
	'content' => 'text',
	'option' => array('m', 'f'),
	'defaut' => "",
	'obligatoire' => true);

$_formulaire['ville'] = array(
	'type' => 'text',
	'content' => 'text',
	'defaut' => $_trad['defaut']['ville']);

$_formulaire['cp'] = array(
	'type' => 'text',
	'content' => 'num',
	'defaut' => $_trad['defaut']['cp']);

$_formulaire['adresse'] = array(
	'type' => 'textarea',
	'content' => 'text',
	'maxlength' => 300,
	'defaut' => $_trad['defaut']["Ouhabite"]);

// ############## SUBMIT ############
$_formulaire['valide'] = array(
	'type' => 'submit',
	'defaut' => $_trad['defaut']["Inscription"]);