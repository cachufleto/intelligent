<?php
/* résoudre le problême des alias */
//déclaration de constante pour la racine serveur

define("REPADMIN", 'BacOff/');
//echo  $a, "REPADMIN ", REPADMIN;
define("RACINE_SERVER", str_replace('\\', '/', dirname(__DIR__) .'/'));
//echo  $a, "RACINE_SERVER ", RACINE_SERVER;
define("RACINE_SITE", 'Public/');
//echo  $a, "RACINE_SITE ", RACINE_SITE;
define("APP", RACINE_SERVER);
//echo  $a, "APP ", APP;
define("ADM", APP . REPADMIN);
//echo  $a, "ADM ", ADM;
define("INC", APP . 'inc/');
//echo  $a, "INC ", INC;
define("FUNC", APP . 'func/');
//echo  $a, "FUNC ", FUNC;
define("CONF", APP . 'conf/');
//echo  $a, "CONF ", CONF;
define("CONTROLEUR", APP . 'App/Controleur/');
//echo  $a, "CONTROLEUR ", CONTROLEUR;
define("PARAM", CONTROLEUR . 'param/');
//echo  $a, "PARAM ", PARAM;
define("MODEL", APP . 'App/Model/');
//echo  $a, "MODEL ", MODEL;
define("VUE", APP . 'App/Vue/');
//echo  $a, "VUE ", VUE;
$link = explode('?', $_SERVER['REQUEST_URI']);
define("LINK", 'http://' . str_replace('//', '/', $_SERVER['SERVER_NAME'] . str_replace('\\', '', dirname($link[0].'#')) .'/'));
//echo  $a, "LINK ", LINK;
define("LINKADMIN", LINK);
//echo  $a, "LINKADMIN ", LINKADMIN;

// Constantes upload images
define('TARGET', APP . 'Public/photo/');    // Repertoire cible
define('MAX_SIZE', 100000000);    // Taille max en octets du fichier
define('WIDTH_MAX', 10240000);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 8500000);    // Hauteur max de l'image en pixels

define('PRIX', 5.5);
define('TVA', 0.2);

//phpinfo();

/********************************************/

// activation du debug en fonction de l'environnement
$debug = ( preg_match('/localhost$/',$_SERVER["HTTP_HOST"]))? true : false;
define("DEBUG", $debug);

if(!file_exists(APP . 'Public/index.php')) exit("<br>" . APP . 'Public/index.php');
