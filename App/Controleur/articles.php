<?php

namespace articles;

include_once MODEL . 'articles.php';
include_once LIB . 'articles.php';

class articles extends \App\articles
{
    public function articles()
    {
        $nav = 'articles';
        $msg = '';
        //$this->_trad
        $this->reservationArticles();
        $alert = $this->urlReservation();

        $table = $this->listeArticles();
        include VUE . 'articles/articles.tpl.php';
    }

    public function ficheArticles()
    {
        $nav = 'ficheArticles';
        //$this->_trad
        $msg = '';

        $_id = data_methodes('id');
        $position = data_methodes('position', 1);

        $this->reservationArticles();
        // control connexion
        // control choix des produits
        $alert = $this->urlReservation();

        include PARAM . 'ficheArticles.param.php';
        // on cherche la fiche dans la BDD
        // extraction des données SQL
        include FUNC . 'form.func.php';

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
        $nav = 'gestionArticles';
        $alert = $msg = '';
        //$this->_trad

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
        $this->modCheckProduits($_formulaire, $_id);
        $form = formulaireAfficher($_formulaire);

        $form .= $this->listeProduits($this->getArticles($_id));
        /*foreach($listePrix as $date=>$info){
            $_liste .= "<div class='ligne date'>" .
                                reperDate($date)
                                . "</div>".$info['reserve'];
            $_total = $_total + $info['couts'];
            } */


        /*
            $ref = '';
            foreach($affiche as $col){
                $ref .=  "<td class='tableauprix'>$col pers.</td>";
            }
            $prix_article = "<tr><td class='tableauprix' width='90'>Max. </td>$ref</tr>" . $prix_article;
            $this->_trad['produitNonDispoble'] = "Produits non disponibles";

            $tableau = "<table width='100%' border='1' cellspacing='1' BGCOLOR='#ccc'>$prix_article</table>";
            $reserve = ($_total)? $_listeReservation .
                                    "<div class='tronche total'>TOTAL :</div>
                                    <div class='personne total'>&nbsp;</div>
                                    <div class='prix total'>" . number_format ($_total, 2) . "€</div>"
                                    : "";
            if(empty($affiche)){
                return ['tableau'=>$this->_trad['produitNonDispoble'], 'reserve'=>''];
            }
        */
        //return ['tableau'=>$tableau, 'reserve'=>$reserve];
        //return ['affiche'=>$affiche, 'prix_article'=>$prix_article];
        include VUE . 'articles/gestionProduits.tpl.php';
        // liste des prix
    }

    public function backOff_gestionProduits()
    {
     echo 'je suis la';
        //$this->_trad
        include FUNC . 'form.func.php';
        include PARAM . 'backOff_produits_articles.param.php';

        $msg = '';
        if (isset($_POST['valide']) && postCheck($_formulaire, true)) {

            if(!($msg = $this->produitsValider($_formulaire))) {

                $this->treeProduitsArticle($_formulaire, $_id);
            }
        }

       header('Location:?nav=ficheArticles&id=' . $_GET['id'] . '&pos=' . $_GET['pos']);
    }


    public function backOff_ficheArticles()
    {
        $nav = 'ficheArticles';
        $msg = '';
        //$this->_trad

        include PARAM . 'backOff_ficheArticles.param.php';
        include FUNC . 'form.func.php';

        // extraction des données SQL
        $form = $msg = '';
        if ($this->modCheckArticles($_formulaire, $_id)) {
            // traitement POST du formulaire dans les parametres
            if ($_valider){

                $msg = $this->_trad['erreur']['inconueConnexion'];
                if(postCheck($_formulaire, TRUE)) {
                    $msg = $this->ficheArticlesValider($_formulaire);
                }
            }

            if ('OK' == $msg) {
                // on renvoi ver connection
                $msg = $this->_trad['lesModificationOntEteEffectues'];
                // on évite d'afficher les info du mot de passe
                $form = formulaireAfficherInfo($_formulaire);
            } else {

                if (!empty($msg) || $_modifier) {

                    $_formulaire['valide']['defaut'] = $this->_trad['defaut']['MiseAJ'];

                    $form = formulaireAfficherMod($_formulaire);

                } elseif (
                    !empty($_POST['valide']) &&
                    $_POST['valide'] == $this->_trad['Out'] &&
                    $_POST['origin'] != $this->_trad['defaut']['MiseAJ']
                ){
                    header('Location:' . LINK . '?nav=articles&pos=P-' . $position . '');
                    exit();

                } else {

                    unset($_formulaire['mdp']);
                    $form = formulaireAfficherInfo($_formulaire);

                }

            }

        } else {

            $form = 'Error 500: ' . $this->_trad['erreur']['NULL'];

        }

        include VUE . 'articles/backOff_ficheArticles.tpl.php';
        $this->backOff_editProduits($_formulaire['id_article']['valide']);
    }

    public function backOff_editerArticles()
    {
        // Variables
        $extension = '';
        $message = '';
        $nomImage = '';

        $nav = 'editerArticles';
        //$this->_trad

        // traitement du formulaire
        include PARAM . 'backOff_editerArticles.param.php';
        include FUNC . 'form.func.php';

        $msg = '';

        if (postCheck($_formulaire)) {
            if(isset($_POST['valide'])){
                $msg = ($_POST['valide'] == 'cookie') ? 'cookie' : $this->editerArticlesValider($_formulaire);
            }
        }

    // affichage des messages d'erreur
        if ('OK' == $msg) {
            // on renvoi ver la liste des articles
            header('Location:index.php?nav=articles&pos='.$_formulaire['position']['value']);
            exit();
        } else {
            // RECUPERATION du formulaire
            $form = formulaireAfficher($_formulaire);
            include VUE . 'articles/editerArticles.tpl.php';
        }
    }


    public function reservation()
    {
        //$this->_trad
        $this->reservationArticles();

        $nav = 'reservation';
        $table = $this->selectArticlesReservations();
        $msg = (!empty($table))? $this->_trad['reservationOk'] : $this->_trad['erreur']['reservationVide'];
        $alert = $this->urlReservation();

        include VUE . "articles/articlesReservation.tpl.php";
    }
}