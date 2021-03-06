<?php

// on inclus les parametres du formulaire d'inscription
include PARAM . 'editerArticles.param.php';


// recuparation de l'id par GET ou POST
$_id = (int)(isset($_POST['id_article'])? $_POST['id_article'] : (isset($_GET['id'])? $_GET['id'] : false) );
// recuparation de l'id par GET ou POST
$position = (int)(isset($_POST['pos'])? $_POST['pos'] : (isset($_GET['pos'])? $_GET['pos'] : false) );
// edition pour modification
$_modifier = (isset($_POST['valide']) && $_POST['valide'] == $this->_trad['defaut']['modifier'])? true : false;
// validation du formaulare
$_valider = (isset($_POST['valide']) && $_POST['valide'] == $this->_trad['defaut']['MiseAJ'])? true : false;

/*************************************************************************************************************/

// affichage du boutton de validation
$_formulaire['valide']['defaut'] = $this->_trad['defaut']['modifier'];
$_formulaire['valide']['annuler']  = $this->_trad['Out'];
$_formulaire['valide']['origin']  = (isset($_POST['valide']) && $_POST['valide'] == $this->_trad['defaut']['modifier'])?
	$this->_trad['defaut']['MiseAJ'] : '';

// on rajoute la position
$_formulaire['pos'] = array(
	'type' => 'hidden',
	'content' => 'text',
	'acces' => 'private',
	'defaut' => $position);

// id_article champ cachée
$_formulaire['id_article'] = array(
	'type' => 'hidden',
	'content' => 'int',
	'acces' => 'private',
	'defaut' => $_id);

// on recharge le boutton valide
$_Form_autre = $_formulaire['valide'];
unset($_formulaire['valide']);
$_formulaire['valide'] = $_Form_autre;
