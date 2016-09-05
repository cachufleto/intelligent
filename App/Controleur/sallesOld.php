<?php
include_once MODEL . 'salles.php';
include_once FUNC . 'salles.php';


function recherche()
{
    include FUNC . 'form.func.php';
    $echoville = ListeDistinc('ville', 'salles', array('valide'=>'tokyo'));
    $echocategorie = ListeDistinc('categorie', 'salles', array('valide'=>'R'));
    $echocapacite = ListeDistinc('capacite', 'salles', array('valide'=>'56'));

    include VUE . 'salles/recherche.tpl.php';
}

