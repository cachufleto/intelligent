<?php

# Fonction inscriptionValider()
# Verifications des informations en provenance du formulaire
# @_formulaire => tableau des items
# RETURN string msg
namespace App;

class users extends \Model\users
{
    protected function changerMotPasseValider()
    {
        global $minLen;
        //$this->_trad
    
        $erreur = false;
        $sql_Where = '';
        $control = true;
        $message ='';
    
        foreach ($this->form->_formulaire as $key => $info){
    
            $label = $this->_trad['champ'][$key];
            $valeur = (isset($info['valide']))? $info['valide'] : NULL;
            if($this->form->testObligatoire($info) && empty($valeur)) {
                $erreur = true;
                $this->form->_formulaire[$key]['message'] = $this->form->inputMessage(
                    $this->form->_formulaire[$key], $label . $this->_trad['erreur']['obligatoire']);
            }
    
            if('valide' != $key)
                if (isset($info['maxlength']) && !$this->form->testLongeurChaine($valeur, $info['maxlength']))
                {
                    $erreur = true;
                    $this->form->_formulaire[$key]['message'] = $this->form->inputMessage(
                        $this->form->_formulaire[$key], $this->_trad['erreur']['surLe'] .$label.
                        ': ' . $this->_trad['erreur']['doitContenirEntre'] . $minLen .
                        ' et ' . $info['maxlength'] . $this->_trad['erreur']['caracteres']);
    
                }
            switch ($key){
                case 'email':
                    if(!$this->userMailExist($valeur)){
                        $erreur = true;
                        $this->form->msg = $this->_trad['erreur']['mailInexistant'];
                    }
                    break;
            }
        }
    
        if($erreur) // si la variable $msg est vide alors il n'y a pas d'erreurr !
        {  // le pseudo n'existe pas en BD donc on peut lancer l'inscription
    
            $this->form->msg .= '<br />'.$this->_trad['erreur']['uneErreurEstSurvenue'];
    
        }
    
        //return $msg;
    }
    
    protected function mdpValider()
    {
        global $minLen;
        //$this->_trad
    
        $erreur = false;
        foreach ($this->form->_formulaire as $key => $info){
            $label = $this->_trad['champ'][$key];
            $valeur = (isset($info['valide']))? $info['valide'] : NULL;
            if($this->form->testObligatoire($info) && empty($valeur)) {
                $erreur = true;
                $this->form->_formulaire[$key]['message'] = $this->form->inputMessage(
                    $this->form->_formulaire[$key], $label . $this->_trad['erreur']['obligatoire']);
            }
    
            if('valide' != $key)
                if (isset($info['maxlength']) && !$this->form->testLongeurChaine($valeur, $info['maxlength']))
                {
                    $erreur = true;
                    $this->form->_formulaire[$key]['message'] = $this->form->inputMessage(
                        $this->form->_formulaire[$key], $this->_trad['erreur']['surLe'] .$label.
                        ': ' . $this->_trad['erreur']['doitContenirEntre'] . $minLen .
                        ' et ' . $info['maxlength'] . $this->_trad['erreur']['caracteres']);
    
                }
        }

        if($erreur) // si la variable $msg est vide alors il n'y a pas d'erreurr !
        {  // le pseudo n'existe pas en BD donc on peut lancer l'inscription
    
            $this->form->msg .= '<br />'.$this->_trad['erreur']['uneErreurEstSurvenue'];
    
        } else {
    
            // la variable $pseudo existe grace a l'extract fait prealablemrent.
            if($membre = $this->selecMembreJeton($this->form->_formulaire['jeton']['valide'])){
                $this->userUpdateMDP($this->form->_formulaire['mdp']['valide'], $membre);
                $this->updateMembreJeton($membre);
                header('location:index.php?nav=actif');
            } else {
                header('location:index.php?nav=expiration');
            }
        }
    }
    
