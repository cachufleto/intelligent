<?php

namespace articles;
use App\formulaire;

include_once MODEL . 'articles.php';
include_once LIB . 'articles.php';

class articles extends \App\articles
{
    var $form = false;
    var $nav = 'articles';

    public function __construct()
    {
        $this->form = new formulaire();
        parent::__construct();
    }

    public function articles()
    {
        $this->reservationArticles();
        $alert = $this->urlReservation();
        $table = $this->listeArticles();
        include VUE . 'articles/articles.tpl.php';
    }

    public function ficheArticles()
    {
        $_id = data_methodes('id');
        $position = data_methodes('position', 1);

        $this->reservationArticles();
        // control connexion
        // control choix des produits
        $alert = $this->urlReservation();

        include PARAM . 'ficheArticles.param.php';
        // on cherche la fiche dans la BDD
        // extraction des données SQL
        //include FUNC . 'form.func.php';
        $this->form->_formulaire = $_formulaire;

        if ($article = $this->getArticles($_id)) {
            // traitement POST du formulaire
            include VUE . 'articles/ficheArticles.tpl.php';
        } else {
            header('Location:?nav=articles');
            exit();
        }

    }

    public function backOff_articles()
    {
        $this->nav = 'gestionArticles';
        if(!$this->activeArticles()){
            $alert = "<script>alert('{$this->_trad['erreur']['manqueProduit']}');</script>";
        }

        $table = $this->listeArticlesBO();

        include VUE . 'articles/gestionArticles.tpl.php';
    }

    public function backOff_editProduits($id)
    {
        //$this->_trad
        include PARAM . 'backOff_produits_articles.param.php';
        $this->modCheckProduits($_id);
        $form = $this->form->formulaireAfficher();

        //$form .= $this->listeProduits($this->getArticles($_id));
        include VUE . 'articles/gestionProduits.tpl.php';
        // liste des prix
    }

    public function backOff_gestionProduits()
    {
        include PARAM . 'backOff_produits_articles.param.php';
        $this->form->_formulaire = $_formulaire;

        //$msg = '';
        if (isset($_POST['valide']) && $this->form->postCheck(true)) {

            if(!($this->form->msg = $this->produitsValider())) {

                $this->treeProduitsArticle($_id);
            }
        }

       header('Location:?nav=ficheArticles&id=' . $_GET['id'] . '&pos=' . $_GET['pos']);
    }


    public function backOff_ficheArticles()
    {
        $this->nav = 'ficheArticles';
        include PARAM . 'backOff_ficheArticles.param.php';
        //include FUNC . 'form.func.php';
        $this->form->_formulaire = $_formulaire;

        // extraction des données SQL
        $form = '';
        //$msg = '';
        if ($this->modCheckArticles($_id)) {
            // traitement POST du formulaire dans les parametres
            if ($_valider){

                $this->form->msg = $this->_trad['erreur']['inconueConnexion'];
                if($this->form->postCheck(TRUE)) {
                    $this->form->msg = $this->ficheArticlesValider();
                }
            }

            if ('OK' == $this->form->msg) {
                // on renvoi ver connection
                $this->form->msg = $this->_trad['lesModificationOntEteEffectues'];
                // on évite d'afficher les info du mot de passe
                $form = $this->form->formulaireAfficherInfo();
            } else {

                if (!empty($this->form->msg) || $_modifier) {

                    $this->form->_formulaire['valide']['defaut'] = $this->_trad['defaut']['MiseAJ'];

                    $form = $this->form->formulaireAfficherMod();

                } elseif (
                    !empty($_POST['valide']) &&
                    $_POST['valide'] == $this->_trad['Out'] &&
                    $_POST['origin'] != $this->_trad['defaut']['MiseAJ']
                ){
                    header('Location:' . LINK . '?nav=articles&pos=P-' . $position . '');
                    exit();

                } else {

                    unset($this->form->_formulaire['mdp']);
                    $form = $this->form->formulaireAfficherInfo();

                }

            }

        } else {

            $form = 'Error 500: ' . $this->_trad['erreur']['NULL'];

        }

        //$form .= $this->backOff_editProduits($_id);
        include VUE . 'articles/backOff_ficheArticles.tpl.php';
    }

    public function backOff_editerArticles()
    {
        // Variables
        $extension = '';
        $message = '';
        $nomImage = '';

        $this->nav = 'editerArticles';
        //$this->_trad

        // traitement du formulaire
        include PARAM . 'backOff_editerArticles.param.php';
        //include FUNC . 'form.func.php';
        $this->form->_formulaire = $_formulaire;

        if ($this->form->postCheck()) {
            if(isset($_POST['valide'])){
                $this->form->msg = ($_POST['valide'] == 'cookie') ? 'cookie' : $this->editerArticlesValider();
            }
        }

    // affichage des messages d'erreur
        if ('OK' == $this->form->msg) {
            // on renvoi ver la liste des articles
            header('Location:index.php?nav=articles&pos='.$this->form->_formulaire['position']['value']);
            exit();
        } else {
            // RECUPERATION du formulaire
            $form = $this->form->formulaireAfficher();
            include VUE . 'articles/editerArticles.tpl.php';
        }
    }


    public function reservation()
    {
        //$this->_trad
        $this->reservationArticles();

        $table = $this->selectArticlesReservations();
        $this->form->msg = (!empty($table))? $this->_trad['reservationOk'] : $this->_trad['erreur']['reservationVide'];
        $alert = $this->urlReservation();

        include VUE . "articles/articlesReservation.tpl.php";
    }
}
