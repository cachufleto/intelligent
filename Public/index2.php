<?php
// Insertion des parametres de fonctionement
include __DIR__ . '/../conf/constantes.php';

require_once INC . 'init.inc.php';

/*************************************************************/
ob_start();
$nav = array_key_exists($nav, $route)? $nav : 'erreur404';
// insertion des pages dinamiques
if ($nav != 'erreur404'){
	include_once CONTROLEUR . $route[$nav]['Controleur'] . '.php';
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

_debug($route[$nav], 'Route pour: ' . $nav);

$contentPage = ob_get_contents();
ob_end_clean();

ob_start();
if(DEBUG) {
	// affichage des debug
	//$_trad = setTrad();
	debugParam($_trad);
	debugPhpInfo();
	debugCost();
	_debug($BDD, 'BASE');
	debug($_debug);
}
debugTestMail();
$debug = ob_get_contents();
ob_end_clean();

if(file_exists(RACINE_SERVER . 'Public/css/' . $route[$nav]['action'] . '.css')){
	$_linkCss[] = LINK . 'css/' . $route[$nav]['action'] . '.css';
}
if(file_exists(RACINE_SERVER . 'Public/js/' . $route[$nav]['action'] . '.js')){
	$_linkJs[] = LINK . 'js/' . $route[$nav]['action'] . '.js';
}

$_link = siteHeader($_linkCss);
$navPp = nav((utilisateurAdmin() && $_SESSION['BO'])? 'navAdmin' : '');
$nav = array_key_exists($nav, $route)? $nav : 'erreur404';

$footer = footer();

include VUE . 'site/template.tpl.php';