    protected function inscriptionValider()
    {
    
        global $minLen;
    
        //$this->_trad
    
        //$msg =
        $erreur = false;
        $sql_champs = $sql_Value = '';
        // active le controle pour les champs telephone et gsm
        $controlTelephone = true;
    
        foreach ($this->form->_formulaire as $key => $info){
    
            $label = $this->_trad['champ'][$key];
            $valeur = (isset($info['valide']))? $info['valide'] : NULL;
    
            if('valide' != $key)
                if (isset($info['maxlength']) && !$this->form->testLongeurChaine($valeur, $info['maxlength'])  && !empty($valeur))
                {
    
                    $erreur = true;
                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label.
                        ': ' . $this->_trad['erreur']['doitContenirEntre'] . $minLen .
                        ' et ' . $info['maxlength'] . $this->_trad['erreur']['caracteres'];
    
                } elseif ($this->form->testObligatoire($info) && empty($valeur)){
    
                    $erreur = true;
                    $this->form->_formulaire[$key]['message'] = $label . $this->_trad['erreur']['obligatoire'];
    
                } else {
    
                    switch($key){
                        /*
                        case 'mdp': // il est obligatoire
                            $valeur = hashCrypt($valeur);
                            break;
                        */
                        case 'pseudo': // il est obligatoire
    
                            if (!$this->form->testAlphaNumerique($valeur))
                            {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label. ' "' .$valeur.
                                    '", ' . $this->_trad['erreur']['aphanumeriqueSansSpace'];
    
                            } else {
    
                                // si la requete tourne un enregistreme, c'est que 'pseudo' est déjà utilisé en BDD.
                                if($this->userPseudoExist($valeur))
                                {
                                    $erreur = true;
                                    $this->form->msg .= '<br/>' . $this->_trad['erreur']['pseudoIndisponble'];
                                }
    
                            }
    
                            break;
    
                        case 'email': // il est obligatoire
    
                            if ($this->form->testFormatMail($valeur)) {
                                // si la requete retourne un enregisterme, c'est que 'email' est deja utilisé en BD.
                                if($this->userMailExist($valeur))
                                {
                                    $erreur = true;
                                    $this->form->_formulaire[$key]['message'] = '<br/>' . $this->_trad['erreur']['emailexistant'];
                                }
    
                            } else {
    
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label. ' "' .$valeur.
                                    '", ' . $this->_trad['erreur']['aphanumeriqueSansSpace'];
    
                            }
    
                            break;
    
                        case 'sexe':
    
                            if(empty($valeur))
                            {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': '.$this->_trad['erreur']['vousDevezChoisireUneOption'];
                            }
    
                            break;
    
                        case 'nom': // est obligatoire
                        case 'prenom': // il est obligatoire
                            if(!$this->form->testLongeurChaine($valeur) )
                            {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': '.$this->_trad['erreur']['nonVide'];
    
                            } elseif (!$this->form->testAlphaNumerique($valeur)){
    
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label. ' "' .$valeur.
                                    '", ' . $this->_trad['erreur']['aphanumeriqueSansSpace'] ;
    
                            }
    
    
                            break;
    
                        case 'telephone':
                        case 'gsm':
    
                            if(!empty($valeur)){
    
                                // un des deux doit être renseigné
                                $controlTelephone = false;
                                $valeur = str_replace(' ', '', $valeur);
    
                                if (isset($info['length']) && (strlen($valeur) < $info['length'] || strlen($valeur)> $info['length']+4))
                                {
    
                                    $erreur = true;
                                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label.
                                        ': ' . $this->_trad['erreur']['doitContenir'] . $info['length'] . $this->_trad['erreur']['caracteres'];
                                }
    
                                if($this->form->testNumerique($valeur))
                                {
                                    $erreur = true;
                                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                        ': '.$this->_trad['erreur']['queDesChiffres'];
    
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

                        default:
                            if(!empty($valeur) && !$this->form->testLongeurChaine($valeur))
                            {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': '.$this->_trad['erreur']['minimumAphaNumerique'].' ' . $minLen . ' '.$this->_trad['erreur']['caracteres'];
    
                            }
    
                    }
    
                    // Construction de la requettes
                    if(!empty($valeur)){
                        $sql_champs .= ((!empty($sql_champs))? ", " : "") . $key;
                        $sql_Value .= ((!empty($sql_Value))? ", " : "") .
                                      (($info['content'] != 'int' AND $info['content'] != 'float')? "'$valeur'" : $valeur) ;
                    }
                }
        }
    
        // control sur les numero de telephones
        // au moins un doit être renseigné
        if($controlTelephone) {
            $erreur = true;
            $this->form->_formulaire['telephone']['message'] =  $this->_trad['erreur']['controlTelephone'] ;
        }
        // si une erreur c'est produite
        if($erreur)
        {
            $this->form->msg = '<div class="alert">'.$this->_trad['ERRORSaisie']. $this->form->msg . '</div>';
    
        } else {
            $checkinscription = hashCrypt($sql_Value);
            if($this->userInscriptionInsert($sql_champs, $sql_Value, $checkinscription, $this->form->_formulaire)){
                $this->form->msg = $this->envoiMailInscrition($checkinscription, $this->form->_formulaire);
            } else {
                $this->form->msg = $this->_trad['erreur']['inconueConnexion'];
            }
        }
    
        //return $msg;
    }
    
    protected function actifUser()
    {
        //$this->_trad
    
        //include FUNC . 'form.func.php';
        // recuperation du pseudo
        if (empty($_POST) && isset($_COOKIE['Intelligent']['pseudo'])) {
            $_POST['valide'] = 'cookie';
            $_POST['mdp'] = '';
            $_POST['pseudo'] = $_COOKIE['Intelligent']['pseudo'];
            $_POST['rapel']['on'] = 'on';
        }
    
        // traitement du formulaire
        $this->form->msg = '';
        if (isset($_POST['valide']) && $this->form->postCheck()) {
            $this->form->msg = ($_POST['valide'] == 'cookie') ? 'cookie' : $this->connectionValider();
        }
    
        $form = '';
        // affichage des messages d'erreur
        if ('OK' == $this->form->msg) {
            // l'utilisateur est automatiquement connécté
            // et re-dirigé ver l'accueil
            urlSuivante();
            /*$_nav = 'index.php';
            if (utilisateurAdmin()){
                $_nav = 'index.php?nav=backoffice';
            }
            header('Location:'.$_nav);
            exit();*/
        }
        //return $msg;
    }
    
    protected function connectionValider()
    {
    
        global $minLen;
        //$this->_trad
    
        //$msg = '';
        $erreur = false;
        $sql_Where = '';
        $control = true;
        $message ='';
    
        if(!isset($_SESSION['connexion'])) $_SESSION['connexion'] = 3;
    
        foreach ($this->form->_formulaire as $key => $info){
    
            $label = $this->_trad['champ'][$key];
            $valeur = (isset($info['valide']))? $info['valide'] : NULL;
            $obligatoire = (!empty($info['obligatoire']))? true : false ;
    
            if('valide' != $key)
                if (isset($info['maxlength']) && !$this->form->testLongeurChaine($valeur, $info['maxlength']))
                {
    
                    $erreur = true;
                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] .$label.
                        ': ' . $this->_trad['erreur']['doitContenirEntre'] . $minLen .
                        ' et ' . $info['maxlength'] . $this->_trad['erreur']['caracteres'];
    
                } elseif ($this->form->testObligatoire($info) && empty($valeur)){
    
                    $erreur = true;
                    $this->form->_formulaire[$key]['message'] = $label . $this->_trad['erreur']['obligatoire'];
    
                } else {
    
                    switch($key){
                        case 'mdp':
                            $crypte = $key;
                            break;
    
                        case 'rapel':
                            $control = ($valeur == 'ok')? true : false;
                            break;
    
                        case 'pseudo':
    
                            if (!$this->form->testAlphaNumerique($valeur))
                            {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label. ' "' .$valeur.
                                    '", ' . $this->_trad['erreur']['aphanumeriqueSansSpace'];
                            }
    
                            break;
    
                        default:
                            if($obligatoire && !$this->form->testLongeurChaine($valeur) )
                            {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': '.$this->_trad['erreur']['minimumAphaNumerique'].' ' . $minLen . ' '.$this->_trad['erreur']['caracteres'];
                            }
                            break;
                    }
                    // Construction de la requettes
                    if($key != 'rapel' && $key != 'mdp') $sql_Where .= ((!empty($sql_Where))? " AND " : "") . $key.'="' . $valeur . '" ';
                }
        }
    
        if($erreur) // si la variable $msg est vide alors il n'y a pas d'erreurr !
        {  // le pseudo n'existe pas en BD donc on peut lancer l'inscription
    
            $this->form->msg .= '<br />'.$this->_trad['erreur']['uneErreurEstSurvenue'];
    
        } else {
    
            // lançons une requete nommee membre dans la BD pour voir si un pseudo est bien saisi.
            // verifions si dans la requete lancee, si le pseudo s'il existe un nbre de ligne superieur à 0. si c >0 c kil ya une ligne creee donc un pseudo existe
    
            if($session = $this->getUserConnexion($sql_Where)) // si la requete tourne un enregisterme,cest cest que le pseudo est deja utilisé en BD.
            {
                if(isset($crypte)){
                    $this->form->_formulaire[$crypte]['sql'] = $session[$crypte];
                    if(hashDeCrypt($this->form->_formulaire[$crypte])){
                        // overture d'une session Membre
                        if ($session['active'] == 1) {
                            ouvrirSession($session, $control);
                            $this->form->msg = 'OK';
                        } else if ($session['active'] == 2){
                            $this->form->msg .= $this->_trad['erreur']['validerInscriptionMail'] . $session['email'];
                        }
                        // on reinitialise les tentatives de connexion
                        unset($_SESSION['connexion']);
                    }
                }
    
    
            } else if (isset($session->num_rows)) {
                $this->form->msg .= '<br/ >'. $this->_trad['erreur']['erreurConnexion'];
                $_SESSION['connexion'] -= 1;
    
            } else {
    
                $this->form->msg .= '<br />'. $this->_trad['erreur']['inconueConnexion'];
    
            }
    
    
        }
        return $this->form->msg;
    }
    
    protected function usersIdentifians()
    {
        return;
    }
    
    /**
     * @return string
     */
    protected function usersChangerMotPasse()
    {
    
        global $minLen;
    
        //$this->_trad
        $message = '';
        $sql_Where = '';
    
        $this->form->postCheck();
    
        foreach ($this->form->_formulaire as $key => $info){
    
            $label = $this->_trad['champ'][$key];
            $valeur = (isset($info['valide']))? $info['valide'] : NULL;
    
            if ('valide' != $key)
                if (isset($info['maxlength']) && (strlen($valeur) < $minLen  || strlen($valeur) > $info['maxlength']))
                {
    
                    $message.= '<div class="bg-danger message"> <p> Erreur ' .$label.
                        ': ' . $this->_trad['erreur']['doitAvoirNombreCaracterComprisEntre'] . ' ' . $minLen .
                        ' et ' . $info['maxlength'] . ' </p></div>';
    
                } else {
    
                    switch($key){
                        case 'mdp':
                            $crypte = $key;
                            break;
    
                        case 'pseudo':
                            $verif_caractere = preg_match('#^[a-zA-Z0-9._-]+$#', $valeur );
                            if (!$verif_caractere  && !empty($valeur))
                            {
                                $message.= '<div class="bg-danger message"> <p>' . $this->_trad['erreur']['surLe'] . ' ' .$label.
                                    ', ' . $this->_trad['erreur']['aphanumeriqueSansSpace'] . ' </p></div>';
                                // un message sans ecresser les messages existant avant. On place dans $msg des chaines de caracteres
                            }
                            break;
                    }
                    // Construction de la requettes
                    if ($key != 'mdp') $sql_Where .= ((!empty($sql_Where))? " AND " : "") . $key.'="' . $valeur . '" ';
                }
        }
    
        if (empty($message)) // si la variable $msg est vide alors il n'y a pas d'erreurr !
        {
            if ($membre = $this->usersSelectWhere($sql_Where))
            {
                if (isset($crypte) && hashDeCrypt($this->form->_formulaire[$crypte])){
                    $this->form->_formulaire[$crypte]['sql'] = $membre[$crypte];
                    if (hashDeCrypt($this->form->_formulaire[$crypte])){
                        // overture d'une session Membre
                        ouvrirSession($membre);
                        $message = 'OK';
                    }
                }
            } else {
                $message .= '<div class="bg-danger message"> <p>' . $this->_trad['erreur']['inconueConnexion'] . '! </p>';
            }
        }
    
        return $message;
    }
    
    protected function envoiMailChangeMDP($checkinscription, $membre)
    {
        //$this->_trad
        // message
        $message = '
         <html>
          <head>
           <title>Intelligent::Modification</title>
          </head>
          <body>
           <p>' . $this->_trad['Bonjour'] . ' ' . $membre['prenom'] . $membre['nom'] . '</p>
           <p>' . $this->_trad['validerChangementMotPasse'] . ' <a href="' . LINK . '?nav=validerChangementMDP&jeton='.
            $checkinscription . '">' . $this->_trad['valide'] . '</a></p>
          </body>
         </html>
         ';
    
        return (envoiMail($message, $membre['email']))? "OK" : "ERREUR SEND MAIL";
    }
    
    protected function envoiMailInscrition($checkinscription, $info)
    {
        //$this->_trad
        // message
        $message = '
         <html>
          <head>
           <title>Intelligent::Inscription</title>
          </head>
          <body>
           <p>' . $this->_trad['Bonjour'] . ' ' . $info['prenom']['valide'] . $info['nom']['valide'] . '</p>
           <p>' . $this->_trad['validerInscriptionMail'] . ' <a href="' . LINK . '?nav=validerInscription&jeton='.
            $checkinscription . '">' . $this->_trad['valide'] . '</a></p>
          </body>
         </html>
         ';
    
        return (envoiMail($message, $info['email']['valide']))? "OK" : "ERREUR SEND MAIL";
    }
    
    # Fonction modCheck()
    # Control des informations Postées
    # convertion avec htmlentities
    # $nomFormulaire => string nom du tableau
    # RETURN string alerte
    protected function modCheckMembres($_id)
    {
        $form = $this->form->_formulaire;
    
        if($user = $this->getUser($_id)) {
            foreach($form as $key => $info){
                if($key != 'valide' && key_exists ( $key , $user )){
                    $this->form->_formulaire[$key]['valide'] = $user[$key];
                    $this->form->_formulaire[$key]['sql'] = $user[$key];
                }
            }
        }
    
        return true;
    }
    
    protected function userMDP($jeton)
    {
        //$this->_trad
        include PARAM . 'userMDP.param.php';
        // include FUNC . 'form.func.php';
        $this->form->_formulaire = $_formulaire;

        //$msg =
        $form = '';
        $id_membre = $this->selecMembreJeton($jeton);
        $_jeton = false;
        if ($_POST) {
    
            if ($jeton != $_POST['jeton']) {
                //tentative de détournement
                header('location:index.php?nav=expiration');
            }
    
            $this->form->_formulaire['jeton']['defaut'] = $_POST['jeton'];
            if (isset($_POST['valide']) && $this->form->postCheck(true)) {
                $this->mdpValider();
            }
            // affichage des messages d'erreur
            if ('OK' == $this->form->msg) {
                $this->updateMembreJeton($id_membre);
                header("refresh:5;url=index.php?nav=actif");
                exit();
            } else {
                $form = $this->form->formulaireAfficher();
            }
    
        } else {
            if ($id_membre) {
                $this->form->_formulaire['jeton']['defaut'] = $jeton;
                $form = $this->form->formulaireAfficher();
            } else {
                header("refresh:5;url=index.php?nav=expiration");
            }
        }
        include VUE . 'users/userMDP.tpl.php';
    }
}