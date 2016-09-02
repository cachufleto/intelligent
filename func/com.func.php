<?php

# Fonction connectMysqli()
# connection à SQL
# $req => string SQL
# BLOQUANT
# RETURN object
function connectMysqli()
{

	global $BDD;

	$connexion = @new mysqli($BDD['SERVEUR_BDD'], $BDD['USER'], $BDD['PASS'], $BDD['BDD']);

	// Jamais de ma vie je ne metterais un @ pour cacher une erreur sauf si je le gere proprement avec ifx_affected_rows
	if($connexion->connect_error) {
		die("Un probleme est survenu lors de la connexion a la BDD" . $connexion->connect_error);
	}

	$connexion->set_charset("utf-8"); // en cas de souci d'encodage avec l'utf-8
	
	//$connexion->host_info;
	
	return $connexion;

}

# Fonction executeRequete()
# Exe requette SQL
# $req => string SQL
# BLOQUANT
# RETURN object
function executeRequete($req)
{
	$_trad = setTrad();

	_debug($req, 'SQL REQUETTE');

	$connexion = connectMysqli();

	$resultat = $connexion->query($req);

	if(!$resultat) {
		die ($_trad['erreur']['ATTENTIONErreurSurRequeteSQL'] . $req . '<br /><b>---> : </b>' . $connexion->error . '<br />');
	}

	// deconnectMysqli();
	$connexion->close() or die ($_trad['erreur']['ATTENTIONImpossibleFermerConnexionBDD'] . ${$connexion}->error . '<br />');
	
	return $resultat;
}

function executeRequeteInsert($req)
{
	$_trad = setTrad();

	_debug($req, 'SQL INSERTION');

	$connexion = connectMysqli();

	$resultat = $connexion->query($req);

	if(!$resultat) {

		die ($_trad['erreur']['ATTENTIONErreurSurRequeteSQL']);// . $req . '<br /><b>---> : </b>' . $connexion->error . '<br />');
	}

	// deconnectMysqli();
	$resultat = $connexion->insert_id;
	$connexion->close() or die ($_trad['erreur']['ATTENTIONImpossibleFermerConnexionBDD'] . ${$connexion}->error . '<br />');
	return $resultat;
}

# Fonction executeMultiRequete()
# Exe requette SQL
# $req => string SQL
# BLOQUANT
# RETURN object
function executeMultiRequete($req)
{

	$_trad = setTrad();

	$connexion = connectMysqli();
	_debug($req, 'SQL Multi - REQUETTE');

	if ($connexion->multi_query($req)) {

		$i = 0;
		do {
			$connexion->next_result();

			$i++;
		}
		while( $connexion->more_results() );

		$connexion->close() or die ($_trad['erreur']['ATTENTIONImpossibleFermerConnexionBDD'] . ${$connexion}->error . '<br />');

		return true;
	}

	$connexion->close() or die ($_trad['erreur']['ATTENTIONImpossibleFermerConnexionBDD'] . ${$connexion}->error . '<br />');
	return false;

}

# Fonction hashCrypt()
# RETURN string crypt
function hashCrypt ($chaine)
{

	global $options;
	return password_hash($chaine, PASSWORD_BCRYPT, $options);

}

# Fonction hashCrypt()
# RETURN string crypt
function hashDeCrypt ($info)
{

	//password_verify($password, $hash)
	return password_verify($info['valide'], $info['sql']);

}

function ouvrirSession($session, $control = false)
{

	$_SESSION['user'] = array(
		'id'=>$session['id'],
		'pseudo'=>$session['pseudo'],
		'statut'=>$session['statut'],
		'user'=>$session['prenom']);

	$control = ($session['id'] == 1)? false : $control;

	setcookie( 'Intelligent[pseudo]' , ($control)? $session['pseudo'] : '' , time()+360000 );
}


# Fonction isSuperAdmin()
# Verifie SESSION ADMIN ACTIVE
# RETURN Boolean
function isSuperAdmin()
{
	
	return(utilisateurAdmin() AND $_SESSION['user']['id'] == 1)? true : false;

}

# Fonction utilisateurAdmin()
# Verifie SESSION ADMIN ACTIVE
# RETURN Boolean
function utilisateurAdmin()
{
	
	return(utilisateurConnecte() AND $_SESSION['user']['statut'] == 'ADM')? true : false;

}

# Fonction utilisateurAdmin()
# Verifie SESSION ADMIN ACTIVE
# RETURN Boolean
function utilisateurEstCollaborateur ()
{
	
	return(utilisateurConnecte() AND $_SESSION['user']['statut'] == 'COL')? true : false;

}

# Fonction utilisateurConnecte()
# Verifie SESSION ACTIVE
# RETURN Boolean
function utilisateurConnecte()
{

	return (!isset($_SESSION['user']))? false : true;
	
}


function envoiMail($message, $to = WEBMAIL)
{
	$_trad = setTrad();

	// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// En-têtes additionnels
	$headers .= 'To: ' . $to . "\r\n";
	$headers .= 'From: ' . $_trad['inscriptionIntelligent'] . ' <' . SITEMAIL . '>' . "\r\n";
	$headers .= 'Reply-To: carlos.dupriez@gmail.com' . "\r\n";
	$headers .=  'X-Mailer: PHP/' . phpversion();

	// Test d'envoi mode debug
	if (DEBUG) {
		echo "<div style='border: solid green'>TEST ENVOI MAIL: <br> $message</div>";
	}

	return mail($to, $_trad['votreCompteIntelligent'], $message, $headers);
}

