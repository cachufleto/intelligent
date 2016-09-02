<?php
include_once MODEL . 'site.php';
include_once FUNC . 'site.func.php';

function home()
{

    $nav = 'home';
    $_trad = setTrad();

    $salles = selectSallesActive();

    $dernieresOffres = '<div id="dernieresOffres">';
    while($salle = $salles->fetch_assoc()){
        $dernieresOffres .= dernieresOffres($salle);
    }
    $dernieresOffres .= '</div>';

    include VUE . 'site/home.tpl.php';
}

function recupNav()
{
    if($arg = basename(str_replace('?', '', $_SERVER['HTTP_REFERER']))){
        if(preg_match('#&#', $_SERVER['HTTP_REFERER'])){
            $_arg = $nav = explode('&', $arg);
            $nav = explode('=', $_arg[0]);
            return $nav[1];
        } else {
            $nav = explode('=', $arg);
            return $nav[1];
        }
    }
    return false;
}

function backoffice()
{
    $nav = 'backoffice';
    $_trad = setTrad();
    if($nav=recupNav()){
        header('location:' . basename($_SERVER['HTTP_REFERER']));
    }
    // phpinfo();

    $activite = (!empty($_POST))? '<textarea name="notreAtivite"></textarea>' : 'Activité';
    $dernieresOffres = (!empty($_POST))? '<textarea name="notreAtivite"></textarea>' :  'Derniéres Offres';

    include VUE . 'site/backoffice.tpl.php';

}

function contact()
{
    $_trad = setTrad();
    $listConctact = array();

    $membres = userSelectContactAll();

    if ($membres->num_rows > 0) {
        while ($membre = $membres->fetch_assoc()) {
            $listConctact[] = $membre; //
        }
    }

    include VUE . 'site/contact.tpl.php';
}

function mentions()
{
    $nav = 'mentions';
    include VUE . 'site/static.tpl.php';
}

function cgv()
{
    $nav = 'cgv';
    include VUE . 'site/static.tpl.php';
}

function erreur404($nav)
{
    $_trad = setTrad();

    $msg = ($nav=='erreur404')?
        $_trad['erreur']['erreur404'] :
        $_trad['enConstruccion'];

    include VUE . 'site/erreur404.tpl.php';
}


