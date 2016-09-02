<?php
if(!defined('RACINE_SITE')) {
	header('Location:../index.php');
	exit();
}

//	error_reporting(E_ALL);
//	ini_set("display_errors", 1);

define("WEBMAIL", 'carlos.dupriez@gmail.com');
define("SITEMAIL", 'webmaster@intelligent.domoquick.fr');

////////////////////////////
///// VAR //////////////////
////////////////////////////

// chiffrement des données
$cost = 10;
$options = [
	'cost' => $cost,
	'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];

// valeur min de characteres accepté pour les champs limitées dans les formulaires
$minLen = 3;

// déclaration d'une variable qui nous servira à afficher des messages à l'utilisateur
$msg = "";

// déclaration d'une variable qui nous servira à afficher des messages de debug
$_debug = array();

