<?php

// Items du formulaire
$_formulaire = array();

$_formulaire['pseudo'] = array(
	'type' => 'text',
	'content' => 'text',
	'maxlength' => 14,
	'defaut' => $_trad['champ']['pseudo']);
	
$_formulaire['mdp'] = array(
	'type' => 'password',
	'content' => 'text',
	'maxlength' => 14,
	'defaut' => $_trad['defaut']['MotPasse']);

// ############## SUBMIT ############
$_formulaire['valide'] = array(
	'type' => 'submit',
	'defaut' => $_trad['defaut']['SeConnecter']);

$_formulaire['rapel'] = array(
	'type' => 'checkbox',
	'content' => 'text',
	'option' => array('on'=>'deMoi'),
	'defaut' => $_trad['defaut']['MotPasse']);

