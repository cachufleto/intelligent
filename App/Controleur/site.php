<?php
namespace site;
use App\App;
use App\formulaire;
include CONTROLEUR . 'articles.php';
use articles\articles;

include_once MODEL . 'site.php';
//include_once FUNC . 'site.func.php';

class site extends \Model\site
{
    var $form = false;
    var $nav = 'home';
    var $_trad = [];

    public function __construct()
    {
        $this->_trad = setTrad();
        $this->form = new formulaire();
        parent::__construct();
    }

    public function home()
    {
        $_SESSION['rechercheProduits'] = '';
        $articles = new articles();
        ob_start();
        $articles->articles();
        $listeArticles = ob_get_contents();
        ob_end_clean();
        $dernieresOffres = $this->homeArticles();
        $dernieresOffres .= $this->homeSalles();

        include VUE . 'site/home.tpl.php';
    }

    public function homeSalles()
    {
        $salles = $this->selectSallesActive();
        $dernieresOffres = '<div id="dernieresOffres">';
        while($salle = $salles->fetch_assoc()){
            $dernieresOffres .= dernieresOffresSalles($salle);
        }
        $dernieresOffres .= '</div>';
        return $dernieresOffres;
    }

    public function homeArticles()
    {
        $articles = $this->selectArticlesActive();
        $dernieresOffres = '<div id="dernieresOffres">';
        while($article = $articles->fetch_assoc()){
            $dernieresOffres .= dernieresOffresArticles($article);
        }
        $dernieresOffres .= '</div>';
        return $dernieresOffres;
    }

    public function recupNav()
    {
        if($arg = basename(str_replace('?', '', $_SERVER['HTTP_REFERER']))){
            if(preg_match('#&#', $_SERVER['HTTP_REFERER'])){
                $_arg = $_nav = explode('&', $arg);
                $_nav = explode('=', $_arg[0]);
                return $_nav[1];
            } else {
                $_nav = explode('=', $arg);
                return $_nav[1];
            }
        }
        return false;
    }

    public function backoffice()
    {
        $this->nav = 'backoffice';
        //$this->_trad
        if($this->nav=$this->recupNav()){
            header('location:' . basename($_SERVER['HTTP_REFERER']));
        }
        // phpinfo();

        $activite = (!empty($_POST))? '<textarea name="notreAtivite"></textarea>' : 'Activité';
        $dernieresOffres = (!empty($_POST))? '<textarea name="notreAtivite"></textarea>' :  'Derniéres Offres';

        include VUE . 'site/backoffice.tpl.php';

    }

    public function contact()
    {
        //$this->_trad
        $listConctact = array();

        $membres = $this->userSelectContactAll();

        if ($membres->num_rows > 0) {
            while ($membre = $membres->fetch_assoc()) {
                $listConctact[] = $membre; //
            }
        }

        include VUE . 'site/contact.tpl.php';
    }

    public function statics()
    {
        include VUE . 'site/static.tpl.php';
    }

        public function erreur404($nav)
    {
        //$this->_trad

        $this->form->msg = ($this->nav=='erreur404')?
            $this->_trad['erreur']['erreur404'] :
            $this->_trad['enConstruccion'];

        include VUE . 'site/erreur404.tpl.php';
    }
}
