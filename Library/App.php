<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 03/09/2016
 * Time: 23:50
 */

namespace App;
include_once LIB . 'menu.php';
use App\menu;

class App extends Bdd
{
    var $route = [];
    var $_pages = [];
    var $navDefaut = '';
    var $nav = '';
    var $menu = '';
    var $_linkJs = [];
    var $_linkCss = [];
/**********************************/
    var $page = 'home';
    var $session = 'site';
    var $controleur = 'site\site';
    var $action = 'home';
    var $class = CONTROLEUR . 'site.php';

    public function __construct()
    {
        // initiation de la session
        $this->destroy();
        $this->SetSession();
        $this->setLang();
        $this->setCookieLang();
        $this->setBackoffice();

        $this->SetDate();
        $this->controldate();

        $this->file_contents_route();
        $this->file_contents_nav();

        $this->setLinks();
        $this->setNav();
        $this->menu = new menu($this->nav);
        //$this->setPage();
        $this->setControleur();

        //$this->_trad
        $this->iniTarget();
        //$this->setSessionMoteurRecherche();
        parent::__construct();
    }

    protected function setLinks()
    {
        $this->_linkCss[] = LINK . 'css/style.css';
        $this->_linkCss[] = LINK . 'css/tablette.css';
        $this->_linkCss[] = LINK . 'css/smart.css';

        if (isSuperAdmin()) {
            // ajout du css admin
            $this->_linkCss[] = LINK . 'css/admin.css';
        }

        $this->_linkJs[] = LINK . 'js/script.js';
    }

    public function siteHeader()
    {
        $_link = '';
        foreach($this->_linkCss as $key=>$link) {
            $_link .= '
    <link href="' . $link . '" rel="stylesheet">';
        }
        return $_link;
    }

    public function siteHeaderJS()
    {
        $_link = '';
        foreach($this->_linkJS as $key=>$link) {
            $_link .= '
    <script src="' . $link . '"></script>';
        }
        return $_link;
    }

    protected function iniTarget()
    {
        /************************************************************
         * Creation du repertoire cible si inexistant
         *************************************************************/
        if( !is_dir(TARGET) ) {
            if( !mkdir(TARGET, 0755) ) {
                exit($this->_trad['erreur']['leRepertoireNePeutEtreCree']);
            }
        }
    }

    protected function SetSession()
    {
        if(!isset($_SESSION['numpersonne'])){
            // la reservation est à partir du jour suivant
            $_SESSION['numpersonne'] = '';
        }

        if(isset($_POST['numpersonne'])){
            // contrôl de la date inferieur à la date du jour
            $_SESSION['numpersonne'] = $_POST['numpersonne'];
        }

    }

    protected function SetDate()
    {
        if(!isset($_SESSION['date'])){
            // la reservation est à partir du jour suivant
            $time = (time() + 2*(60*60*24));
            $_SESSION['date'] = date('Y-m-d',$time);
            $_SESSION['dateTimeOk'] = true;
        }
    }

    protected function setLang()
    {
        // valeur par default
        $_SESSION['lang'] = (isset($_SESSION['lang']))? $_SESSION['lang'] : 'fr';
        // recuperation du cookis lang
        $_SESSION['lang'] = (isset($_COOKIE['Intelligent']))?
            $_COOKIE['Intelligent']['lang'] : $_SESSION['lang'];
        // changement de lang par le user
        $_SESSION['lang'] = (isset($_GET['lang']) && ($_GET['lang']=='fr' XOR $_GET['lang']=='es'))?
            $_GET['lang'] : $_SESSION['lang'];
    }

    protected function setBackoffice()
    {
        if (utilisateurAdmin()){
            if (isset($_GET['nav']) && $_GET['nav'] == 'backoffice') {
                $_SESSION['BO'] = TRUE;
            } else if (isset($_GET['nav']) && $_GET['nav'] == 'home') {
                $_SESSION['BO'] = FALSE;
            }
        }
    }

    protected function setCookieLang()
    {
        // définition des cookis
        setcookie( 'Intelligent[lang]' , $_SESSION['lang'], time()+360000 );
    }

    protected function controldate()
    {
        //$control = $_SESSION['date'];
        $__date = isset($_POST['date'])? $_POST['date'] : (isset($_GET['reservee'])? $_GET['reservee'] : false );
        if($__date){
            // contrôl de la date inferieur à la date du jour
            $dateMin = time()+(60*60*24);
            $now = mktime(0,0,0,date('m', $dateMin),date('d', $dateMin),date('Y', $dateMin));
            //$control = date('Y-m-d', $dateMin);
            if(preg_match('#^20(1|2)[0-9]-(0|1)[0-9]-[0-3][0-9]#' , $__date)){
                $date = explode('-', $__date);
                _debug($date, '$date');
                if(checkdate($date[1],$date[2],$date[0])){
                    $timePost = mktime(0,0,0,$date[1],$date[2],$date[0]);
                    if(isset($_POST['date']) AND $timePost > $now){
                        $_SESSION['date'] =  $__date;
                    } else {
                        $_SESSION['date'] = $__date;
                    }
                    $_SESSION['dateTimeOk'] = ($timePost > $now)? true : false;
                }
            }
        }
        //return $control;
    }

