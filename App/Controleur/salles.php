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
        $_trad = setTrad();
        $this->reservationSalles();
        $alert = $this->urlReservation();

        $table = $this->listeSalles();
        include VUE . 'salles/salles.tpl.php';
    }

    public function ficheSalles()
    {
        $nav = 'ficheSalles';
        $_trad = setTrad();
        $msg = '';

        $_id = $this->data_methodes('id');
        $position = $this->data_methodes('position', 1);

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
        $_trad = setTrad();

        if(!$this->activeSalles()){
            $alert = "<script>alert('{$_trad['erreur']['manqueProduit']}');</script>";
        }

        $table = $this->listeSallesBO();

        include VUE . 'salles/gestionSalles.tpl.php';
    }

    public function backOff_editProduits()
    {
        $_trad = setTrad();
        include PARAM . 'backOff_produits.param.php';
        $this->modCheckProduits($_formulaire, $_id);
        $form = $this->formulaireAfficher($_formulaire);

        $form .= $this->listeProduits(getSalles($_id));
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
            $_trad['produitNonDispoble'] = "Produits non disponibles";

            $tableau = "<table width='100%' border='1' cellspacing='1' BGCOLOR='#ccc'>$prix_salle</table>";
            $reserve = ($_total)? $_listeReservation .
                                    "<div class='tronche total'>TOTAL :</div>
                                    <div class='personne total'>&nbsp;</div>
                                    <div class='prix total'>" . number_format ($_total, 2) . "€</div>"
                                    : "";
            if(empty($affiche)){
                return ['tableau'=>$_trad['produitNonDispoble'], 'reserve'=>''];
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
        $_trad = setTrad();
        include FUNC . 'form.func.php';
        include PARAM . 'backOff_produits.param.php';

        $msg = '';
        if (isset($_POST['valide']) && postCheck($_formulaire, true)) {

            if(!($msg = produitsValider($_formulaire))) {

                treeProduitsSalle($_formulaire, $_id);
            }
        }

       header('Location:?nav=ficheSalles&id=' . $_GET['id'] . '&pos=' . $_GET['pos']);
    }


    public function backOff_ficheSalles()
    {
        $nav = 'ficheSalles';
        $msg = '';
        $_trad = setTrad();

        include PARAM . 'backOff_ficheSalles.param.php';
        include FUNC . 'form.func.php';

        // extraction des données SQL
        $form = $msg = '';
        if (modCheckSalles($_formulaire, $_id, 'salles')) {
            // traitement POST du formulaire dans les parametres
            if ($_valider){

                $msg = $_trad['erreur']['inconueConnexion'];
                if(postCheck($_formulaire, TRUE)) {
                    $msg = ficheSallesValider($_formulaire);
                }
            }

            if ('OK' == $msg) {
                // on renvoi ver connection
                $msg = $_trad['lesModificationOntEteEffectues'];
                // on évite d'afficher les info du mot de passe
                $form = formulaireAfficherInfo($_formulaire);
            } else {

                if (!empty($msg) || $_modifier) {

                    $_formulaire['valide']['defaut'] = $_trad['defaut']['MiseAJ'];

                    $form = formulaireAfficherMod($_formulaire);

                } elseif (
                    !empty($_POST['valide']) &&
                    $_POST['valide'] == $_trad['Out'] &&
                    $_POST['origin'] != $_trad['defaut']['MiseAJ']
                ){
                    header('Location:' . LINK . '?nav=salles&pos=P-' . $position . '');
                    exit();

                } else {

                    unset($_formulaire['mdp']);
                    $form = formulaireAfficherInfo($_formulaire);

                }

            }

        } else {

            $form = 'Error 500: ' . $_trad['erreur']['NULL'];

        }

        include VUE . 'salles/backOff_ficheSalles.tpl.php';
        backOff_editProduits($_formulaire['id_salle']['valide']);
    }

    public function backOff_editerSalles()
    {
        // Variables
        $extension = '';
        $message = '';
        $nomImage = '';

        $nav = 'editerSalles';
        $_trad = setTrad();

        // traitement du formulaire
        include PARAM . 'backOff_editerSalles.param.php';
        include FUNC . 'form.func.php';

        $msg = '';

        if (postCheck($_formulaire)) {
            if(isset($_POST['valide'])){
                $msg = ($_POST['valide'] == 'cookie') ? 'cookie' : editerSallesValider($_formulaire);
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
        $_trad = setTrad();
        $this->reservationSalles();

        $nav = 'reservation';
        $table = $this->selectSallesReservations();
        $msg = (!empty($table))? $_trad['reservationOk'] : $_trad['erreur']['reservationVide'];
        $alert = $this->urlReservation();

        include VUE . "salles/sallesReservation.tpl.php";
    }
}
