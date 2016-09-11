<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 11/09/2016
 * Time: 07:33
 */

namespace App;


class formuliare
{
    var $_trad = '';
    var $_formulaire = '';
    var $mod = FALSE;
    var $msg = '';

    public function __construct()
    {
        $this->_trad = setTrad();
    }

    # Fonction postCheck()
    # Control des informations Postées
    # convertion avec htmlentities
    # $nomFormulaire => string nom du tableau
    # RETURN string alerte
    public function postCheck($mod=FALSE)
    {
        $this->mod = $mod;
        if(isset($_POST['valide'])){
            return $this->postValide();
        }
        return true;
    }

    # Fonction postValide()
    # Control des informations Postées
    # convertion avec htmlentities
    # $nom_form => string nom du tableau des items
    # [@$nom_form] tableau des items validées du formulaire
    # $mod => condition pour une action de mise à jour en BDD
    # RETURN string message d'alerte
    public function postValide()
    {
        $ok = true;

        // on boucle sur les valeurs des champs
        $_form = $this->_formulaire;
        foreach($_form as $key => $info){

            // on le verifie pas les actions en modification pour ce qui sont obligatoires
            if(isset($_POST[$key]) && $key != 'valide'){

                // on encode en htmlentities
                $valide = (!is_array($_POST[$key]))? htmlentities($_POST[$key], ENT_QUOTES) : $_POST[$key];
                // si le champ fait objet d'une rectification
                if(!empty($info['rectification'])){

                    $valeur1 = $_POST[$key];
                    $valeur2 = $_POST[$key.'2'];

                    // actions pour la modification
                    if(!empty($valeur1) OR !empty($valeur2)){

                        if (empty($valeur1)){

                            $ok = false;
                            $this->_formulaire[$key]['message'] = $this->inputMessage($this->_formulaire[$key], $this->_trad['champ'][$key] . $this->_trad['erreur']['obligatoire']);
                            $valide = '';

                        }

                        if (empty($valeur2)){

                            // l'un des deux champs est remplie
                            $ok = false;
                            $this->_formulaire[$key]['message'] = $this->inputMessage( $this->_formulaire[$key], $this->_trad['erreur']['veuillezDeRectifier'] . $this->_trad['champ'][$key]);
                            $this->msg .= $this->_trad['erreur']['vousAvezOublieDeRectifier'] . $this->_trad['champ'][$key];
                            $valide = '';

                        }

                        if ( !empty($valeur1) && !empty($valeur2) && $valeur1 != $valeur2){

                            // les deux valeurs sont differents
                            $ok = false;
                            $this->_formulaire[$key]['message'] = $this->inputMessage( $this->_formulaire[$key], $this->_trad['erreur']['deuxValeursDifferents'] . $this->_trad['champ'][$key]);
                            $this->msg .= $this->_trad['erreur']['vousAvezUneErreurDans'] . $this->_trad['champ'][$key];
                            $valide = '';

                        }
                    }


                }

                $this->_formulaire[$key]['valide'] = (
                    ($info['type'] != 'radio' && $info['type'] != 'checkbox')
                    && $valide == $info['defaut'])? '' : $valide;


            } else if ($info['type'] == 'file'){
                if (isset($_FILES[$key])){
                    $this->_formulaire[$key]['valide'] = $_FILES[$key]['name'];
                }
            } else if ($info['type'] == 'checkbox'){

                $ok = ($this->testObligatoire($info) && empty($valeur))? false : $ok;


            } else if (!$this->mod && $key != 'valide'){

                // si le champs n'est pas présent dans POST
                $ok = false;
                $this->_formulaire[$key]['valide'] = '';
                $this->_formulaire[$key]['message'] = $this->_trad['erreur']['ATTENTIONfaitQuoiAvec']. $this->_trad['champ'][$key] . '?';
                $this->msg .= $this->_trad['erreur']['corrigerErreurDans'];

            }
        }

        return $ok;
    }


    # Fonction inputMessage()
    # RETURN string message d'alerte
    public function inputMessage($form, $message)
    {
        if(empty($form['message'])){
            return $message;
        } else {
            return $form['message'] . '<br>' . $message;
        }
    }

