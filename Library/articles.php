<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 13/05/2016
 * Time: 23:54
 */

namespace App;

class articles extends \Model\articles
{
    public function __construct()
    {
        parent::__construct();
        $this->getIndisponibilite();
    }

    protected function ListeDistinc($champ, $table, $info)
    {
        //$this->_trad
        $balise = '<select class=" " id="' . $champ . '" name="' . $champ . '">';
        $result = $this->selectListeDistinc($champ, $table);
        while($data = $result->fetch_assoc()){
            $value = $data[$champ];
            $libelle = (isset($this->_trad['value'][$value]))? $this->_trad['value'][$value] : $value;
            $check = $this->form->selectCheck($info, $value);
            $balise .= '<option value="' .  $value . '" ' . $check . ' >'.$libelle.'</option>';
        }
        // Balise par defaut
        $balise .= '</select>';
    
        return $balise;
    }
    
    # Fonction modCheck()
    # Control des informations Postées
    # convertion avec htmlentities
    # $nomFormulaire => string nom du tableau
    # RETURN string alerte
    protected function modCheckProduits($_id)
    {
    
        $sql = "SELECT id_plagehoraire FROM produits WHERE id_article = ". $_id ;
    
        $data = $this->executeRequete($sql) or die ($sql);
        if($data->num_rows < 1) return false;
    
        while ($produit = $data->fetch_assoc()){
            $this->form->_formulaire['plagehoraire']['valide'][] = $produit['id_plagehoraire'];
            $this->form->_formulaire['plagehoraire']['sql'][] = $produit['id_plagehoraire'];
        }
    
        return true;
    }
    
    # Fonction modCheck()
    # Control des informations Postées
    # convertion avec htmlentities
    # $nomFormulaire => string nom du tableau
    # RETURN string alerte
    protected function modCheckArticles($_id)
    {
        $form = $this->form->_formulaire;
    
        $sql = "SELECT * FROM articles WHERE id_article = ". $_id . ( !isSuperAdmin()? " AND active != 0" : "" );
    
        $data = $this->executeRequete($sql) or die ($sql);
        $user = $data->fetch_assoc();
    
        if($data->num_rows < 1) return false;
    
        foreach($form as $key => $info){
            if($key != 'valide' && key_exists ( $key , $user )){
                $this->form->_formulaire[$key]['valide'] = $user[$key];
                $this->form->_formulaire[$key]['sql'] = $user[$key];
            }
        }
    
        return true;
    }
    
    # Fonction modCheck()
    # Control des informations Postées
    # convertion avec htmlentities
    # $nomFormulaire => string nom du tableau
    # RETURN string alerte
    protected function getArticles($_id)
    {
        $data = $this->selectArticleId($_id);
        if($data->num_rows < 1) {
            return false;
        }
        $article = $data->fetch_assoc();
        $fiche = array();
        foreach($article as $key=>$info){
            $fiche[$key] = html_entity_decode($info);
        }
        $fiche['produits'] = $this->listeProduitsReservation($fiche);
    
        $fiche['listePrix'] =  $this->listeProduitsReservationPrix($fiche);
    
        return $fiche;
    }
    
    protected function remplaceAccents($str, $charset='utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
    
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    
        return $str;
    }
    
