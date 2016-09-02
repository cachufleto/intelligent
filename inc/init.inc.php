<?php
include CONF . 'connection.php';

require CONF . 'init.php';
require FUNC . 'com.func.php';
require FUNC . 'site.func.php';

/************************************************************
 * Creation de la session
 *************************************************************/
session();
// chargement de la langue

/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/
if( !is_dir(TARGET) ) {
	if( !mkdir(TARGET, 0755) ) {
		exit($_trad['erreur']['leRepertoireNePeutEtreCree']);
	}
}

// gestion de session
include INC . 'install.inc.php';

// options du menu de navigation
include_once CONF . 'nav.php';

// Control d'acces
////////////////////////////
///// NAV //////////////////
///////////////////////	/////
// page de navigation
$nav = (isset ($_GET['nav']) && !empty($_GET['nav']))? $_GET['nav'] : 'home';
//$nav = (array_key_exists($nav, $_pages))? $nav : 'erreur404';

// REGLE D'orientation des pages actif et out ver connection
if('actif' == $nav || 'out' == $nav) {
	$nav = 'connection';
}

// cas spécifique
$nav = (!utilisateurAdmin() && $nav=='users')? 'home' : $nav;

require CONF . 'route.php';

// Traduction du titre de la page

$_linkCss[] = LINK . 'css/style.css';
$_linkCss[] = LINK . 'css/tablette.css';
$_linkCss[] = LINK . 'css/smart.css';
if (isSuperAdmin()) {
	// ajout du css admin
	$_linkCss[] = LINK . 'css/admin.css';
}

$_linkJs[] = LINK . 'js/script.js';


