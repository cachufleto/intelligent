<?php
function siteHeader($_linkCss)
{
    $_link = '';
    foreach($_linkCss as $link) {
        $_link .= '
    <link href="' . $link . '" rel="stylesheet">';
    }
    return $_link;
}

function siteHeaderJS($_linkJS)
{
    $_link = '';
    foreach($_linkJS as $link) {
        $_link .= '
    <script src="' . $link . '"></script>';
    }
    return $_link;
}

function nav($_menu = '')
{
    $_trad = setTrad();
    listeMenu();
    $_link = str_replace('&lang=fr', '', $_SERVER["QUERY_STRING"]);
    $_link = str_replace('&lang=es', '', $_link);

    $menu = liste_nav($_menu);
    $class = $menu['class'];
    $li = $menu['menu'];

    if (isset($_SESSION['user'])) {
        $li .= "<li class='" . $class . "'><a href='' class='admin'>[";
        $li .= ($_SESSION['user']['statut'] != 'MEM') ? $_trad['value'][$_SESSION['user']['statut']] . "::" : "";
        $li .= $_SESSION['user']['user'] . ']</a></li>';
    }

    $langfr = ($_SESSION['lang'] == 'fr')? 'active' : '';
    $langes = ($_SESSION['lang'] == 'es')? 'active' : '';
    $li .= "<li class='drapeau'>" .
            (($_SESSION['lang'] == 'es') ?
                "<a class='$langfr' href='" . LINK . "?$_link&lang=fr'><img width='25px' src='img/drapeaux_fr.png'></a>" :
                "<a class='$langes' href='" . LINK . "?$_link&lang=es'><img width='25px' src='img/drapeaux_es.png'></a>") .
            "</li>";

    return $li;
}


# Fonction listeMenu()
# Valide le menu de navigation
# [@_pages] => array de navigation
# RETURN Boolean
function listeMenu()
{

    if(!utilisateurAdmin()) return;

    global $_pages, $_reglesAll, $_reglesMembre, $_reglesAdmin, $navAdmin, $navFooter;

    $_trad = setTrad();
    // control du menu principal

    foreach($_reglesAdmin as $key)
        if(!isset($_pages[$key]))
            exit($_trad['laRubrique'] . $key . $_trad['pasDansMenuAdmin']);

    foreach($_reglesMembre as $key)
        if(!isset($_pages[$key]))
            exit($_trad['laRubrique'] . $key . $_trad['pasDansMenuMembre']);

    foreach($_reglesAll as $key)
        if(!isset($_pages[$key]))
            exit($_trad['laRubrique'] . $key . $_trad['pasDansMenu']);

    // control du footer
    foreach($navFooter as $key)
        if(!isset($_pages[$key]))
            exit($_trad['laRubrique'] . $key . $_trad['pasDansMenuFooter']);

    // control du menu administrateur
    foreach($navAdmin as $key)
        if(!isset($_pages[$key]))
            exit($_trad['laRubrique'] . $key . $_trad['pasDansMenuAdmin']);

    return;
}

# Fonction liste_nav()
# affiche les informations en forme de liste du menu de navigation
# $actif => mode de connexion
# [@nav] => string action
# [@_pages] => array('nav'...)
# [@titre] => string titre de la page
# RETURN string liste <li>...</li>
function liste_nav($liste='')
{

    global $nav, $_pages, $navFooter, $navAdmin, $_reglesAdmin, $_reglesMembre, $_reglesAll;

    $_trad = setTrad();


    if(empty($liste)){

        $_liste = (utilisateurAdmin())?
            $_reglesAdmin :
            ((utilisateurConnecte())?
                $_reglesMembre :
                $_reglesAll);

    } else {
        // generation de la liste de nav
        $_liste = ${$liste};
    }

    // generation de la liste de nav
    $col = count($_liste)+1;
    $menu = '';
    foreach ($_liste as $item){
        $info = $_pages[$item];
        $active = ($item == $nav)? 'active' : '';
        $active = ($item == $nav || ($item == 'actif' && $nav == 'connection'))? 'active' : $active;
        $class = (isset($_pages[$item]['class']))? $_pages[$item]['class'] : 'menu';
        $menu .= '
		<li class="' . $active .' '. $class.' col-'.$col.'">
			<a href="'. LINK .'?nav='. $item .'">' . $_trad['nav'][$item] . '</a>
		</li>';
    }

    return array('menu'=>$menu, 'class'=>$class . ' col-'.$col);
}

function footer()
{
    $info = liste_nav('navFooter');
    $info['version'] = file_get_contents(CONF . 'version.txt');
    return $info;
}

/**
 * Chargement des info supplementaires
 */
function debugPhpInfo()
{
    if (isset($_GET['info']) && $_GET['info'] == 'PHP') {
        phpinfo();
    }
}

/**
 *
 */
function debugTestMail()
{
    if (isset($_GET['info']) && $_GET['info'] == 'mail') {
        echo "TEST d'envoi de mail ver " .WEBMAIL;
        testmail();
    }
}

/**
 *
 */
function debugCost()
{
    if (isset($_GET['info']) && $_GET['info'] == 'crypter') {
        cost();
    }
}

/**
 * Function pour l'option de hashage
 */
function cost()
{
// test ooption de hashage pour les mot de passe
    $timeTarget = 0.05; // 50 millisecondes

    $cost = 8;
    do {
        $cost++;
        $start = microtime(true);
        password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
        $end = microtime(true);
    } while (($end - $start) < $timeTarget);

    echo "Valeur de 'cost' la plus appropriée : " . $cost . "\n";
}

