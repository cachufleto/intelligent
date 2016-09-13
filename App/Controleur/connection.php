<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 11/09/2016
 * Time: 07:44
 */

namespace connection;
use App\formulaire;

include_once MODEL . 'users.php';
include_once LIB . 'users.php';

class connection extends \App\users
{
    var $form = false;
    var $nav = 'connection';

    public function __construct()
    {
        $this->form = new formulaire();
        parent::__construct();
    }

    public function connection()
    {
        //$nav = 'connection';
        //$this->_trad

        include PARAM . 'connection.param.php';
        $this->form->_formulaire = $_formulaire;

        $this->form->msg = $this->actifUser();

        /////////////////////////////////////
        if (isset($_SESSION['connexion']) && $_SESSION['connexion'] < 0) {
            // affichage
            $this->form->msg = $this->_trad['erreur']['acces'];

        } else {

            // RECUPERATION du formulaire
            $form = $this->form->formulaireAfficher();
        }

        include VUE . 'users/connection.tpl.php';
    }

    public function changermotpasse()
    {

        include PARAM . 'changermotpasse.param.php';
        $this->form->_formulaire = $_formulaire;

        //$this->form->msg = '';
        if (isset($_POST['valide']) && $this->form->postCheck(true)) {

            if (!($this->form->msg = $this->changerMotPasseValider())) {

                $membre = $this->getUserMail($this->form->_formulaire['email']['valide']);
                $checkinscription = hashCrypt("CHANGE" . date('m:D:d:s:Y:M'));
                if ($this->userChangerMDPInsert($checkinscription, $this->form->_formulaire['email']['valide'])) {
                    $this->form->msg = $this->envoiMailChangeMDP($checkinscription, $membre);
                } else {
                    $this->form->msg = $this->_trad['erreur']['inconueConnexion'];
                }

            }
        }

        /////////////////////////////////////
        if (isset($_SESSION['connexion']) && $_SESSION['connexion'] < 0) {
            // affichage
            $this->form->msg = $this->_trad['erreur']['acces'];

        } else {

            // RECUPERATION du formulaire
            $form = $this->form->formulaireAfficher();
        }

        include VUE . 'users/changermotpasse.tpl.php';
    }

}