<?php
# FORMULAIRE ARTICLES
// Items du formulaire
$_formulaire = array();

$_formulaire['produit'] = array(
	'type' => 'text',
	'content' => 'text',
	'maxlength' => 20,
	'defaut' => $this->_trad['champ']['produit'],
	'obligatoire' => true);

// origine
$_formulaire['fabricant'] = array(
	'type' => 'text',
	'content' => 'text',
	'maxlength' => 20,
	'defaut' => $this->_trad['champ']['fabricant'],
	'obligatoire' => true);
	
$_formulaire['pays'] = array(
	'type' => 'text',
	'content' => 'text',
	'maxlength' => 20,
	'defaut' => $this->_trad['champ']['pays'],
	'obligatoire' => false);

$_formulaire['ville'] = array(
	'type' => 'text',
	'content' => 'text',
	'defaut' => $this->_trad['defaut']['ville'],
	'obligatoire' => false);

$_formulaire['adresse'] = array(
	'type' => 'textarea',
	'content' => 'text',
	'defaut' => $this->_trad['defaut']['adresse'],
	'maxlength' => 300,
	'obligatoire' => false);

$_formulaire['cp'] = array(
	'type' => 'text',
	'content' => 'num',
	'defaut' => $this->_trad['defaut']['cp'],
	'obligatoire' => false);

// Produit
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

$_formulaire['ean'] = array(
	'type' => 'text',
	'content' => 'int',
	'defaut' => $this->_trad['defaut']['ean'],
	'length' => 13,
	'obligatoire' => true);

$_formulaire['prix_Achat'] = array(
	'type' => 'text',
	'content' => 'float',
	'defaut' => 0,
	'obligatoire' => true);

$_formulaire['categorie'] = array(
	'type' => 'radio',
	'content' => 'text',
	'option' => array('D', 'I', 'J'),
	'defaut' => 'R',
	'obligatoire' => true);

$_formulaire['stock'] = array(
	'type' => 'text',
	'content' => 'int',
	'defaut' => 0,
	'obligatoire' => true);

// ############## SUBMIT ############
$_formulaire['valide'] = array(
	'type' => 'submit',
	'defaut' => $this->_trad['defaut']["ajouter"]);
	