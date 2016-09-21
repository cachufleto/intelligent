<?php

// Items du formulaire
$_formulaire = array();

// recuparation de l'id par GET ou POST
$_id = (int)(isset($_POST['id_article'])? $_POST['id_article'] : (isset($_GET['id'])? $_GET['id'] : false) );
// recuparation de l'id par GET ou POST
$position = (int)(isset($_POST['pos'])? $_POST['pos'] : (isset($_GET['pos'])? $_GET['pos'] : false) );
// edition pour modification
/*
$_formulaire['plagehoraire'] = array(
    'type' => 'checkbox',
    'content' => 'int',
    'defaut' => "",
    'option' => array(1=>'matinee', 2=>'journee', 3=>'soiree', 4=>'nocturne'),
    'obligatoire' => true);
*/
$_formulaire['valide'] = array(
    'type' => 'submit',
    'defaut' => $this->_trad['defaut']['valider']);