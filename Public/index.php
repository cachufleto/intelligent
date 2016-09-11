<?php
// Insertion des parametres de fonctionement
include __DIR__ . '/../conf/constantes.php';
// inclusion du autoloader
require RACINE_SERVER . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// inclusion des paramettres de connexion
if(file_exists(CONF . 'connection.php')){
	include_once (CONF . 'connection.php');
}else{
	exit("<h2>L'Outil n'est pas instalé!<h2><p>Vous n'avez pas les parametres de connection à la base des donnes</p>");
}

// class d'acces à la base des données
require LIB . 'Bdd.php';
// class de l'application
require LIB . 'App.php';
// class des formulaires
require LIB . 'formulaire.php';
// functions de debug
require FUNC . 'debug.php';
// functions communes du noyeau
require FUNC . 'functions.php';
require FUNC . 'com.func.php';

// application
$__app = new \App\App();

require $__app->class;
$app = new $__app->controleur();

require CONF . 'init.php';
require_once INC . 'init.inc.php';

/*************************************************************/
ob_start();

$arg = ($nav = 'erreur404')? $nav : '';
$app->{$__app->action}($arg);

/*
$nav = array_key_exists($nav, $route)? $nav : 'erreur404';
// insertion des pages dinamiques
if ($nav != 'erreur404'){
	include_once CONTROLEUR . $route[$nav]['Controleur'] . '.php';
	//use App\site;
	$app = new $route['erreur404']['Controleur']();
	$function = $route[$nav]['action'];
	if (method_exists($app, $function)){
		$app->$function();
	} else {
		include_once CONTROLEUR . $route['erreur404']['Controleur'] . '.php';
		$app = new $route['erreur404']['Controleur']();
		$app->$route['erreur404']['action']($nav);
	}
} else {
	include_once CONTROLEUR . $route['erreur404']['Controleur'] . '.php';
	$app = new $route['erreur404']['Controleur']();
	$app->$route['erreur404']['action']('erreur404');
}
*/

_debug($route[$nav], 'Route pour: ' . $nav);

$contentPage = ob_get_contents();
ob_end_clean();

ob_start();
if(DEBUG) {
	// affichage des debug
	$_trad = setTrad();
	debugParam($_trad);
	debugPhpInfo();
	debugCost();
	_debug($BDD, 'BASE');
	debug($_debug);
}
debugTestMail();
$debug = ob_get_contents();
ob_end_clean();

if(file_exists(APP . 'Public/css/' . $route[$nav]['action'] . '.css')){
	$_linkCss[] = LINK . 'css/' . $route[$nav]['action'] . '.css';
}
if(file_exists(APP . 'Public/js/' . $route[$nav]['action'] . '.js')){
	$_linkJs[] = LINK . 'js/' . $route[$nav]['action'] . '.js';
}

$_link = siteHeader($_linkCss);
$navPp = nav((utilisateurAdmin() && isset($_SESSION['BO']))? 'navAdmin' : '');
$nav = array_key_exists($nav, $route)? $nav : 'erreur404';

$footer = footer();

include VUE . 'template.tpl.php';
