<?php
// Insertion des parametres de fonctionement
include __DIR__ . '/../conf/constantes.php';
// inclusion du autoloader
require RACINE_SERVER . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
// parametres initiales
require CONF . 'init.php';
//function communs
require FUNC . 'com.func.php';
// class de l'application
require LIB . 'Bdd.php';
// class des formulaires
require LIB . 'formulaire.php';
// functions de debug
require FUNC . 'debug.php';
// functions communes du noyeau
require FUNC . 'functions.php';
// function Template
require FUNC . 'site.func.php';

/************************************************************
 * Creation de la session
 *************************************************************/
## Ouverture des sessions
session_start();
// class de l'application
require LIB . 'App.php';

// application
$__app = new \App\App();

if ($__app->nav != 'erreur404'){
	$app = $__app->getControleur();
	$app->{$__app->action}();
} else {
	$app = $__app->getControleur();
	$app->{$__app->action}('erreur404');
}

/*************************************************************/
ob_start();

$arg = ($__app->nav == 'erreur404')? $__app->nav : '';
$app->{$__app->action}($arg);

_debug($__app->route[$__app->nav], 'Route pour: ' . $__app->nav);

$contentPage = ob_get_contents();
ob_end_clean();
ob_start();
if(DEBUG) {
	debugPhpInfo();
	debugCost();
	debug($_debug);
}
debugTestMail();
$debug = ob_get_contents();
ob_end_clean();

if(file_exists(APP . 'Public/css/' . $__app->route[$__app->nav]['action'] . '.css')){
	$__app->_linkCss[] = LINK . 'css/' . $__app->route[$__app->nav]['action'] . '.css';
}
if(file_exists(APP . 'Public/js/' . $__app->route[$__app->nav]['action'] . '.js')){
	$__app->_linkJs[] = LINK . 'js/' . $__app->route[$__app->nav]['action'] . '.js';
}

$_link = $__app->siteHeader();
$navPp = $__app->menu->nav((utilisateurAdmin() && isset($_SESSION['BO']))? 'navAdmin' : '');
//$nav = array_key_exists($__app->nav, $__app->route)? $__app->nav : 'erreur404';

$footer = $__app->menu->footer();

include VUE . 'template.tpl.php';
