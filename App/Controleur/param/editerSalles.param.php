<?php
# FORMULAIRE SALLES

// Items du formulaire
$_formulaire = array();

$_formulaire['pays'] = array(
	'type' => 'text',
	'content' => 'text',
	'maxlength' => 20,
	'defaut' => $this->_trad['champ']['pays'],
	'obligatoire' => true);
	
$_formulaire['ville'] = array(
	'type' => 'text',
	'content' => 'text',
	'defaut' => $this->_trad['defaut']['ville'],
	'obligatoire' => true);

$_formulaire['adresse'] = array(
	'type' => 'textarea',
	'content' => 'text',
	'defaut' => $this->_trad['defaut']['Ouhabite'],
	'maxlength' => 300,
	'obligatoire' => true);

$_formulaire['cp'] = array(
	'type' => 'text',
	'content' => 'num',
	'defaut' => $this->_trad['defaut']['cp'],
	'obligatoire' => true);

$_formulaire['titre'] = array(
	'type' => 'text',
	'content' => 'text',
	'maxlength' => 20,
	'defaut' => $this->_trad['champ']['titre'],
	'obligatoire' => true);

$_formulaire['telephone'] = array(
	'type' => 'text',
	'content' => 'tel',
	'length' => 10,
	'defaut' => $this->_trad['defaut']['telephone'],
	'obligatoire' => true);

$_formulaire['photo'] = array(
	'type' => 'file',
	'content' => 'text',
	'defaut' => $this->_trad['defaut']['photo'],
	'obligatoire' => true);

$_formulaire['description'] = array(
	'type' => 'textarea',
	'content' => 'text',
	'defaut' => $this->_trad['defaut']['description'],
	'maxlength' => 800,
	'obligatoire' => true);

$_formulaire['capacite'] = array(
	'type' => 'text',
	'content' => 'int',
	'defaut' => $this->_trad['defaut']['capacite'],
	'obligatoire' => true);

$_formulaire['cap_min'] = array(
	'type' => 'text',
	'content' => 'int',
	'defaut' => $this->_trad['defaut']['cap_min'],
	'obligatoire' => true);

$_formulaire['tranche'] = array(
	'type' => 'selectTableau',
	'content' => 'int',
	'option' => array(1=>'T1', 2=>'T2', 3=>'T3', 4=>'T4'),
	'defaut' => $this->_trad['defaut']['tranche'],
	'obligatoire' => true);

$_formulaire['prix_personne'] = array(
	'type' => 'text',
	'content' => 'float',
	'defaut' => $this->_trad['defaut']['prix_personne'],
	'obligatoire' => true);

$_formulaire['categorie'] = array(
	'type' => 'radio',
	'content' => 'text',
	'option' => array('R', 'F', 'C', 'T'),
	'defaut' => 'R',
	'obligatoire' => true);

// ############## SUBMIT ############
$_formulaire['valide'] = array(
	'type' => 'submit',
	'defaut' => $this->_trad['defaut']["ajouter"]);
	