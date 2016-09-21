<?php
# FUNCTIONS FORMULAIRES

# Fonction postCheck() 
# Control des informations Postées
# convertion avec htmlentities
# $nomFormulaire => string nom du tableau
# RETURN string alerte
/*function postCheck(&$_formulaire, $mod=FALSE)
{
	if(isset($_POST['valide'])){
		return postValide($_formulaire, $mod);
	}
	return true;
}*/

# Fonction formulaireAfficher()
# Mise en forme des differents items du formulaire
#$_form => tableau des items
# RETURN string du formulaire
/*function formulaireAfficher($_form)
{

	$_trad = setTrad();
	//global $_formIncription;
	$formulaire = '';
	foreach($_form as $champ => $info){
		$ligneForm = ($info['type'] == 'file' OR $info['type'] == 'textarea' )? "ligneFile" : "ligneForm";
		$trad = ($champ == 'valide')? '' : $_trad['champ'][$champ];
		if($info['type'] != 'hidden') {
			$formulaire .=  '
			<div class="'. $ligneForm . ' ' . ((!empty($info['rectification']))? ' rectifier' : '') .'">
				<label class="label">' .  $trad;
			$formulaire .= (isset($info['obligatoire']))? '<span class="alert">*</span>': '';
			$formulaire .= '</label>';
			$formulaire .= '<div class="champs">' . typeForm($champ, $info) . '</div>';
			
			if(!empty($info['rectification']))
			{
			$formulaire .=  '
				<label class="label rectifier">'. $_trad['rectifier'] .' '.$_trad['champ'][$champ].' </label>
				<div class="champs">' . typeForm($champ.'2', $info) . '</div>';
			}
			$formulaire .= ((isset($info['message']))? '<div class="erreur">' .$info['message']. '</div>': '') . '</div>';
		
		} else $formulaire .= typeForm($champ, $info);
		
	}
	
	return $formulaire; // texte
}*/

# Fonction typeForm() de mise en forme des differents balises html
# $champ => nom de l'item
# $info => tableau des informations relatives a l'item
# RETURN [balises] texte
/*function typeForm($champ, $info)
{
	

	$_trad = setTrad();

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
				$check = radioCheck($info, $value)? 'checked' : ''; 
				$balise .= $_trad['value'][$value].' <input type="radio" class="radio-inline" id="' . $champ . $value . '" name="' . $champ . '" value="' .  $value. '" ' . $check . ' >';
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
				<option value="' .  $value . '" ' . $check . ' >'.$_trad['value'][$value].'</option>';
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
				$balise .= '<option value="' .  $key . '" ' . $check . ' >'.$_trad['value'][$value].'</option>';
			}
			// Balise par defaut
			$balise .= '</select>';

			return $balise;
		break;

		case 'checkbox':
			$balise = '';
			foreach($info['option'] as $key => $value){
				$check = checkboxCheck($info, $key)? 'checked="checked" ': '';
				$balise .=  $_trad['value'][$value] .
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
			return ($champ == 'statut')? $_trad['value'][$valeur] : $valeur;
			
	}
}*/

/*function inputMessage($form, $message)
{
	if(empty($form['message'])){
		return $message;
	} else {
		return $form['message'] . '<br>' . $message;
	}
}*/

