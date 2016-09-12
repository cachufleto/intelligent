<?php
namespace users;
use App\formulaire;

include_once MODEL . 'users.php';
include_once LIB . 'users.php';

class users extends \App\users
{
    var $form = '';

    public function __construct()
    {
        $this->form = new formulaire();
        parent::__construct();
    }

    public function inscription()
    {
        include PARAM . 'inscription.param.php';
        // traitement POST du formulaire
        $this->form->_formulaire = $_formulaire;

        if (isset($_POST['valide']) && $this->form->postCheck(true)) {
            //$msg = ($_POST['valide'] == 'cookie') ? 'cookie' : inscriptionValider($_formulaire);
            $this->form->msg = $this->inscriptionValider();
        }

        $form = ('OK' != $this->form->msg) ? $this->form->formulaireAfficher() : '';
        // affichage des messages d'erreur
        include VUE . 'users/inscription.tpl.php';
    }

    public function backOff_users()
    {
        $nav = 'users';
        //$this->_trad
        //include PARAM . 'profil.param.php';

        if (!utilisateurAdmin()) {
            header('Location:index.php');
            exit();
        }

        if (isset($_GET)) {
            if (!empty($_GET['delete']) && $_GET['delete'] != 1) {

                if ($_GET['delete'] != $_SESSION['user']['id']) {
                    $this->setUserActive($_GET['delete'], 0);
                } else {
                    $this->form->msg = $this->_trad['vousNePouvezPasVousSupprimerVousMeme'];
                }

            } elseif (!empty($_GET['active'])) {

                $this->setUserActive($_GET['active']);

            } else if (!empty($_GET['delete']) && $_GET['delete'] == 1) {

                $this->form->msg = $this->_trad['numAdmInsufisant'];

            }

        }

        $table = array();
        $table['champs'] = array();
        $table['champs']['pseudo'] = $this->_trad['champ']['pseudo'];
        $table['champs']['nom'] = $this->_trad['champ']['nom'];
        $table['champs']['prenom'] = $this->_trad['champ']['prenom'];
        $table['champs']['email'] = $this->_trad['champ']['email'];
        $table['champs']['statut'] = $this->_trad['champ']['statut'];
        $table['champs']['active'] = $this->_trad['champ']['active'];

        $table['info'] = array();
        if (isSuperAdmin()) {

            $membres = $this->usersMoinsAdmin();

            if ($membres->num_rows > 0) {
                while ($data = $membres->fetch_assoc()) {
                    $table['info'][] = array(
                        $data['pseudo'],
                        $data['nom'],
                        $data['prenom'],
                        '<a href="mailto:' . $data['email'] . '">' . $data['email'] . '</a>',
                        $this->_trad['value'][$data['statut']],
                        '<a href="' . LINK . '?nav=profil&id=' . $data['id'] . '" >
                        <img width="25px" src="img/modifier.png"></a>' . (($data['active'] == 2) ? "NEW" : ""),
                        (($data['active'] == 1) ?
                            ' <a href="' . LINK . '?nav=users&delete=' . $data['id'] . '"><img width="25px" src="img/activerOk.png"></a>' :
                            ' <a href="' . LINK . '?nav=users&active=' . $data['id'] . '"><img width="25px" src="img/activerKo.png"></a>')
                    );
                }
            }
        }

        $membres = $this->selectUsersActive();

        while ($data = $membres->fetch_assoc()) {
            $table['info'][] = array(
                $data['pseudo'],
                $data['nom'],
                $data['prenom'],
                '<a href="mailto:' . $data['email'] . '">' . $data['email'] . '</a>',
                $this->_trad['value'][$data['statut']],
                '<a href="' . LINK . '?nav=profil&id=' . $data['id'] . '" ><img width="25px" src="img/modifier.png"></a>',
                (($data['active'] == 1) ?
                    ' <a href="' . LINK . '?nav=users&delete=' . $data['id'] . '"><img width="25px" src="img/activerKo.png"></a>' :
                    ' <a href="' . LINK . '?nav=users&active=' . $data['id'] . '"><img width="25px" src="img/activerOk.png"></a>')

            );
        }

        include VUE . 'users/users.tpl.php';
    }

