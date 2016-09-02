<?php

// Items du formulaire
$_formulaire = array();

$_formulaire['email'] = array(
    'type' => 'email',
    'content' => 'mail',
    'defaut' => "e.mail@webmail.net",
    'obligatoire' => true,
    'rectification' => true);

$_formulaire['valide'] = array(
    'type' => 'submit',
    'defaut' => $_trad['defaut']['valider']);