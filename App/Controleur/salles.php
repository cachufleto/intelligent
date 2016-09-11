<?php

namespace salles;

include_once MODEL . 'salles.php';
include_once LIB . 'salles.php';

class salles extends \App\salles
{
    public function salles()
    {
        $nav = 'salles';
        $msg = '';
        //$this->_trad
        $this->reservationSalles();
        $alert = $this->urlReservation();

        $table = $this->listeSalles();
        include VUE . 'salles/salles.tpl.php';
    }

    public function ficheSalles()
    {
        $nav = 'ficheSalles';
        //$this->_trad
        $msg = '';

        $_id = data_methodes('id');
        $position = data_methodes('position', 1);

        $this->reservationSalles();
        // control connexion
        // control choix des produits
        $alert = $this->urlReservation();

        include PARAM . 'ficheSalles.param.php';
        // on cherche la fiche dans la BDD
        // extraction des données SQL
        include FUNC . 'form.func.php';

        if ($salle = $this->getSalles($_id)) {
            // traitement POST du formulaire
            include VUE . 'salles/ficheSalles.tpl.php';
        } else {
            header('Location:?nav=salles');
            exit();
        }

    }

    public function backOff_salles()
    {
        $nav = 'gestionSalles';
        $alert = $msg = '';
        //$this->_trad

        if(!$this->activeSalles()){
            $alert = "<script>alert('{$this->_trad['erreur']['manqueProduit']}');</script>";
        }

        $table = $this->listeSallesBO();

        include VUE . 'salles/gestionSalles.tpl.php';
    }

    public function backOff_editProduits($id)
    {
        //$this->_trad
        include PARAM . 'backOff_produits_salles.param.php';
        $this->modCheckProduits($_formulaire, $_id);
        $form = formulaireAfficher($_formulaire);

        $form .= $this->listeProduits($this->getSalles($_id));
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
            $prix_salle = "<tr><td class='tableauprix' width='90'>Max. </td>$ref</tr>" . $prix_salle;
            $this->_trad['produitNonDispoble'] = "Produits non disponibles";

            $tableau = "<table width='100%' border='1' cellspacing='1' BGCOLOR='#ccc'>$prix_salle</table>";
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
        //return ['affiche'=>$affiche, 'prix_salle'=>$prix_salle];
        include VUE . 'salles/gestionProduits.tpl.php';
        // liste des prix
    }

    public function backOff_gestionProduits()
    {
     echo 'je suis la';
        //$this->_trad
        include FUNC . 'form.func.php';
        include PARAM . 'backOff_produits_salles.param.php';

        $msg = '';
        if (isset($_POST['valide']) && postCheck($_formulaire, true)) {

            if(!($msg = $this->produitsValider($_formulaire))) {

                $this->treeProduitsSalle($_formulaire, $_id);
            }
        }

       header('Location:?nav=ficheSalles&id=' . $_GET['id'] . '&pos=' . $_GET['pos']);
    }


    public function backOff_ficheSalles()
    {
        $nav = 'ficheSalles';
        $msg = '';
        //$this->_trad

        include PARAM . 'backOff_ficheSalles.param.php';
        include FUNC . 'form.func.php';

        // extraction des données SQL
        $form = $msg = '';
        if ($this->modCheckSalles($_formulaire, $_id)) {
            // traitement POST du formulaire dans les parametres
            if ($_valider){

                $msg = $this->_trad['erreur']['inconueConnexion'];
                if(postCheck($_formulaire, TRUE)) {
                    $msg = $this->ficheSallesValider($_formulaire);
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
                    header('Location:' . LINK . '?nav=salles&pos=P-' . $position . '');
                    exit();

                } else {

                    unset($_formulaire['mdp']);
                    $form = formulaireAfficherInfo($_formulaire);

                }

            }

        } else {

            $form = 'Error 500: ' . $this->_trad['erreur']['NULL'];

        }

        include VUE . 'salles/backOff_ficheSalles.tpl.php';
        $this->backOff_editProduits($_formulaire['id_salle']['valide']);
    }

    public function backOff_editerSalles()
    {
        // Variables
        $extension = '';
        $message = '';
        $nomImage = '';

        $nav = 'editerSalles';
        //$this->_trad

        // traitement du formulaire
        include PARAM . 'backOff_editerSalles.param.php';
        include FUNC . 'form.func.php';

        $msg = '';

        if (postCheck($_formulaire)) {
            if(isset($_POST['valide'])){
                $msg = ($_POST['valide'] == 'cookie') ? 'cookie' : $this->editerSallesValider($_formulaire);
            }
        }

    // affichage des messages d'erreur
        if ('OK' == $msg) {
            // on renvoi ver la liste des salles
            header('Location:index.php?nav=salles&pos='.$_formulaire['position']['value']);
            exit();
        } else {
            // RECUPERATION du formulaire
            $form = formulaireAfficher($_formulaire);
            include VUE . 'salles/editerSalles.tpl.php';
        }
    }


    public function reservation()
    {
        //$this->_trad
        $this->reservationSalles();

        $nav = 'reservation';
        $table = $this->selectSallesReservations();
        $msg = (!empty($table))? $this->_trad['reservationOk'] : $this->_trad['erreur']['reservationVide'];
        $alert = $this->urlReservation();

        include VUE . "salles/sallesReservation.tpl.php";
    }
}