    # Fonction formulaireAfficher()
    # Mise en forme des differents items du formulaire
    #$_form => tableau des items
    # RETURN string du formulaire
    public function formulaireAfficher()
    {
        //global $_formIncription;
        $formulaire = '';
        foreach($this->_formulaire as $champ => $info){
            $ligneForm = ($info['type'] == 'file' OR $info['type'] == 'textarea' )? "ligneFile" : "ligneForm";
            $trad = ($champ == 'valide')? '' : $this->_trad['champ'][$champ];
            if($info['type'] != 'hidden') {
                $formulaire .=  '
			<div class="'. $ligneForm . ' ' . ((!empty($info['rectification']))? ' rectifier' : '') .'">
				<label class="label">' .  $trad;
                $formulaire .= (isset($info['obligatoire']))? '<span class="alert">*</span>': '';
                $formulaire .= '</label>';
                $formulaire .= '<div class="champs">' . $this->typeForm($champ, $info) . '</div>';

                if(!empty($info['rectification']))
                {
                    $formulaire .=  '
				<label class="label rectifier">'. $this->_trad['rectifier'] .' '.$this->_trad['champ'][$champ].' </label>
				<div class="champs">' . $this->typeForm($champ.'2', $info) . '</div>';
                }
                $formulaire .= ((isset($info['message']))? '<div class="erreur">' .$info['message']. '</div>': '') . '</div>';

            } else $formulaire .= $this->typeForm($champ, $info);

        }

        return $formulaire; // texte
    }

    # Fonction typeForm() de mise en forme des differents balises html
    # $champ => nom de l'item
    # $info => tableau des informations relatives a l'item
    # RETURN [balises] texte
    public function typeForm($champ, $info)
    {
        $valeur = (!empty($info['valide']) && !is_array($info['valide']))?
            html_entity_decode((!empty($info['valide']))? $info['valide'] : $info['defaut']) :
            ((!empty($info['valide']))? $info['valide'] : $info['defaut']);

        $check = (!empty($info['valide']))? 'checked' : '' ;
        $class = (!empty($info['class']))? $info['class'] : '';

        // valeur par defaut si il n'existe pas une information utilisateur
        // indication sur le champs
        $condition = (!empty($info['valide']))? 'value' : 'placeholder';

        switch($info['type']){

            case 'password':
                return '<input type="password" class="' . $class . '"   id="' . $champ . '" name="' . $champ . '" placeholder="' .  $info['defaut']. '" maxlength ="' . $info['maxlength'] . '">';
                break;

            case 'email':
                return '<input type="email" class="' . $class . '"   id="' . $champ . '" name="' . $champ . '" ' . $condition . '="' .  $valeur. '" >';

                break;

            case 'radio':
                $balise = '';
                foreach($info['option'] as $value){
                    $check = $this->radioCheck($info, $value)? 'checked' : '';
                    $balise .= $this->_trad['value'][$value].' <input type="radio" class="radio-inline" id="' . $champ . $value . '" name="' . $champ . '" value="' .  $value. '" ' . $check . ' >';
                }
                // Balise par defaut
                $balise .= '<input type="radio" class="radio-inline" id="' . $champ . '" name="' . $champ . '" value="" ' . (empty($info['valide'])? 'checked' : '') . ' style="visibility:hidden;" >';

                return $balise;
                break;

            case 'select':

                $balise = '
			<select class=" " id="' . $champ . '" name="' . $champ . '">';
                foreach($info['option'] as $value){
                    $check = selectCheck($info, $value);
                    $balise .= '
				<option value="' .  $value . '" ' . $check . ' >'.$this->_trad['value'][$value].'</option>';
                }
                // Balise par defaut
                $balise .= '
			</select>';

                return $balise;
                break;

            case 'selectTableau':

                $balise = '<select class=" " id="' . $champ . '" name="' . $champ . '">';
                foreach($info['option'] as $key=>$value){
                    $check = selectCheck($info, $key);
                    $balise .= '<option value="' .  $key . '" ' . $check . ' >'.$this->_trad['value'][$value].'</option>';
                }
                // Balise par defaut
                $balise .= '</select>';

                return $balise;
                break;

            case 'checkbox':
                $balise = '';
                foreach($info['option'] as $key => $value){
                    $check = $this->checkboxCheck($info, $key)? 'checked="checked" ': '';
                    $balise .=  $this->_trad['value'][$value] .
                        '<input type="checkbox" class="radio-inline" id="' . $champ . $key .'" name="' . $champ . '[' . $key . ']" '.  $check .'>';
                }
                return $balise;
                break;

            case 'textarea':
                $balise = '
					<textarea id="' . $champ . '"  name="' . $champ . '" class="' . $class . '"   placeholder="' . $info['defaut'] . '">' . $valeur . '</textarea>';
                return $balise;
                break;

            case 'hidden':
                $value = isset($info['acces'])? $info['defaut'] : $valeur;
                return '<input type="hidden" class="' . $class . '"   name="' . $champ . '" value="' .  $value. '">';
                break;

            case 'text':
                $maxlength = (isset($info['maxlength']) AND !empty($info['maxlength']))? ' maxlength ="' . $info['maxlength'] . '"' : '';
                return '<input type="text" class="' . $class . '"   name="' . $champ . '" ' . $condition . '="' .  $valeur. '" ' . $maxlength . '>';
                break;

            case 'file':
                // $maxlength = (isset($info['maxlength']) AND !empty($info['maxlength']))? ' maxlength ="' . $info['maxlength'] . '"' : '';
                $image = '';
                if(isset($info['sql'])){
                    $image = '<img class="trombi" src="' . imageExiste($info['sql']) . '" >';
                }
                return $image . '<input type="file" class="' . $class . '"   name="' . $champ . '" >';
                break;

            case 'submit':
                $boutton = '<input type="submit" class="' . $class . '"   name="' . $champ . '" value="' . $valeur. '">';
                if(isset($info['annuler']))
                    $boutton .= '<input type="submit" class="' . $class . '"   name="' . $champ . '" value="' . $info['annuler'] . '">';
                if(isset($info['origin']))
                    $boutton .= '<input type="hidden" class="' . $class . '"   name="origin" value="' . $valeur . '">';
                return $boutton;
                break;

            default:
                return ($champ == 'statut')? $this->_trad['value'][$valeur] : $valeur;

        }
    }