    protected function nomImage()
    {
    
        $pays = (!empty($this->form->_formulaire['pays']['value']))? $this->form->_formulaire['pays']['value'] : $this->form->_formulaire['pays']['sql'];
        $ville = (!empty($this->form->_formulaire['ville']['value']))? $this->form->_formulaire['ville']['value'] : $this->form->_formulaire['ville']['sql'];
        $titre = (!empty($this->form->_formulaire['titre']['value']))? $this->form->_formulaire['titre']['value'] : $this->form->_formulaire['titre']['sql'];
        $nomImage = str_replace(' ', '_', $this->remplaceAccents($pays.'_'.$ville.'_'.$titre, $charset='utf-8'));
    
        return $nomImage;
    }
    
    
    protected function produitsValider()
    {
        global $minLen;
        //$this->_trad
    
        //$msg = '';
        $erreur = false;
        $sql_Where = '';
        $control = true;
        $message ='';
    
        foreach ($this->form->_formulaire as $key => $info){
    
            $label = $this->_trad['champ'][$key];
            $valeur = (isset($info['valide']))? $info['valide'] : NULL;
            if($this->form->testObligatoire($info) && empty($valeur)) {
                $erreur = true;
                $this->form->_formulaire[$key]['message'] = inputMessage(
                    $this->form->_formulaire[$key], $label . $this->_trad['erreur']['obligatoire']);
            }
    
            switch ($key){
                case 'plagehoraire':
                    break;
            }
        }
    
        if($erreur) // si la variable $msg est vide alors il n'y a pas d'erreurr !
        {  // le pseudo n'existe pas en BD donc on peut lancer l'inscription
    
            $this->form->msg .= '<br />'.$this->_trad['erreur']['uneErreurEstSurvenue'];
    
        }
    
        //return $msg;
    }
    
    # Fonction ficheArticlesValider()
    # Verifications des informations en provenance du formulaire
    # @_formulaire => tableau des items
    # RETURN string msg
    protected function ficheArticlesValider()
    {
        global $minLen;
        //$this->_trad
        //$msg =
        $erreur = false;
        $sql_set = '';
        // active le controle pour les champs telephone et gsm
        $controlTelephone = true;
    
        $id_article = $this->form->_formulaire['id_article']['sql'];
        $exclure = array('pos','valide','id_article','photo');
        foreach ($this->form->_formulaire as $key => $info){
    
            $label = $this->_trad['champ'][$key];
            $valeur = (isset($info['valide']))? $info['valide'] : NULL;
            if(!in_array($key,$exclure))
            {
                if($info['valide'] != $info['sql'])
                {
                    if (isset($info['maxlength']) && !$this->form->testLongeurChaine($valeur, $info['maxlength']) && !empty($valeur))
                    {
    
                        $erreur = true;
                        $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label.
                            ': ' . $this->_trad['erreur']['doitContenirEntre'] . $minLen .
                            ' et ' . $info['maxlength'] . $this->_trad['erreur']['caracteres'];
    
                    }
    
                    //if ('vide' != testObligatoire($info) && !testObligatoire($info) && empty($valeur)){
                    else if ($this->form->testObligatoire($info) && empty($valeur)){
    
                        $erreur = true;
                        $this->form->_formulaire[$key]['message'] = $label . $this->_trad['erreur']['obligatoire'];
    
                    } else {
    
                        switch($key){
    
                            case 'capacite':
                            case 'cap_min':
                            case 'tranche':
                                if(empty($valeur = intval($valeur)))
                                {
                                    $erreur = true;
                                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                        ': '.$this->_trad['erreur']['minimumNumerique'];
                                }
                                $this->form->_formulaire[$key]['valide'] = $valeur;
                                break;
    
                            case 'prix_personne':
                                if(($valeur = doubleval(str_replace(',', '.', $valeur))) < PRIX)
                                {
                                    $erreur = true;
                                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                        ': '.$this->_trad['erreur']['prixPersonne'];
                                    $valeur = PRIX;
                                }
                                $this->form->_formulaire[$key]['valide'] = $valeur;
                                break;
    
                            case 'photo':
    
                                $erreur = (controlImageUpload($key, $info))? true : $erreur;
                                $this->form->_formulaire[$key]['message'] = isset($info['message'])? $info['message'] : '' ;
                                $valeur = $info['valide'];
    
                            break;
    
                            case 'categorie':
                                if(empty($valeur))
                                {
                                    $erreur = true;
                                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                        ': '.$this->_trad['erreur']['vousDevezChoisireUneOption'];
                                }
    
                                break;
    
                            default:
                                $long = (isset($info['maxlength']))? $info['maxlength'] : 250;
                                if(!empty($valeur) && !$this->form->testLongeurChaine($valeur, $long))
                                {
                                    $erreur = true;
                                    $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                        ': '.$this->_trad['erreur']['minimumAphaNumerique'].' ' . $minLen . ' '.$this->_trad['erreur']['caracteres'];
    
                                }
    
                        }
                    }
                    // Construction de la requettes
                    $sql_set .= ((!empty($sql_set) && !empty($valeur))? ", " : "") . ((!empty($valeur))? "$key = '$valeur'" : '');
    
                }
            }
        }
    
        if(!$erreur && intval($this->form->_formulaire['capacite']['valide']*.9) < $this->form->_formulaire['cap_min']['valide']){
    
            $erreur = true;
            $this->form->_formulaire['cap_min']['message'] = $this->_trad['erreur']['surLe'] . $this->_trad['champ']['cap_min'] .
                ': '.$this->_trad['erreur']['capaciteMinSuperieur'];
            $this->form->_formulaire['cap_min']['valide'] = intval($this->form->_formulaire['capacite']['valide']*.9);
        }
    
        if($this->controlTranche()){
            $erreur = true;
            $this->form->_formulaire['tranche']['message'] = $this->_trad['erreur']['surLe'] . $this->_trad['champ']['tranche'] .
                ': '.$this->_trad['erreur']['repartitionTranche'];
        }
    
        // si une erreur c'est produite
        if($erreur)
        {
            $this->form->msg = '<div class="alert">'.$this->_trad['ERRORSaisie']. $this->form->msg . '</div>';
    
        }elseif(!empty($_FILES['photo']) && $_FILES['photo']['error'] != 4){
    
            $erreur = controlImageUpload('photo', $this->form->_formulaire['photo'], $this->nomImage())? true : $erreur;
            $valeur = $this->form->_formulaire['photo']['valide'];
    
            if(!$erreur){
                $sql_set .= ((!empty($sql_set))? ", " : "")."photo = '$valeur'";
            }
    
        }elseif(!empty($_FILES['photo']) && $_FILES['photo']['error'] == 4){
            $this->form->_formulaire['photo']['valide'] = $this->form->_formulaire['photo']['sql'];
        }
    
        if(!$erreur) {
    
            // mise à jour de la base des données
            if (!empty($sql_set)){
                $this->articlesUpdate($sql_set, $id_article);
            }
            else {
                //header('Location:' . LINK . '?nav=articles&pos=P-' . ($position -1) . '');
                header('Location:' . LINK . '?nav=articles&pos=P-0');
            }
            // ouverture d'une session
            $this->form->msg = "OK";
    
        }
    
        //return $msg;
    }
    