# Fonction postValide()
# Control des informations Postées
# convertion avec htmlentities
# $nom_form => string nom du tableau des items
# [@$nom_form] tableau des items validées du formulaire
# $mod => condition pour une action de mise à jour en BDD
# RETURN string message d'alerte
function postValide($mod=FALSE)
{
	global $msg;
	//$_trad = setTrad();

	$ok = true;

	// on boucle sur les valeurs des champs
	$_form = $this->form->_formulaire;
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
						$this->form->_formulaire[$key]['message'] = $this->form->inputMessage($this->form->_formulaire[$key], $_trad['champ'][$key] . $_trad['erreur']['obligatoire']);
						$valide = '';

					}

					if (empty($valeur2)){

						// l'un des deux champs est remplie
						$ok = false;
						$this->form->_formulaire[$key]['message'] = $this->form->inputMessage($this->form->_formulaire[$key], $_trad['erreur']['veuillezDeRectifier'] . $_trad['champ'][$key]);
						$this->form->msg .= $_trad['erreur']['vousAvezOublieDeRectifier'] . $_trad['champ'][$key];
						$valide = '';

					}

					if ( !empty($valeur1) && !empty($valeur2) && $valeur1 != $valeur2){

						// les deux valeurs sont differents
						$ok = false;
						$this->form->_formulaire[$key]['message'] = $this->form->inputMessage( $this->form->_formulaire[$key], $_trad['erreur']['deuxValeursDifferents'] . $_trad['champ'][$key]);
						$this->form->msg .= $_trad['erreur']['vousAvezUneErreurDans'] . $_trad['champ'][$key];
						$valide = '';
					}
				}
			}

				$this->form->_formulaire[$key]['valide'] = (
					($info['type'] != 'radio' && $info['type'] != 'checkbox')
					&& $valide == $info['defaut'])? '' : $valide;


		} else if ($info['type'] == 'file'){
			if (isset($_FILES[$key])){
				$this->form->_formulaire[$key]['valide'] = $_FILES[$key]['name'];
			}
		} else if ($info['type'] == 'checkbox'){
			
			$ok = ($this->form->testObligatoire($info) && empty($valeur))? false : $ok;


		} else if (!$mod && $key != 'valide'){

			// si le champs n'est pas présent dans POST
			$ok = false;
			$this->form->_formulaire[$key]['valide'] = '';
			$this->form->_formulaire[$key]['message'] = $_trad['erreur']['ATTENTIONfaitQuoiAvec']. $_trad['champ'][$key] . '?';
			$this->form->msg .= $_trad['erreur']['corrigerErreurDans'];
		
		}
	}
	
	return $ok;
}

# Fonction radioCheck()
# Vérifie la valeur du check 
# $info => array(...'valide'), valeurs du champs
# $value => valeur à comparer
# RETURN string
/*function radioCheck($info, $value)
{
	// info['valide'] => valeur du formulaire
	return (!empty($info['valide']) && $info['valide'] == $value)? true : false;

}*/

# Fonction radioCheck()
# Vérifie la valeur du check
# $info => array(...'valide'), valeurs du champs
# $value => valeur à comparer
# RETURN string
/*function checkboxCheck($info, $value)
{
	// info['valide'] => valeur du formulaire
	return (!empty($info['valide']) && in_array($value, $info['valide']))? true : false;

}*/

# Fonction selectCheck()
# Vérifie la valeur du check 
# $info => array(...'valide'), valeurs du champs
# $value => valeur à comparer
# RETURN string
/*function selectCheck($info, $value)
{
	// info['valide'] => valeur du formulaire
	return (!empty($info['valide']) && $info['valide'] == $value)? 'selected="selected"' : '';

}*/

# Fonction testNumerique()
# Vérifie la valeur alphanumerique d'une chaine de caracteres 
# $value => valeur à tester
# RETURN Boolean
/*function testNumerique($valeur)
{
	return preg_match('#[a-zA-Z.\s.-]#', $valeur);

}*/

# Fonction testAlphaNumerique()
# Vérifie la valeur alphanumerique d'une chaine de caracteres 
# $value => valeur à tester
# RETURN Boolean
/*function testAlphaNumerique($valeur)
{
	return preg_match('#^[a-zA-Z0-9._-]+$#', $valeur );

}*/

# Fonction testFormatMail()
# Vérifie la valeur alphanumerique d'une chaine de caracteres 
# $value => valeur à tester
# RETURN Boolean
/*function testFormatMail($valeur)
{
	return filter_var($valeur, FILTER_VALIDATE_EMAIL);

}*/

