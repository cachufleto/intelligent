<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 03/03/2016
 * Time: 10:06
 *
 * la spécialisation des logiques
 * Controleur.1 <- Model.1
 * Controleur.1 <- view.1
 * Controleur.2 <- Model.2 <- Model.1
 * Controleur.2 <- view.2 <- view.1
 * Controleur.3 <- view.3
 * Controleur.3 <- Controleur.2 [<- Model.2 <- Model.1]
 *
 * ------- ROUTER ----------------
 *
 * Le routeur
 * utilise les information de la rute -> http
 * pour déterminer le Controleur
 * pour déterminer l'action
 *
 * -------- SUPER MODEL ----------
 * partage des information configuration, paramettres, environnement
 * partage des methodes acces BDD, valeurs des configuration ...
 *
 * SUPER CONTROLER <- SUPER MODEL
 * SUPER CONTROLER <- SUPER MODEL <- fichier conf
 * SUPER CONTROLER <- SUPER VIEW <- layaout
 * SUPER CONTROLER <- fichier router
 *
 * temporisation
 * ob_start
 * .....
 * $_V <- ob_get_content
 * ob_emptide
 * echo $_V
 */
$route = array();
/****** SITE ******/
$route['cgv']['Controleur'] = 'site';
$route['cgv']['action'] = 'cgv';

$route['contact']['Controleur'] = 'site';
$route['contact']['action'] = 'contact';

$route['erreur404']['Controleur'] = 'site';
$route['erreur404']['action'] = 'erreur404';

$route['home']['Controleur'] = 'site';
$route['home']['action'] = 'home';

$route['mentions']['Controleur'] = 'site';
$route['mentions']['action'] = 'mentions';

$route['newsletter']['Controleur'] = 'site';
$route['newsletter']['action'] = 'newsletter';

$route['plan']['Controleur'] = 'site';
$route['plan']['action'] = 'plan';

$route['session']['Controleur'] = 'site';
$route['session']['action'] = 'session';

/****** USERS ******/
$route['changermotpasse']['Controleur'] = 'users';
$route['changermotpasse']['action'] = 'changermotpasse';

$route['connection']['Controleur'] = 'users';
$route['connection']['action'] = 'connection';

$route['inscription']['Controleur'] = 'users';
$route['inscription']['action'] = 'inscription';

$route['expiration']['Controleur'] = 'users';
$route['expiration']['action'] = 'expiration';

$route['validerChangementMDP']['Controleur'] = 'users';
$route['validerChangementMDP']['action'] = 'validerChangementMDP';

$route['profil']['Controleur'] = 'users';
$route['profil']['action'] = 'profil';

$route['validerInscription']['Controleur'] = 'users';
$route['validerInscription']['action'] = 'validerInscription';

$route['identifians']['Controleur'] = 'users';
$route['identifians']['action'] = 'identifians';

/****** SALLES ******/
$route['ficheSalles']['Controleur'] = 'salles';
$route['ficheSalles']['action'] = (utilisateurAdmin() && isset($_SESSION['BO']))? 'backOff_ficheSalles' : 'ficheSalles';

$route['recherche']['Controleur'] = 'salles';
$route['recherche']['action'] = 'recherche';

$route['reservation']['Controleur'] = 'salles';
$route['reservation']['action'] = 'reservation';

$route['salles']['Controleur'] = 'salles';
$route['salles']['action'] = (utilisateurAdmin() && isset($_SESSION['BO']))? 'backOff_salles' : 'salles';

/****** ADMINISTRATION ******/

if (utilisateurConnecte()) {
    $route['validerCommande']['Controleur'] = 'commande';
    $route['validerCommande']['action'] = 'validerCommande';

    $route['validerFacture']['Controleur'] = 'commande';
    $route['validerFacture']['action'] = 'validerFacture';

    $route['commandes']['Controleur'] = 'commande';
    $route['commandes']['action'] = 'commandes';
}

if (utilisateurAdmin() && isset($_SESSION['BO'])) {
    /****** SITE ******/
    $route['backoffice']['Controleur'] = 'site';
    $route['backoffice']['action'] = 'backoffice';

    /****** USERS ******/
    $route['users']['Controleur'] = 'users';
    $route['users']['action'] = 'backOff_users';

    $route['editerSalles']['Controleur'] = 'salles';
    $route['editerSalles']['action'] = 'backOff_editerSalles';

    /****** SALLES ******/
    $route['produits']['Controleur'] = 'salles';
    $route['produits']['action'] = 'backOff_gestionProduits';

    /****** COMMANDES ******/
    $route['validerCommande']['action'] = 'backOff_commande';
    $route['validerFacture']['action'] = 'backOff_facture';
    $route['commandes']['action'] = 'backOff_gestionCommandes';

}
