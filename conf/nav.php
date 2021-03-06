<?php
if(!defined('RACINE_SITE')) {
	header('Location:../index.php');
	exit();
}

////////////////////////////
///// menu de navigation ///
////////////////////////////

$_pages['home'] = array(
	'link' => LINK,
	'affiche' => true);

$_pages['detail'] = array(
	'link' => LINK,
	'affiche' => false);
/*
$_pages['reservation'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['reservationArticle'] = array(
	'link' => LINK,
	'affiche' => false);
*/
$_pages['recherche'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['rechercheArticle'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['mdpperdu'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['inscription'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['mentions'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['cgv'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['plan'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['newsletter'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['contact'] = array(
	'link' => LINK,
	'affiche' => false);
/*
$_pages['salles'] = array(
	'link' => LINK,
	'affiche' => false);
*/
$_pages['articles'] = array(
	'link' => LINK,
	'affiche' => false);
/*
$_pages['ficheSalles'] = array(
	'link' => LINK,
	'affiche' => false);
*/
$_pages['ficheArticles'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['validerInscription'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['validerCommande'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['validerFacture'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['identifians'] = array(
	'link' => LINK,
	'affiche' => false);

/************   MEMBRE    **************/

$_pages['actif'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['out'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['panier'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['mjprofil'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['profil'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['ficheMembre'] = array(
	'link' => LINK,
	'affiche' => false);

/************   ADMIN    **************/

$_pages['backoffice'] = array(
	'link' => LINK,
	'class' => 'admin',
	'affiche' => false);

$_pages['boutique'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['users'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['commandes'] = array(
	'link' => LINK,
	'affiche' => false);
/*
$_pages['gestionSalles'] = array(
	'link' => LINK,
	'affiche' => false);
*/
$_pages['gestionArtcles'] = array(
	'link' => LINK,
	'affiche' => false);
/*
$_pages['editerSalles'] = array(
	'link' => LINK,
	'affiche' => false);
*/
$_pages['editerArticles'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['changermotpasse'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['validerChangementMDP'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['expiration'] = array(
	'link' => LINK,
	'affiche' => false);

$_pages['validerCommande'] = array(
	'link' => LINK,
	'affiche' => false);



// Onglets à activer dans le menu de navigation selon le profil listeMenu();
//$_reglesAll = array('home', 'inscription', 'salles', 'reservation', 'recherche', 'actif');
$_reglesAll = array('home', 'inscription', 'articles', 'panier', 'actif');
//$_reglesMembre = array('home', 'profil', 'salles', 'reservation', 'recherche', 'out');
$_reglesMembre = array('home', 'articles', 'panier', 'commandes', 'profil');
//$_reglesAdmin = array('home', 'profil', 'salles', 'reservation', 'recherche', 'backoffice', 'out');
$_reglesAdmin = array('articles', 'panier', 'profil', 'backoffice');

$navAdmin = array('articles', 'users', 'commandes');

//$navFooter = array('mentions', 'cgv', 'plan', 'newsletter', 'contact' );
$navFooter = array('mentions', 'cgv', 'contact' );
// page par defaut
$navDefaut = 'home';