function setTrad()
{
	// on charge la langue de base
	require CONF . 'trad/fr/traduction.php';
	// on surcharge la langue de l'utilisateur si different à celle de base
	if ($_SESSION['lang'] != 'fr') {
		include CONF . 'trad/' . $_SESSION['lang'] . '/traduction.php';
	}

	return $_trad;

}

function setPrixPlage()
{
	include CONF . 'parametres.param.php';
	return $_prixPlage;
}

function setPrixTranches()
{
	include CONF . 'parametres.param.php';
	return $_tranches;
}

function imageExiste($photo, $rep = 'photo')
{
	if(file_exists( RACINE_SERVER . RACINE_SITE . $rep . '/' . $photo)){
		return LINK . $rep . '/' . $photo;
	}
	return LINK . 'img/salles.jpg';
}


function urlSuivante()
{
	$_GET = isset($_SESSION['urlReservation'])? $_SESSION['urlReservation'] : $_GET;
	unset($_SESSION['urlReservation']);
	$url = isset($_GET['nav'])? '?nav='.$_GET['nav'] : false;
	if($url){
		foreach($_GET as $key => $info){
			$url .= ($key != 'nav')? "&$key=$info" : '';
		}
	}
	header('location:index.php'.$url);
}

function data_methodes($indice, $default = false)
{
	$data = (int)(isset($_POS[$indice])? $_POS[$indice] : $default);
	$data = (int)(isset($_GET[$indice])? $_GET[$indice] : $data);
	return $data;
}

function disponibilite()
{
	$_trad = setTrad();
	return "<form name='dispo' method='POST'>
			{$_trad['choisirDate']}
			<input type='date' name='date' value='{$_SESSION['date']}'>
			{$_trad['nombrePersonnes']}
			<input type='text' name='numpersonne' placeholder='Num. Pers.' value='{$_SESSION['numpersonne']}'>
			<input type='submit' name='' value='OK'>
		</form>";
}

function sortIndice($data)
{
	foreach ($data as $id => $info) {
		$sort[] = $id;
	}
	sort($sort);

	return $sort;
}

function recherchePernonnes(){
	if(!empty($_SESSION['numpersonne'])){
		$max = $_SESSION['numpersonne'] * 0.9;
		$min = $_SESSION['numpersonne'] * 1.1;
		return " AND capacite > $max AND 	cap_min < $min ";
	}
}

function listeCapacites($data, $info)
{
	//$_trad = setTrad();
	$_prixPlage = setPrixPlage();
	$_tranches = setPrixTranches();

	$prixSalle = [];
	$max = $data['capacite'];
	$min = ($data['cap_min']<=1)? intval($max * 0.3) : $data['cap_min'];
	$dif = $max - $min;
	$it = intval(str_replace('T', '', $data['tranche']));
	$delta = intval($dif/$it);

	for ($i=1; $i<=$it; $i++){
		$per = ($i != $it)? $min + $i*$delta : $max;
		$prix = $data['prix_personne'] * $_prixPlage[$info['id_plagehoraire']]['taux'] * $_tranches[$data['tranche']][$i];
		$prixSalle[$i]['id'] = $info['id'];
		$prixSalle[$i]['num'] = $per;
		$prixSalle[$i]['prix'] = $prix *$per;
		$prixSalle[$i]['prix_personne'] = $prix;
		$prixSalle[$i]['libelle'] = $_prixPlage[$info['id_plagehoraire']]['libelle'];
		$prixSalle[$i]['description'] = $info['description'];
	}
	return $prixSalle;
}

function reperDate($date)
{
	$date = empty($date)? date('Y-m-d') : $date;
	$__date = explode('-',$date);
	$__date = "{$__date[2]}/{$__date[1]}/{$__date[0]}";

	$form = ($date != $_SESSION['date'])? "<form name='dispo' method='POST'>
                                <input type='hidden' name='date' value='$date'>
                                <input type='submit' name='' value='$__date'>
                            </form>" : "<input style='background-color: #6D1907' type='button' value='$__date'>";
	return $form;
}

function controldate()
{
	$control = $_SESSION['date'];
	$__date = isset($_POST['date'])? $_POST['date'] : (isset($_GET['reservee'])? $_GET['reservee'] : false );
	if($__date){
		// contrôl de la date inferieur à la date du jour
		$dateMin = time()+(60*60*24);
		$now = mktime(0,0,0,date('m', $dateMin),date('d', $dateMin),date('Y', $dateMin));
		$control = date('Y-m-d', $dateMin);
		if(preg_match('#^20(1|2)[0-9]-(0|1)[0-9]-[0-3][0-9]#' , $__date)){
			$date = explode('-', $__date);
			_debug($date, '$date');
			if(checkdate($date[1],$date[2],$date[0])){
				$timePost = mktime(0,0,0,$date[1],$date[2],$date[0]);
				if(isset($_POST['date']) AND $timePost > $now){
					$_SESSION['date'] =  $__date;
				} else {
					$_SESSION['date'] = $__date;
				}

				$_SESSION['dateTimeOk'] = ($timePost > $now)? true : false;

			}
		}
	}

	return $control;
}