function testmail()
{
    $to = WEBMAIL;
    $subject = 'le sujet';
    $message = "Bonjour!". "\r\n" . "Test envoi de mail depuis " . $_SERVER['HTTP_HOST'];
    $headers = 'From: ' . SITEMAIL . "\r\n" .
        'Reply-To: webmaster@' . $_SERVER['HTTP_HOST'] . '.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)){
        echo " -------> Ok ";
    } else {
        echo " -------> ERROR SEND MAIL";
    }

}

function debugParam()
{
    global $route;
    _debug(get_included_files(), 'FILES INCLUDES');
    _debug($_SESSION, 'SESSION');
    _debug($_POST, 'POST');
    _debug($_GET, 'GET');
    _debug($_FILES, '_FILES');
    _debug($_COOKIE, '_COOKIE');
    _debug($_SERVER['CONTEXT_PREFIX'], 'CONTEXT_PREFIX');
    _debug(
        array(
            'REPADMIN' => REPADMIN,
            'RACINE_SERVER' => RACINE_SERVER,
            'RACINE_SITE' => RACINE_SITE,
            'APP' => APP,
            'ADM' => ADM,
            'INC' => INC,
            'FUNC' => FUNC,
            'CONF' => CONF,
            'CONTROLEUR' => CONTROLEUR,
            'PARAM' => PARAM,
            'MODEL' => MODEL,
            'VUE' => VUE,
            'LINK' => LINK,
            'LINKADMIN' => LINKADMIN,
            'TARGET' => TARGET,
            'MAX_SIZE' => MAX_SIZE,
            'WIDTH_MAX' => WIDTH_MAX,
            'HEIGHT_MAX' => HEIGHT_MAX,
            'DEBUG' => DEBUG),
        'CONSTANTES');
    _debug($_SERVER, 'SERVEUR');
    _debug($route, 'Route');

}

# Fonction debug()
# affiche les informations passes dans l'argument $var
# $var => string, array, object
# $mode => defaut = 1
# RETURN NULL;
function debug($_debug, $mode=0)
{

    //global $_debug;

    echo '
	<div  id=\'debug\'>
	<hr>
	DEBUG -----------
	<hr>
	<div class="col-md-12">';

    if($mode === 1)
    {
        echo '<pre>'; var_dump($_debug); echo '</pre>';
    } else {
        echo '<pre>'; print_r($_debug); echo '</pre>';
    }

    echo '</div>';
    echo '</div>';

}

function _debug($var, $label)
{

    global $_debug;

    $_debug[][$label] = $var;

    return;
}

function dernieresOffres($salle)
{
    $_trad = setTrad();

    $offre = '
	<div class="offre">
        <a href="'. LINK . '?nav=ficheSalles&id=' . $salle['id_salle'] . '">
        <figure>
          <img class="ingOffre" src="' . imageExiste($salle['photo']) . '" alt="" />
            <figcaption>
                <span class="titre">' . $salle['titre'] . '</span> :: ' .
                $salle['capacite'] . $_trad['personnes'] . ' / ' .
                $_trad['value'][$salle['categorie']] . ' :: ' .
                $salle['ville'] . ' (' . $salle['pays'] .')
                </figcaption>

        </figure>
        </a>
	</div>
	';

    return $offre;
}

function session()
{
    ## Ouverture des sessions
    session_start();
    // valeur par default
    $_SESSION['lang'] = (isset($_SESSION['lang']))? $_SESSION['lang'] : 'fr';
    // recuperation du cookis lang
    $_SESSION['lang'] = (isset($_COOKIE['Intelligent']))? $_COOKIE['Intelligent']['lang'] : $_SESSION['lang'];
    // changement de lang par le user
    $_SESSION['lang'] = (isset($_GET['lang']) && ($_GET['lang']=='fr' XOR $_GET['lang']=='es'))? $_GET['lang'] : $_SESSION['lang'];

    if (utilisateurAdmin()){
        if (isset($_GET['nav']) && $_GET['nav'] == 'backoffice') {
            $_SESSION['BO'] = TRUE;
        } else if (isset($_GET['nav']) && $_GET['nav'] == 'home') {
            $_SESSION['BO'] = FALSE;
        }
    }

    // définition des cookis
    setcookie( 'Intelligent[lang]' , $_SESSION['lang'], time()+360000 );
    // Déconnection de l'utilisateur par tentative d'intrusion
    // comportement de déconnexion sur le site
    if (isset($_GET['nav']) && $_GET['nav'] == 'out' && isset($_SESSION['user'])) {
        // destruction de la navigation
        $lng = $_SESSION['lang'];
        unset($_GET['nav']);
        // destruction de la session
        unset($_SESSION['user']);

        session_destroy();
        // on relance la session avec le choix de la langue
        session_start();
        $_SESSION['lang'] = $lng;

    } elseif (isset($_GET['nav']) && $_GET['nav'] == 'out' && !isset($_SESSION['user'])) {

        // destruction de la navigation
        unset($_GET['nav']);

    } elseif (isset($_GET['nav']) && $_GET['nav'] == 'actif' && isset($_SESSION['user'])) {

        // control pour eviter d'afficher le formulaire de connexion
        // si l'utilisateur tente de le faire
        unset($_GET['nav']);

    }

    if(!isset($_SESSION['date'])){
        // la reservation est à partir du jour suivant
        $time = (time() + 2*(60*60*24));
        $_SESSION['date'] = date('Y-m-d',$time);
        $_SESSION['dateTimeOk'] = true;
    }

    controldate();

    if(!isset($_SESSION['numpersonne'])){
        // la reservation est à partir du jour suivant
        $_SESSION['numpersonne'] = '';
    }

    if(isset($_POST['numpersonne'])){
        // contrôl de la date inferieur à la date du jour
        $_SESSION['numpersonne'] = $_POST['numpersonne'];
    }


}
