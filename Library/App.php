<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 03/09/2016
 * Time: 23:50
 */

namespace App;


class App extends Bdd
{
    var $routeur = [];
    var $page = 'home';
    var $session = 'site';
    var $controleur = 'site\site';
    var $action = 'home';
    var $class = CONTROLEUR . 'site.php';

    public function __construct()
    {
        ## Ouverture des sessions
        parent::__construct();
        session_start();
        $this->SetSession();
        $this->setLang();
        $this->setCookieLang();
        $this->setBackoffice();
        $this->destroy();
        $this->controldate();
        $this->routeur = file_contents_route();
        $this->setPage();

        $this->_trad = setTrad();
        $this->iniTarget();
        //$this->setSessionMoteurRecherche();
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
        // valeur par default
        $_SESSION['lang'] = (isset($_SESSION['lang']))? $_SESSION['lang'] : 'fr';

        if(!isset($_SESSION['date'])){
            // la reservation est à partir du jour suivant
            $time = (time() + 2*(60*60*24));
            $_SESSION['date'] = date('Y-m-d',$time);
            $_SESSION['dateTimeOk'] = true;
        }

        if(!isset($_SESSION['numpersonne'])){
            // la reservation est à partir du jour suivant
            $_SESSION['numpersonne'] = '';
        }

        if(isset($_POST['numpersonne'])){
            // contrôl de la date inferieur à la date du jour
            $_SESSION['numpersonne'] = $_POST['numpersonne'];
        }

    }

    protected function setLang()
    {
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
            $this->page = (isset($_GET['nav']) AND !empty($_GET['nav']))? $_GET['nav'] : 'home';
            // cas spécifique
            $this->page = (!utilisateurAdmin() && $this->page=='users')? 'home' : $this->page;
            // REGLE D'orientation des pages actif et out ver connection
            if('actif' == $this->page || 'out' == $this->page) {
                $this->page = 'connection';
            }
            $this->setControleur();
        }
    }

    protected function setControleur()
    {
        if(array_key_exists($this->page, $this->routeur)){
            if(file_exists(CONTROLEUR . $this->routeur[$this->page]['Controleur'] . '.php')){
                $controleur = $this->routeur[$this->page]['Controleur'];
                $this->class = CONTROLEUR . $controleur . '.php';
                $this->session = $controleur;
                $this->controleur = $controleur.'\\'.$controleur;
                $this->action = $this->routeur[$this->page]['action'];
            } else {
                $this->page = 'erreur404';
                $this->action = 'erreur404';
            }
        } else {
            $this->page = 'erreur404';
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
}