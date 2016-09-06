<?php

// Items du formulaire
$_formulaire = array();

$_formulaire['mdp'] = array(
    'type' => 'password',
    'content' => 'text',
    'maxlength' => 14,
    'defaut' => $this->_trad['defaut']['MotPasse'],
    'obligatoire' => true,
    'rectification' => true);

$_formulaire['jeton'] = array(
    'type' => 'hidden',
    'content' => 'text',
    'acces' => 'private',
    'defaut' => 'validation');

$_formulaire['valide'] = array(
    'type' => 'submit',
    'defaut' => $this->_trad['defaut']['valider']);