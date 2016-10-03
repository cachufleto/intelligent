<?php
# FORMULAIRE ARTICLES
// Items du formulaire
$_formulaire = array();

$_formulaire['article'] = array(
	'type' => 'text',
	'content' => 'text',
	'minlength' => 5,
	'defaut' => $this->_trad['champ']['produit'],
	'obligatoire' => true);

// origine
$_formulaire['fabricant'] = array(
	'type' => 'text',
	'content' => 'text',
	'defaut' => $this->_trad['champ']['fabricant'],
	'obligatoire' => true);
	
$_formulaire['ref'] = array(
	'type' => 'text',
	'content' => 'text',
	'maxlength' => 20,
	'defaut' => $this->_trad['champ']['ref'],
	'obligatoire' => false);

$_formulaire['dimention'] = array(
	'type' => 'text',
	'content' => 'text',
	'maxlength' => 400,
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

$_formulaire['spec'] = array(
	'type' => 'textarea',
	'content' => 'text',
	'defaut' => $this->_trad['defaut']['description'],
	'maxlength' => 1600,
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
	'minlength' => 1,
	'defaut' => 0,
	'obligatoire' => true);

$_formulaire['note'] = array(
	'type' => 'textarea',
	'content' => 'text',
	'defaut' =>'',
	'maxlength' => 1600,
	'obligatoire' => false);


// ############## SUBMIT ############
$_formulaire['valide'] = array(
	'type' => 'submit',
	'defaut' => $this->_trad['defaut']["ajouter"]);
	