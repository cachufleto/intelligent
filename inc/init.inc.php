<?php
//include CONF . 'connection.php';

//require CONF . 'init.php';

//require FUNC . 'com.func.php';
require FUNC . 'site.func.php';

/************************************************************
 * Creation de la session
 *************************************************************/
// debug($_SESSION, 'SESSION');
// chargement de la langue

// gestion de session
include INC . 'install.inc.php';

// options du menu de navigation
include_once CONF . 'nav.php';

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