    public function profil()
    {
        $nav = 'profil';
        //$this->_trad
        include PARAM . 'profil.param.php';
        if (utilisateurAdmin()) {
            include PARAM . 'backOff_profil.param.php';
        }
        //include FUNC . 'form.func.php';
        $this->form->_formulaire = $_formulaire;

        if (!isset($_SESSION['user'])) {
            header('Location:index.php');
            exit();
        }
        // extraction des données SQL
        if ($this->modCheckMembres($_id, 'membres')) {
            // traitement POST du formulaire
            if ($_valider) {
                $this->form->msg = $this->_trad['erreur']['inconueConnexion'];
                if ($this->form->postCheck($this->form->_formulaire, TRUE)) {
                    $this->form->msg = ($_POST['valide'] == 'cookie') ? 'cookie' : $this->profilValider();
                }
            }
            if ('OK' == $this->form->msg) {
                // on renvoi ver connection
                $this->form->msg = $this->_trad['lesModificationOntEteEffectues'];
                // on évite d'afficher les info du mot de passe
                unset($this->form->_formulaire['mdp']);
                $form = $this->form->formulaireAfficherInfo();
            } else {
                if (!empty($this->form->msg) || $_modifier) {
                    $this->form->_formulaire['valide']['defaut'] = $this->_trad['defaut']['MiseAJ'];
                    $form = $this->form->formulaireAfficherMod();
                } elseif (
                    !empty($_POST['valide']) &&
                    $_POST['valide'] == $this->_trad['Out'] &&
                    $_POST['origin'] != $this->_trad['defaut']['MiseAJ']
                ) {
                    header('Location:' . LINK . '?nav=users');
                    exit();
                } else {
                    unset($this->form->_formulaire['mdp']);
                    $form = $this->form->formulaireAfficherInfo();
                }
            }
        } else {
            $form = 'Erreur 500: ' . $this->_trad['erreur']['NULL'];
        }
        include VUE . 'users/profil.tpl.php';
    }

    # Fonction profilValider()
    # Verifications des informations en provenance du formulaire
    # @_formulaire => tableau des items
    # RETURN string msg
    public function profilValider()
    {
        global $minLen;

        //$this->_trad

        // control d'intrusion du membre
        if ($this->form->_formulaire['id']['sql'] != $this->form->_formulaire['id']['defaut']) {
            //_debug($_formulaire, 'SQL');
            return '<div class="alert">' . $this->_trad['erreur']['NULL'] . '!!!!!</div>';
        }
        $this->form->msg = $erreur = false;
        $sql_set = '';
        // active le controle pour les champs telephone et gsm
        $controlTelephone = true;

        $id_membre = $this->form->_formulaire['id']['sql'];

        foreach ($this->form->_formulaire as $key => $info) {

            $label = $this->_trad['champ'][$key];
            $valeur = (isset($info['valide'])) ? $info['valide'] : NULL;

            if ('valide' != $key && 'id' != $key) {

                if (isset($info['maxlength']) && !$this->form->testLongeurChaine($valeur, $info['maxlength']) && !empty($valeur)) {

                    $erreur = true;
                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                        ': ' . $this->_trad['erreur']['doitContenirEntre'] . $minLen .
                        ' et ' . $info['maxlength'] . $this->_trad['erreur']['caracteres'];

                }

                if ('vide' != $this->form->testObligatoire($info) && !$this->form->testObligatoire($info) && empty($valeur)) {

                    $erreur = true;
                    $this->form->_formulaire[$key]['message'] = $label . $this->_trad['erreur']['obligatoire'];

                } else {

                    switch ($key) {

                        case 'pseudo':
                        case 'id':
                            // je ne fait riens
                            break;

                        case 'mdp':
                            $valeur = (!empty($valeur)) ? hashCrypt($valeur) : '';
                            break;

                        case 'email': // il est obligatoire

                            if ($this->form->testFormatMail($valeur)) {

                                $membre = $this->selectMailUser($this->form->_formulaire['id']['sql'], $valeur);

                                // si la requete retourne un enregisterme, c'est que 'email' est deja utilisé en BD.
                                if ($membre->num_rows > 0) {
                                    $erreur = true;
                                    $this->form->msg .= '<br/>' . $this->_trad['erreur']['emailexistant'];
                                }

                            } else {

                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label . ' "' . $valeur .
                                    '", ' . $this->_trad['erreur']['aphanumeriqueSansSpace'];

                            }

                            break;

                        case 'sexe':

                            if (empty($valeur)) {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': ' . $this->_trad['erreur']['vousDevezChoisireUneOption'];
                            }

                            break;

                        case 'nom': // est obligatoire
                        case 'prenom': // il est obligatoire
                            if (!$this->form->testLongeurChaine($valeur)) {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': ' . $this->_trad['erreur']['nonVide'];

                            } elseif (!$this->form->testAlphaNumerique($valeur)) {

                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label . ' "' . $valeur .
                                    '", ' . $this->_trad['erreur']['aphanumeriqueSansSpace'];

                            }


                            break;

                        case 'telephone':
                        case 'gsm':

                            if (!empty($valeur)) {

                                // un des deux doit être renseigné
                                $controlTelephone = false;
                                $valeur = str_replace(' ', '', $valeur);

                                if (isset($info['length']) && (strlen($valeur) < $info['length'] || strlen($valeur) > $info['length'] + 4)) {

                                    $erreur = true;
                                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                        ': ' . $this->_trad['erreur']['doitContenir'] . $info['length'] . $this->_trad['erreur']['caracteres'];
                                }

                                if ($this->form->testNumerique($valeur)) {
                                    $erreur = true;
                                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                        ': ' . $this->_trad['erreur']['queDesChiffres'];
                                }

                            }

                            break;

                        case 'cp':
                            if ($this->form->testNumerique($valeur)) {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': ' . $this->_trad['erreur']['queDesChiffres'];
                            }
                        break;

                        case 'statut':

                            if ($this->testADMunique($valeur, $id_membre)) {
                                $erreur = true;
                                $this->form->msg .= '<br/>' . $this->_trad['numAdmInsufisant'];
                                $this->form->_formulaire['statut']['valide'] = 'ADM';
                            }

                            break;

                        default:
                            $long = (isset($info['maxlength'])) ? $info['maxlength'] : 250;
                            if (!empty($valeur) && !$this->form->testLongeurChaine($valeur, $long)) {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': ' . $this->_trad['erreur']['minimumAphaNumerique'] . ' ' . $minLen . ' ' . $this->_trad['erreur']['caracteres'];
                            }
                    }
                }
                // Construction de la requettes
                // le mot de passe doit être traité differement

                $sql_set .= ((!empty($sql_set) && !empty($valeur)) ? ", " : "") . ((!empty($valeur)) ? "$key = '$valeur'" : '');

            }
        }

        // control sur les numero de telephones
        // au moins un doit être sonseigné
        if ($controlTelephone) {
            $erreur = true;
            $this->form->_formulaire['telephone']['message'] = $this->_trad['erreur']['controlTelephone'];
        }

        // si une erreur c'est produite
        if ($erreur) {
            $this->form->msg = '<div class="alert">' . $this->_trad['ERRORSaisie'] . $this->form->msg . '</div>';

        } else {

            if (!empty($sql_set)) {
                $this->userUpdate($sql_set, $this->form->_formulaire['id']['sql']);
            } else {
                $this->form->msg = $this->_trad['erreur']['inconueConnexion'];
            }
            // ouverture d'une session
            $this->form->msg = "OK";
        }

        //return $msg;
    }