    # Fonction radioCheck()
    # Vérifie la valeur du check
    # $info => array(...'valide'), valeurs du champs
    # $value => valeur à comparer
    # RETURN string
    public function radioCheck($info, $value)
    {
        // info['valide'] => valeur du formulaire
        return (!empty($info['valide']) && $info['valide'] == $value)? true : false;

    }

    # Fonction testObligatoire()
    # Vérifie la valeur alphanumerique d'une chaine de caracteres
    # $value => valeur à tester
    # RETURN Boolean
    public function testObligatoire($info)
    {
        return isset($info['obligatoire'])? $info['obligatoire'] : false;

    }

    # Fonction testLongeurChaine()
    # Vérifie la longeure d'une chaine de caracteres
    # $value => valeur à tester
    # $maxLen => limite maximal 250 par default
    # @minLen => limite minimal établi par default
    # RETURN Boolean true si authorizé
    public function testLongeurChaine($valeur, $maxLen=250)
    {
        global $minLen;

        $taille = strlen(html_entity_decode($valeur));
        _debug("$taille < $minLen  || $taille > $maxLen", __FUNCTION__);

        return ($taille < $minLen  || $taille > $maxLen)? false : true;

    }

    # Fonction testAlphaNumerique()
    # Vérifie la valeur alphanumerique d'une chaine de caracteres
    # $value => valeur à tester
    # RETURN Boolean
    public function testAlphaNumerique($valeur)
    {
        return preg_match('#^[a-zA-Z0-9._-]+$#', $valeur );

    }

    # Fonction radioCheck()
    # Vérifie la valeur du check
    # $info => array(...'valide'), valeurs du champs
    # $value => valeur à comparer
    # RETURN string
    public function checkboxCheck($info, $value)
    {
        // info['valide'] => valeur du formulaire
        return (!empty($info['valide']) && in_array($value, $info['valide']))? true : false;

    }


}