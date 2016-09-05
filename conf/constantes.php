<?php
/* résoudre le problême des alias */
//déclaration de constante pour la racine serveur

define("REPADMIN", 'BacOff' . DIRECTORY_SEPARATOR );
//echo  $a, "REPADMIN ", REPADMIN;
define("RACINE_SERVER", str_replace('\\', DIRECTORY_SEPARATOR , dirname(__DIR__) . DIRECTORY_SEPARATOR ));
//echo  $a, "RACINE_SERVER ", RACINE_SERVER;
define("RACINE_SITE", 'Public' . DIRECTORY_SEPARATOR );
//echo  $a, "RACINE_SITE ", RACINE_SITE;
define("APP", RACINE_SERVER);
//echo  $a, "APP ", APP;
define("ADM", APP . REPADMIN);
//echo  $a, "ADM ", ADM;
define("INC", APP . 'inc' . DIRECTORY_SEPARATOR );
//echo  $a, "INC ", INC;
define("LIB", APP . 'Library' . DIRECTORY_SEPARATOR );
//echo  $a, "CLASS ", CLASS;
define("FUNC", APP . 'func' . DIRECTORY_SEPARATOR);
//echo  $a, "FUNC ", FUNC;
define("CONF", APP . 'conf' . DIRECTORY_SEPARATOR);
//echo  $a, "CONF ", CONF;
define("CONTROLEUR", APP . 'App' . DIRECTORY_SEPARATOR . 'Controleur' . DIRECTORY_SEPARATOR );
//echo  $a, "CONTROLEUR ", CONTROLEUR;
define("PARAM", CONTROLEUR . 'param' . DIRECTORY_SEPARATOR );
//echo  $a, "PARAM ", PARAM;
define("MODEL", APP . 'App' . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR );
//echo  $a, "MODEL ", MODEL;
define("VUE", APP . 'App' . DIRECTORY_SEPARATOR . 'Vue' . DIRECTORY_SEPARATOR );
//echo  $a, "VUE ", VUE;
$link = explode('?', $_SERVER['REQUEST_URI']);
define("LINK", 'http://' . str_replace('//', '/', $_SERVER['SERVER_NAME'] . str_replace('\\', '', dirname($link[0].'#')) .'/'));
//echo  $a, "LINK ", LINK;
define("LINKADMIN", LINK);
//echo  $a, "LINKADMIN ", LINKADMIN;

// Constantes upload images
define('TARGET', APP . 'Public' . DIRECTORY_SEPARATOR . 'photo' . DIRECTORY_SEPARATOR );    // Repertoire cible
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

if(!file_exists(APP . 'Public' . DIRECTORY_SEPARATOR . 'index.php')) exit("<br>" . APP . 'Public/index.php');