    public function identifians()
    {
        //$this->_trad
        include PARAM . 'identifians.param.php';

        //include FUNC . 'form.func.php';
        $this->form->_formulaire = $_formulaire;

        $this->form->msg = $this->usersIdentifians();

        $form = $this->form->formulaireAfficher();

        include VUE . 'users/identifians.tpl.php';
    }

    /*public function changermotpasse()
    {

        //$this->_trad
        include FUNC . 'form.func.php';
        include PARAM . 'changermotpasse.param.php';

        $msg = '';
        if (isset($_POST['valide']) && postCheck($_formulaire, true)) {

            if (!($msg = $this->changerMotPasseValider($_formulaire))) {

                $membre = $this->getUserMail($_formulaire);
                $checkinscription = hashCrypt("CHANGE" . date('m:D:d:s:Y:M'));
                if ($this->userChangerMDPInsert($checkinscription, $_formulaire)) {
                    $msg = $this->envoiMailChangeMDP($checkinscription, $membre);
                } else {
                    $msg = $this->_trad['erreur']['inconueConnexion'];
                }

            }
        }

        /////////////////////////////////////
        if (isset($_SESSION['connexion']) && $_SESSION['connexion'] < 0) {
            // affichage
            $msg = $this->_trad['erreur']['acces'];

        } else {

            // RECUPERATION du formulaire
            $form = formulaireAfficher($_formulaire);
        }

        include VUE . 'users/changermotpasse.tpl.php';
    }*/

    public function validerInscription()
    {
        if (isset($_GET['jeton']) && !empty($_GET['jeton'])) {
            $this->userMDP($_GET['jeton']);
        }
    }

    public function validerChangementMDP()
    {
        if (isset($_GET['jeton']) && !empty($_GET['jeton'])) {
            $this->userMDP($_GET['jeton']);
        }
    }

    public function newMDP()
    {
        if (isset($_GET['jeton']) && !empty($_GET['jeton'])) {
            $this->userMDP($_GET['jeton']);
        }
    }

    public function expiration()
    {
        include VUE . 'users/expiration.tpl.php';
    }
}