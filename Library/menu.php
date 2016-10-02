<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 13/09/2016
 * Time: 13:09
 */

namespace App;


class menu
{
    var $_trad = [];
    var $_pages = [];
    var $_reglesAll = [];
    var $_reglesMembre = [];
    var $_reglesAdmin = [];
    var $navAdmin = [];
    var $navFooter = [];
    var $navDefaut = '';
    var $nav = '';

    public function __construct($nav = 'erreur404')
    {
        $this->_nav = $nav;
        $this->_trad = setTrad();
        $this->listeMenu();
        $this->file_contents_nav();
    }

    # Fonction listeMenu()
    # Valide le menu de navigation
    # [@_pages] => array de navigation
    # RETURN Boolean
    protected function listeMenu()
    {

        if(!utilisateurAdmin()) return;

        foreach($this->_reglesAdmin as $key){
            if(!isset($this->_pages[$key])){
                exit($this->_trad['laRubrique'] . $key . $this->_trad['pasDansMenuAdmin']);
            }
        }

        foreach($this->_reglesMembre as $key){
            if(!isset($this->_pages[$key])){
                exit($this->_trad['laRubrique'] . $key . $this->_trad['pasDansMenuMembre']);
            }
        }

        foreach($this->_reglesAll as $key){
            if(!isset($this->_pages[$key])){
                exit($this->_trad['laRubrique'] . $key . $this->_trad['pasDansMenu']);
            }
        }

        // control du footer
        foreach($this->navFooter as $key){
            if(!isset($this->_pages[$key])){
                exit($this->_trad['laRubrique'] . $key . $this->_trad['pasDansMenuFooter']);
            }
        }

        // control du menu administrateur
        foreach($this->navAdmin as $key){
            if(!isset($this->_pages[$key])){
                exit($this->_trad['laRubrique'] . $key . $this->_trad['pasDansMenuAdmin']);
            }
        }

        return;
    }

    /*
     * RETURN info Nav
     */
    protected function file_contents_nav()
    {
        include ( CONF . 'nav.php');
        $this->_pages = $_pages;
        $this->_reglesAll = $_reglesAll;
        $this->_reglesMembre = $_reglesMembre;
        $this->_reglesAdmin = $_reglesAdmin;
        $this->navAdmin = $navAdmin;
        $this->navFooter = $navFooter;
        $this->navDefaut = $navDefaut;
    }

    public function nav($_menu = '')
    {
        $_link = str_replace('&lang=fr', '', $_SERVER["QUERY_STRING"]);
        $_link = str_replace('&lang=es', '', $_link);

        $menu = $this->liste_nav($_menu);
        $class = $menu['class'];
        $li = $menu['menu'];
        $i = $menu['accesskey'] + 1;
        if (isset($_SESSION['user'])) {
            $li .= "<li class='" . $class . "'><a href='' class='admin'>[";
            $li .= $_SESSION['user']['user'] . ']</a></li>';
            $li .= "<li class='drapeau'>" .
                "<a href='" . LINK . "?nav=out'><img width='25px' src='img/out.png'></a>".
                "</li>";
        }

        $lang = ($_SESSION['lang'] == 'fr')? 'es' : 'fr';
        $li .= "<li class='drapeau'>" .
            "<a href='" . LINK . "?$_link&lang=$lang' accesskey='".$i."'><img width='25px' src='img/drapeaux_$lang.png'></a>".
            "</li>";

        return $li;
    }

    # Fonction liste_nav()
    # affiche les informations en forme de liste du menu de navigation
    # $actif => mode de connexion
    # [@nav] => string action
    # [@_pages] => array('nav'...)
    # [@titre] => string titre de la page
    # RETURN string liste <li>...</li>
    protected function liste_nav($liste='')
    {
        if(empty($liste)){
            $_liste = (utilisateurAdmin())?
                $this->_reglesAdmin :
                ((utilisateurConnecte())?
                    $this->_reglesMembre :
                    $this->_reglesAll);

        } else {
            // generation de la liste de nav
            $_liste = $this->{$liste};
        }

        // generation de la liste de nav
        $col = count($_liste)+1;
        $menu = '';
        $i = 0;
        foreach ($_liste as $item){
            $i++;
            //$info = $this->_pages[$item];
            $active = ($item == $this->nav)? 'active' : '';
            $active = ($item == $this->nav || ($item == 'actif' && $this->nav == 'connection'))? 'active' : $active;
            $class = (isset($this->_pages[$item]['class']))? $this->_pages[$item]['class'] : 'menu';
            $menu .= '
		<li class="' . $active .' '. $class.' col-'.$col.'">
			<a href="'. LINK .'?nav='. $item .'" accesskey="'.$i.'" title="'.$item.'">' . $this->_trad['nav'][$item] . '</a>
		</li>';
        }
        return array('menu'=>$menu, 'class'=>$class . ' col-'.$col, 'accesskey' => $i);
    }

    public function footer()
    {
        $info = $this->liste_nav('navFooter');
        $info['version'] = file_get_contents(CONF . 'version.txt');
        return $info;
    }
}