    protected function controlTranche()
    {
        $max = $this->form->_formulaire['capacite']['valide'];
        $min = $this->form->_formulaire['cap_min']['valide'];
        $tranche = $this->form->_formulaire['tranche']['valide'];
    
        if($max == $min AND $tranche != 1) {
            $this->form->_formulaire['tranche']['valide'] = 1;
            return true;
        }
    
        if( ($max - $min) < ($max*0.1) AND $tranche != 1) {
            $this->form->_formulaire['tranche']['valide'] = 1;
            return true;
        }
    
        if( ($max - $min) < ($max*0.2) AND $tranche > 2) {
            $this->form->_formulaire['tranche']['valide'] = 2;
            return true;
        }
    
        if( ($max - $min) < ($max*0.35) AND $tranche > 3) {
            $this->form->_formulaire['tranche']['valide'] = 3;
            return true;
        }
    
        if($tranche > 4) {
            $this->form->_formulaire['tranche']['valide'] = 4;
            return true;
        }
    
        return false;
    
    }

    # Fonction editerArticlesValider()
    # Verifications des informations en provenance du formulaire
    # @_formulaire => tableau des items
    # RETURN string msg
    protected function editerArticlesValider()
    {
    
        global $minLen;
        //$this->_trad
    
    
        //$msg =
        $erreur = false;
        $sql_champs = $sql_Value = '';
        // active le controle pour les champs telephone et gsm
        $controlTelephone = true;
    
        foreach ($this->form->_formulaire as $key => $info){
            _debug($info, $key);
            $label = $this->_trad['champ'][$key];
            $valeur = (isset($info['valide']))? $info['valide'] : NULL;
    
            if('valide' != $key && 'photo' != $key)
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
    
                        case 'capacite':
                        case 'cap_min':
                        case 'tranche':
                            if(empty($valeur = intval($valeur)))
                            {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': '.$this->_trad['erreur']['minimumNumerique'];
                            }
    
                            $this->form->_formulaire[$key]['valide'] = $valeur;
                            break;
    
                        case 'prix_personne':
                            if(($valeur = doubleval(str_replace(',', '.', $valeur))) < PRIX)
                            {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': '.$this->_trad['erreur']['prixPersonne'];
                                $valeur = PRIX;
                            }
                            $this->form->_formulaire[$key]['valide'] = $valeur;
                            break;
    
                        /*
                        case 'photo':
    
                        break;
                        */
                        case 'categorie':
    
                            if(empty($valeur))
                            {
                                $erreur = true;
                                $this->form->_formulaire[$key]['message'] = $this->_trad['erreur']['surLe'] . $label .
                                    ': '.$this->_trad['erreur']['vousDevezChoisireUneOption'];
                            }
    
                            break;
    
                        default:
                            $long = (isset($info['maxlength']))? $info['maxlength'] : 250;
                            if(!empty($valeur) && !$this->form->testLongeurChaine($valeur, $long))
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
                                      (($info['content'] != 'int' AND $info['content'] != 'float')? "'$valeur'" : "$valeur") ;
                    }
                }
        }
    
        // si une erreur c'est produite
        if($erreur)
        {
            $this->form->msg = '<div class="alert">'.$this->_trad['ERRORSaisie']. $this->form->msg . '</div>';
    
        }else{
    
            $nomImage  = trim($this->form->_formulaire['pays']['valide']);
            $nomImage .= '_' . trim($this->form->_formulaire['ville']['valide']);
            $nomImage .= '_' . trim($this->form->_formulaire['titre']['valide']);
            $nomImage .= str_replace(' ', '_', $nomImage);
    
            $erreur = controlImageUpload('photo', $this->form->_formulaire['photo'], $nomImage)? true : $erreur;
            $valeur = $this->form->_formulaire['photo']['valide'];
    
            if(!$erreur){
                $sql_champs .= ", photo";
                $sql_Value .= ",'$valeur'";
            }
    
        }
    
        if(!$erreur) {
    
            $this->form->msg = $this->setArticle($sql_champs, $sql_Value);//"OK";
    
        }
    
        //return $msg;
    }
    
    protected function orderArticlesValide()
    {
        if(isset($_SESSION['orderArticles']['orderActive'])){
            if(isset($_POST['ord']) AND $_POST['ord'] == 'active'){
                $_SESSION['orderArticles']['orderActive'] = !($_SESSION['orderArticles']['orderActive']);
            }
        } else {
            $_SESSION['orderArticles']['orderActive'] = false;
        }
    
        return ($_SESSION['orderArticles']['orderActive'])? "active ASC, " : '';
    }
    
    protected function selectArticlesReservations()
    {
        $liste = '';
        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $listeOrdenee = sortIndice($_SESSION["panier"]);
            foreach ($listeOrdenee as $key => $date) {
                foreach($_SESSION["panier"][$date] as $key => $value) {
                    $liste .= ((empty($liste)) ? '' : ',') . $key;
                }
            }
    
        }
    
        $liste =  !empty($liste)? " id_article in ($liste) " : " id_article = -1 ";
    
        return $this->listeArticles($liste);
    }
    
    protected function listeArticles($reservation = false)
    {
        //$this->_trad
    
        $table = array();
        $position = 1;
        $this->nav = ($reservation)? 'reservation' : $this->nav;
        $articles = $this->selectArticlesOrder($this->orderArticles(), $reservation);
        $panier = isset($_SESSION['panier'][$_SESSION['date']])?
                    $_SESSION['panier'][$_SESSION['date']] : [];
    
        while ($data = $articles->fetch_assoc()) {
            $min = empty($data['cap_min'])? intval($data['capacite']*0.3) : $data['cap_min'];
            $table['info'][] = array(
                'ref'=>$data['id_article'],
                'nom'=>html_entity_decode($data['titre']),
                'capacite'=>"$min - {$data['capacite']}",
                'categorie'=>$this->_trad['value'][$data['categorie']],
                'photo'=>'<a href="' . LINK . '?nav=ficheArticles&id=' . $data['id_article'] . '&pos=' . $position . '" " >
                    <img class="trombi" src="' . imageExiste($data['photo']) . '" ></a>',
                'reservation'=>(isset($panier[$data['id_article']])) ?
                    '<a href="' . LINK . '?nav=' . $this->nav . '&enlever=' . $data['id_article'] . '&pos=' . $position . '" >' . $this->_trad['enlever'] . '</a>' :
                    ' <a href="' . LINK . '?nav=' . $this->nav . '&reserver=' . $data['id_article'] . '&pos=' . $position . '">' . $this->_trad['reserver'] . '</a>',
                /*'total' => (isset($panier[$data['id_article']]['total'])?
                            "[ Total:" . number_format($panier[$data['id_article']]['total'], 2) . "€ ]" :
                            ""), */
                'position'=>'<a id="P-' . $position . '"></a>'
    
            );
            $position++;
        }
    
        return $table;
    }
    
    protected function listeArticlesBO()
    {
        //$this->_trad
    
        $table = array();
    
        $table['champs']['id_article'] = 'REF';
        $table['champs']['titre'] = $this->_trad['champ']['titre'];
        $table['champs']['capacite'] = $this->_trad['champ']['capacite'];
        $table['champs']['categorie'] = $this->_trad['champ']['categorie'];
        $table['champs']['produit'] = $this->_trad['champ']['produit'];
        $table['champs']['photo'] = $this->_trad['champ']['photo'];
        $table['champs']['active'] = $this->_trad['champ']['active'];
    
        $position = 1;
        $articles = $this->selectArticlesUsers($this->orderArticlesValide() . $this->orderArticles());
    
        while ($data = $articles->fetch_assoc()) {
            $table['info'][] = array(
                $data['id_article'],
                html_entity_decode($data['titre']),
                "MIN. {$data['cap_min']}, MAX. : {$data['capacite']}<br> prix ref: {$data['prix_personne']}",
                $this->_trad['value'][$data['categorie']],
                $this->listeProduits($data),
                    '<a href="' . LINK . '?nav=ficheArticles&id=' . $data['id_article'] . '&pos=' . $position . '" id="P-' . $position . '" >
                <img class="trombi" src="' . imageExiste($data['photo']) . '" ></a>',
                '<a href="' . LINK . '?nav=ficheArticles&id=' . $data['id_article'] . '&pos=' . ($position - 1) . '" ><img width="25px" src="img/modifier.png"></a>',
                ($data['active'] == 1) ? ' <a href="' . LINK . '?nav=articles&delete=' . $data['id_article'] . '#P-' . ($position - 1) . '"><img width="25px" src="img/activerOk.png"></a>' :
                    ' <a href="' . LINK . '?nav=articles&active=' . $data['id_article'] . '#P-' . ($position - 1) . '"><img width="25px" src="img/activerKo.png"></a>'
            );
            $position++;
        }
    
        return $table;
    }
    
    protected function listeProduits(array $data)
    {
        $prix_article = $ref ='';
        $affiche = [];
        if($prix = $this->selectProduitsArticle($data['id_article'])){
            while($info = $prix->fetch_assoc() ){
                $prixArticle= listeCapacites($data, $info);
                $ref = '';
                foreach($prixArticle as $key =>$produit){
                    $ref .=  "<td>" . $produit['prix'] . "€</td>";
                    $affiche[$key] = $produit['num'];
                }
                $prix_article .= "<tr><td class='tableauprix'>{$produit['libelle']}</td>$ref</tr>";
            }
        }
        $ref = '';
        foreach($affiche as $col){
            $ref .=  "<td class='tableauprix'>$col pers.</td>";
        }
        $prix_article = "<tr><td class='tableauprix' width='90'>Max. </td>$ref</tr>" . $prix_article;
        $this->_trad['produitNonDispoble'] = "Produits non disponibles";
        return (empty($affiche))? $this->_trad['produitNonDispoble'] : "<table width='100%' border='1' cellspacing='1' BGCOLOR='#ccc'>$prix_article</table>";
    }
    
    protected function getdisponible($date, $id)
    {
        $data = [];
        $data['tranche'] = [];
        if($reserves = $this->selectArticleReservesMembres($date, $id)){
                while ($info = $reserves->fetch_assoc()){
                    $data['tranche'][] = $info['tranche'];
                    $data[$info['tranche']] = $info['id_membre'];
                }
            }
    
        return $data;
    }
    
    protected function getIndisponibilite()
    {
        $data = [];
        if(isset($_SESSION['panier'])){
            foreach($_SESSION['panier'] as $date => $article){
                foreach($article as $id => $item){
                    if($reserves = $this->selectArticleReserves($date, $id)){
                        while ($info = $reserves->fetch_assoc()){
                            unset($_SESSION['panier'][$date][$id][$info['tranche']]);
                            //echo($_SESSION['panier'][$date][$id][$info['tranche']]);
                        }
                    }
                    // on detruit le set de la sale si vide
                    if(empty($_SESSION['panier'][$date][$id])){
                        unset($_SESSION['panier'][$date][$id]);
                    }
                }
    
                // on detruit la set de la date si vide
                if(empty($_SESSION['panier'][$date])){
                    unset($_SESSION['panier'][$date]);
                }
    
            }
        }
    
        return $data;
    }
    
    protected function listeProduitsReservation(array $data)
    {
        //$this->_trad
        $prix_article = $ref = $disponibilite = [];
        $affiche = $_listeReservation = [];
        $i = $_total = 0;
    
        if($prix = $this->selectProduitsArticle($data['id_article'])){
            $disponible = $this->getdisponible($_SESSION['date'], $data['id_article']);
            //var_dump($disponible);
            while($info = $prix->fetch_assoc() ){
                $reservee = in_array($info['id_plagehoraire'], $disponible['tranche']);
                $prixArticle= listeCapacites($data, $info);
                //var_dump($prixArticle);
                $ref = '';
                $i++;
    
                $reservation = (isset($_SESSION['date']) && isset($_SESSION['panier'][$_SESSION['date']][$data['id_article']]))?
                                $_SESSION['panier'][$_SESSION['date']][$data['id_article']] : [];
                foreach($prixArticle as $key =>$produit){
                    $checked = '';
                    if(isset($reservation[$i]) && $reservation[$i] == $key){
                        // check le boutton
                        $checked = 'checked';
                        if($reservee){
                            unset($_SESSION['panier'][$_SESSION['date']][$data['id_article']][$key]);
                        } else {
    
                            $_listeReservation[] = $produit;
                        }
                    }
    
                    $ref['produit'] = $produit;
                    $ref['reservee'] = $reservee;
                    $ref['membre'] = (isset($_SESSION['user']['id']) && $reservee AND $disponible[$info['id_plagehoraire']] == $_SESSION['user']['id'])?
                                        true : false;
                    $ref['checked'] = $checked;
                    $disponibilite[$produit['libelle']][$key]=$ref;
                    $affiche[$key] = $produit['num'];
                }
                //$prix_article[] = ['libelle' => $produit['libelle'], 'disponibilite'=> $disponibilite];
    
            }
        }
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
        return ['affiche'=>$affiche, 'disponibilite'=>$disponibilite];
    }
    
    protected function listeProduitsPrixReservation($date, $data)
    {
       $_listeReservation = [];
        $i = $_total = 0;
    
        if($prix = $this->selectProduitsArticle($data['id_article'])){
            while($info = $prix->fetch_assoc() ){
                $prixArticle= listeCapacites($data, $info);
                $i++;
                $reservation = (isset($_SESSION['panier'][$date][$data['id_article']]))?
                                $_SESSION['panier'][$date][$data['id_article']] : [];
    
                foreach($prixArticle as $key =>$produit){
                    if(isset($reservation[$i]) && $reservation[$i] == $key){
                        //var_dump($produit);
                        /*
                        'id' => string '66' (length=2)
                        'num' => string '150' (length=3)
                        'prix_personne' => float 5.5
                        'libelle' => string 'soiree' (length=6)
                        'description' => string '18:00h - 22:00h' (length=15)
                        */
                        /*$_reserve['libelle'] = $produit['libelle'];
                        $_reserve['num'] = $produit['num'];
                        $_reserve['prix'] = $produit['prix']; */
                        /*
                            "<div class='tronche'>{$produit['libelle']} :</div>
                                                <div class='personne'>{$produit['num']} pers.</div>
                                                <div class='prix'>{$produit['prix']}€</div>";
                        $_total = $_total +  $produit['prix'];
                        */
                        $_listeReservation[] = $produit;
                    }
                }
            }
        }
    
        /*
        "<div class='tronche'>{$produit['libelle']} :</div>
                            <div class='personne'>{$produit['num']} pers.</div>
                            <div class='prix'>{$produit['prix']}€</div>";
        $reserve = ($_total)? $_listeReservation .
                                "<div class='tronche couts'>Cout :</div>
                                <div class='personne couts'>&nbsp;</div>
                                <div class='prix couts'>" . number_format ($_total, 2) . "€</div>"
                                : "";
        */
        //return ['reserve'=>$reserve, 'couts'=>$_total];
        return $_listeReservation;
    }
    
    protected function listeProduitsReservationPrix($data)
    {
        $listePrix = [];
        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $listeOrdenee = sortIndice($_SESSION["panier"]);
            foreach ($listeOrdenee as $key => $date) {
                if(isset($_SESSION["panier"][$date][$data['id_article']])){
                    $listePrix[$date] = $this->listeProduitsPrixReservation($date, $data);
                    /*"<div class='tronche'>{$produit['libelle']} :</div>
                            <div class='personne'>{$produit['num']} pers.</div>
                            <div class='prix'>{$produit['prix']}€</div>";
                    $reserve = ($_total)? $_listeReservation .
                        "<div class='tronche couts'>Cout :</div>
                                <div class='personne couts'>&nbsp;</div>
                                <div class='prix couts'>" . number_format ($_total, 2) . "€</div>"
                        : "";*/
    
                }
            }
        }
        return $listePrix;
        /**********************************************/
        $_liste = '';
        $_total = 0;
        /*foreach($listePrix as $date=>$info){
            $_liste .= "<div class='ligne date'>" .
                                reperDate($date)
                                . "</div>".$info['reserve'];
            $_total = $_total + $info['couts'];
        } */
        return $_liste . "<div class='tronche total'>TOTAL :</div>
                                <div class='personne total'>&nbsp;</div>
                                <div class='prix total'>" . number_format ($_total, 2) . "€</div>";
    }
    
    protected function listeProduitsReservationPrixTotal()
    {
        $listePrix = [];
        if(isset($_SESSION['panier']) && !empty($_SESSION['panier'])){
            $listeOrdenee = sortIndice($_SESSION["panier"]);
            foreach ($listeOrdenee as $key => $date) {
                foreach($_SESSION['panier'][$date] as $id=>$reserv){
                    $data = $this->selectArticleId($id);
                    $article = $data->fetch_assoc();
                    $listePrix[$date][] = ['article'=>$article, 'reservation'=>$this->listeProduitsPrixReservation($date, $article)];
                }
            }
        }
    
        return $listePrix;
    
    }
    
    
    protected function treeProduitsArticle($_id)
    {
    
        $existProduits = $this->selectProduitsArticle($_id);
    
        $produit = array();
        while($exist = $existProduits->fetch_assoc()){
            if(!isset($_POST['plagehoraire'][$exist['id_plagehoraire']])){
                $this->deleteProduit($exist['id']);
            } else {
                unset($this->form->_formulaire['plagehoraire']['valide'][$exist['id_plagehoraire']]);
            }
        }
    
        foreach($this->form->_formulaire['plagehoraire']['valide'] as $plage_horaire => $info){
            $this->setProduit($_id, $plage_horaire);
        }
    
        return true;
    }
    
    protected function orderArticles()
    {
        if(isset($_SESSION['orderArticles']['champ'])){
            if(isset($_POST['ord'])){
                $ord = $_POST['ord'];
                switch($ord){
                    case 'id_article':
                    case 'categorie':
                    case 'capacite':
                    case 'titre':
                        $_SESSION['orderArticles']['order'] = ($_SESSION['orderArticles']['champ'] != $ord)?
                            "ASC" : (($_SESSION['orderArticles']['order'] == "ASC")? "DESC" : "ASC" );
    
                        $_SESSION['orderArticles']['champ'] = $ord;
                    break;
                }
            }
        } else {
            $_SESSION['orderArticles'] = array();
            $_SESSION['orderArticles']['champ'] = 'categorie';
            $_SESSION['orderArticles']['order'] = 'ASC';
        }
    
        return $_SESSION['orderArticles']['champ'] . " " . $_SESSION['orderArticles']['order'];
    }
    
    protected function reservationArticles()
    {
        if (!empty($_POST)) {
            if (isset($_POST['reserver']) && $_SESSION['dateTimeOk']) {
                if(isset($_POST['prix'])) {
                    $_SESSION['panier'][$_SESSION['date']][$_POST['id']] = isset($_POST['prix']) ? $_POST['prix'] : [];
                } else {
                    return false;
                }
            } else if (isset($_POST['enlever'])) {
                unset($_SESSION['panier'][$_SESSION['date']][$_POST['id']]);
            }
        } else if (!empty($_GET)) {
            if (isset($_GET['reserver']) && $_SESSION['dateTimeOk']) {
                if(!(utilisateurConnecte())){
                    return false;
                }
                header('location:?nav=ficheArticles&id='.$_GET['reserver'].'&pos='.$_GET['pos']);
    
            } else if (isset($_GET['enlever'])) {
                unset($_SESSION['panier'][$_SESSION['date']][$_GET['enlever']]);
            }
        }
        return true;
    }
    
    protected function activeArticles()
    {
        if (isset($_GET)) {
            if (!empty($_GET['delete'])) {
    
                $this->setArticlesActive($_GET['delete'], 0);
    
            } elseif (!empty($_GET['active'])) {
    
                if(!empty($this->selectProduitsArticle($_GET['active'])->num_rows)){
                    $this->setArticlesActive($_GET['active'], 1);
                } else {
                    return false;
                }
            }
    
        }
        return true;
    }
    
    protected function urlReservation(){
    
        if(isset($_GET['reserver']) OR isset($_POST['reserver'])){
    
            //$this->_trad
            if(utilisateurConnecte()){
             return ($this->reservationArticles())? '' : $this->_trad['erreur']['produitChoix'];
            }
    
            $_SESSION['urlReservation'] = $_GET;
            header('refresh:0;url=index.php?nav=actif');
            echo "<html>{$this->_trad['erreur']['produitConnexion']}</html>";
        }
    
    }
}
