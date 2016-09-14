<?php
/**
 * Created by ceidodev.com
 * User: Carlos PAZ DUPRIEZ
 * Date: 31/05/2016
 * Time: 14:03
 */
/*
function debug($var, $libelle = 'debug' )
{
    if(DEBUG){
        $_ENV['debug'][$libelle][] = $var;
    }
}

function getDebug()
{
    if(isset($_ENV['debug'])){
        debug(get_required_files(), 'REQUIERED');
        echo '<pre>';
        foreach($_ENV['debug'] as $key=>$info){
            echo "<br>$key<br>";
            var_dump($info);
        }
        echo '</pre>';
    }
}
*/

function debugParam()
{
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
            'LIB' => LIB,
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