# Fonction testObligatoire()
# Vérifie la valeur alphanumerique d'une chaine de caracteres 
# $value => valeur à tester
# RETURN Boolean
/*function testObligatoire($info)
{
	return isset($info['obligatoire'])? $info['obligatoire'] : false;			

}*/

# Fonction testLongeurChaine()
# Vérifie la longeure d'une chaine de caracteres 
# $value => valeur à tester
# $maxLen => limite maximal 250 par default
# @minLen => limite minimal établi par default
# RETURN Boolean true si authorizé
/*function testLongeurChaine($valeur, $maxLen=250)
{
	global $minLen;
	
	$taille = strlen(html_entity_decode($valeur));
	_debug("$taille < $minLen  || $taille > $maxLen", __FUNCTION__);

	return ($taille < $minLen  || $taille > $maxLen)? false : true;

}*/

# Fonction AfficherInfo()
# Mise en forme des differents items du formulaire
#$_form => tableau des items
# RETURN string du formulaire
function AfficherInfo($_form)
{
	//$_trad = setTrad();
	//global $_formIncription;
	$formulaire = array();
	foreach($_form as $champ => $info){
		$value = isset($info['valide'])? html_entity_decode($info['valide']) : '';
		if($info['type'] != 'hidden')
		{
			if($champ == 'valide'){
				$formulaire[$champ] = typeForm($champ, $info);

			} else{
				if($info['type'] == 'file') {
					$formulaire[$champ] = '<img src="' . imageExiste($value) . '">';
				}
				else {
					$formulaire[$champ] =
						(isset($info['option'])
							? ((array_key_exists($value, $_trad['value']))?
								$_trad['value'][$value] : $_trad['value']['indefini'])
							: $value );
				}
			}
		} elseif(isset($info['acces'])) {
			$formulaire[$champ] = typeForm($champ, $info);
		}
	}

	return $formulaire; // texte
}

# Fonction formulaireAfficherInfo()
# Mise en forme des differents items du formulaire
#$_form => tableau des items
# RETURN string du formulaire
/*function formulaireAfficherInfo($_form)
{
	$_trad = setTrad();
	//global $_formIncription;
	$formulaire = '';
	foreach($_form as $champ => $info){
		$ligneForm = ($info['type'] == 'file' OR $info['type'] == 'textarea' )? "ligneFile" : "ligneForm";
		$value = isset($info['valide'])? html_entity_decode($info['valide']) : '';
		if($info['type'] != 'hidden') 
		{
			if($champ == 'valide'){
				$formulaire .=  '
				<div class="ligneForm" >
					<label class="label" >&nbsp;</label>
					<div class="champs">' . typeForm($champ, $info) . '</div>
				</div>';
				
			} else{
				$formulaire .=  '
				<div class="' . $ligneForm . '" >
					<label class="label" >' . $_trad['champ'][$champ] ;
				if($info['type'] == 'file') {
					$formulaire .= '</label>
						<div class="champs"><img src="' . imageExiste($value) . '">	</div>
					</div>';
				}
				else {
					$formulaire .= '</label>
						<div class="champs">' .
							(isset($info['option'])
								? ((array_key_exists($value, $_trad['value']))?
									$_trad['value'][$value] : $_trad['value']['indefini'])
								: $value ) . '</div>
					</div>';
				}
			}
		} elseif(isset($info['acces'])) {
			$formulaire .= typeForm($champ, $info);
		}
	}
	
	return $formulaire; // texte
}*/

