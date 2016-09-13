<?php
/*function siteHeader($_linkCss)
{
    $_link = '';
    foreach($_linkCss as $link) {
        $_link .= '
    <link href="' . $link . '" rel="stylesheet">';
    }
    return $_link;
}*/

/*function siteHeaderJS($_linkJS)
{
    $_link = '';
    foreach($_linkJS as $link) {
        $_link .= '
    <script src="' . $link . '"></script>';
    }
    return $_link;
}*/

/* function nav($_menu = '')
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
} */


# Fonction listeMenu()
# Valide le menu de navigation
# [@_pages] => array de navigation
# RETURN Boolean
/*function listeMenu()
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
}*/

# Fonction liste_nav()
# affiche les informations en forme de liste du menu de navigation
# $actif => mode de connexion
# [@nav] => string action
# [@_pages] => array('nav'...)
# [@titre] => string titre de la page
# RETURN string liste <li>...</li>
/*function liste_nav($liste='')
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
}*/

/*function footer()
{
    $info = liste_nav('navFooter');
    $info['version'] = file_get_contents(CONF . 'version.txt');
    return $info;
}*/

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