    protected function destroy()
    {
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
            header('location:?page=accueil');
        } elseif (isset($_GET['nav']) && $_GET['nav'] == 'out' && !isset($_SESSION['user'])) {
            // destruction de la navigation
            unset($_GET['nav']);
        } elseif (isset($_GET['nav']) && $_GET['nav'] == 'actif' && isset($_SESSION['user'])) {
            // control pour eviter d'afficher le formulaire de connexion
            // si l'utilisateur tente de le faire
            unset($_GET['nav']);
        }
    }

    protected function setPage()
    {
        if(!empty($_GET)){
            // page de navigation
            $this->page = (isset($_GET['nav']) AND !empty($_GET['nav']))? $_GET['nav'] : $this->page;
            // cas spécifique
            $this->page = (!utilisateurAdmin() && $this->page=='users')? 'home' : $this->page;
            // REGLE D'orientation des pages actif et out ver connection
            if('actif' == $this->page || 'out' == $this->page) {
                $this->page = 'connection';
            }

        }
    }

    protected function setNav()
    {
        // page de navigation
        $this->nav = (isset ($_GET['nav']) && !empty($_GET['nav']))? $_GET['nav'] : $this->navDefaut;
        $this->nav = (array_key_exists($this->nav, $this->_pages))? $this->nav : 'erreur404';

        // REGLE D'orientation des pages actif et out ver connection
        if('actif' == $this->nav || 'out' == $this->nav) {
            $this->nav = 'connection';
        }

        // cas spécifique
        $this->nav = (!utilisateurAdmin() && $this->nav=='users')? $this->navDefaut : $this->nav;
        // erreur 404
        $this->nav = array_key_exists($this->nav, $this->route)? $this->nav : 'erreur404';
    }

    public function getControleur()
    {
        include_once $this->class;
        $app = new $this->controleur();
        if (method_exists($app, $this->action)){
            return $app;
        } else {
            $controleur = $this->route['erreur404']['Controleur'];
            include_once CONTROLEUR . $controleur;
            $this->action = $this->route['erreur404']['action'];
            $controleur = $controleur.'\\'.$controleur;
            return new $controleur();
        }
    }

    protected function setControleur()
    {
        if(file_exists(CONTROLEUR . $this->route[$this->nav]['Controleur'] . '.php')){
            $controleur = $this->route[$this->nav]['Controleur'];
            $this->class = CONTROLEUR . $controleur . '.php';
            $this->session = $controleur;
            $this->controleur = $controleur.'\\'.$controleur;
            $this->action = $this->route[$this->nav]['action'];
        } else {
            $this->nav = 'erreur404';
            $this->action = 'erreur404';
        }
    }

    /*protected function setSession()
    {
        if(!empty($this->session)){
            if(!isset($_SESSION[$this->session])){
                $_SESSION[$this->session] = [
                    'display' => 0,
                    'b' => NUM,
                    'p' => false,
                    'produit'=> "",
                    'a' => 0,
                    'zapper' => '0'
                ];
            }

            if(!empty($_POST) AND isset($_POST['nombre']) AND $_POST['nombre']>0){
                $_SESSION[$this->session]['display'] = intval($_SESSION[$this->session]['a'] / $_POST['nombre']);
                $_SESSION[$this->session]['b'] = $_POST['nombre'];
                $_SESSION[$this->session]['a'] = $_SESSION[$this->session]['b'] * $_SESSION[$this->session]['display'];
            } else if(!empty($_GET)){
                $_SESSION[$this->session]['display'] = isset($_GET['display'])? ( ($_GET['display']>=0)? $_GET['display'] : 0 ) : 0;
                $_SESSION[$this->session]['p'] = isset($_GET['produit'])? true : false;
                if($_SESSION[$this->session]['p']){
                    if(isset($_GET['produit']) AND $_GET['produit'] != $_SESSION[$this->session]['produit']){
                        $_SESSION[$this->session]['display'] = 0;
                    }
                } else {
                    if(!empty($_SESSION[$this->session]['produit'])){
                        $_SESSION[$this->session]['display'] = 0;
                    }
                }
                $_SESSION[$this->session]['produit'] = isset($_GET['produit'])?
                    $_GET['produit'] : $_SESSION[$this->session]['produit'];
                $_SESSION[$this->session]['a'] = $_SESSION[$this->session]['b'] * $_SESSION[$this->session]['display'];
                $_SESSION[$this->session]['zapper'] = ($_SESSION[$this->session]['p'])? (
                ($_SESSION[$this->session]['produit'] == 'ok')? 2 : (
                ($_SESSION[$this->session]['produit'] == 'ko')? 1 : 0)
                ) : 0;
            }
        }
        $_SESSION['actif'] = $this->session;
    }

    function setSessionMoteurRecherche()
    {
        if(isset($_POST['chercher'])){
            $_SESSION['recherche'][$this->session] = $_POST;
        } else if (!isset($_SESSION['recherche'][$this->session])){
            $_SESSION['recherche'][$this->session] = [];
        }
    }*/

    /*
     * RETURN array route
     */
    public function file_contents_route()
    {
        include ( CONF . 'route.php');
        $this->route = $route;
    }

    /*
     * RETURN info Nav
     */
    public function file_contents_nav()
    {
        include ( CONF . 'nav.php');
        $this->_pages = $_pages;
        $this->navDefaut = $navDefaut;
    }

}