# Fonction formulaireAfficherMod()
# Mise en forme des differents items du formulaire
#$_form => tableau des items
# RETURN string du formulaire
/*function formulaireAfficherMod()
{
	//$_trad = setTrad();
	//global $_formIncription;
	exit();
	$formulaire = '';

	foreach($this->form->_formulaire as $champ => $info){
		$ligneForm = ($info['type'] == 'file' OR $info['type'] == 'textarea' )? 'ligneFile' : 'ligneForm';
		$value = isset($info['valide'])? html_entity_decode($info['valide']) : '';
		if($champ == 'sexe') {
			if(isset($this->_trad['value'][$value]))
				$value = $this->_trad['value'][$value];
			else{
				$info['type'] = 'select';
			}
		}
		
		if($info['type'] != 'hidden'){

			if(!isset($info['obligatoire']) || utilisateurAdmin()){
				$label = key_exists($champ, $this->_trad['champ'])? $this->_trad['champ'][$champ] : $champ;
				$formulaire .=  '
				<div class="' . $ligneForm . '" >
					<label class="label" >' . (($champ != 'valide')? $label : '&nbsp;') . '</label>
					<div class="champs">' . $this->typeForm($champ, $info);

				$formulaire .= '</div>
				</div>';
				
				if(!empty($info['rectification']))
				{
				$formulaire .=  '
				<div class="' . $ligneForm . '" >
					<label class="label rectifier" style="color:red">Rectifier</label>
					<div class="champs">' . $this->typeForm($champ.'2', $info) . '</div>
				</div>';
				}
				
				$formulaire .= ((isset($info['message']))? '<div class="erreur">' .$info['message']. '</div>': '');
			
			} elseif($champ != 'statut'){
				$formulaire .=  '
				<div class="' . $ligneForm . '" >
					<label class="label" >' . $_trad['champ'][$champ] ;
				$formulaire .= '</label>
					<div class="champs">' . $value . '</div>
				</div>';
			}
		
		} else $formulaire .= $this->typeForm($champ, $info);
	}
	
	return $formulaire; // texte
}*/

# Fonction controlImageUpload()
# Upload des images dans le repertoire photo
#$key => champ
#$info => donées relatives au champ
# RETURN boolean
/*function controlImageUpload($key, &$info, $nomImage = 'image')
{
	//$_trad = setTrad();
	// Tableaux de donnees
	$tabExt = array("jpg","gif","png","jpeg");    // Extensions autorisees
	$infosImg = array();
	$info['valide'] = '';

	if( !empty($_FILES[$key]['name']) )
	{
		// Recuperation de l'extension du fichier
		$extension  = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));

		// On verifie l'extension du fichier
		if(in_array($extension,$tabExt))
		{
			// On recupere les dimensions du fichier
			$infosImg = getimagesize($_FILES[$key]['tmp_name']);

			// On verifie le type de l'image
			if($infosImg[2] >= 1 && $infosImg[2] <= 14)
			{
				// On verifie les dimensions et taille de l'image;
				if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES[$key]['tmp_name']) <= MAX_SIZE))
				{
					// Parcours du tableau d'erreurs
					if(isset($_FILES[$key]['error']) && UPLOAD_ERR_OK === $_FILES[$key]['error'])
					{
						// On renomme le fichier
						$nomImage .= '_' . uniqid() . '.' . $extension;

						// Si c'est OK, on teste l'upload
						if(move_uploaded_file($_FILES[$key]['tmp_name'], TARGET.$nomImage))
						{

							$info['valide'] = $nomImage;
							return false;

						} else {
							// Sinon on affiche une erreur systeme

							$info['message'] = $_trad['erreur']['problemeLorsUpload'];
						}
					} else {
						$info['message'] = $_trad['erreur']['erreurInterneEmpecheUplaodImage'];
					}
				} else {
					// Sinon erreur sur les dimensions et taille de l'image
					$info['message'] = $_trad['erreur']['erreurDansDimensionsImage'];
				}
			} else {
				// Sinon erreur sur le type de l'image
				$info['message'] = $_trad['erreur']['fichierUploaderNestPasUneImage'];
			}
		} else {
			// Sinon on affiche une erreur pour l'extension
			$info['message'] = $_trad['erreur']['extensionFichierEstIncorrecte'];
		}
	} else {
		// Sinon on affiche une erreur pour le champ vide
		$info['message'] = $_trad['erreur']['veuillezRemplirFormulaire'];
	}

	echo __FUNCTION__ , '   ', $info['message'];
	return true;

}
*/
