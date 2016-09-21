<?php
//$this->_trad

/***************** ficheArticles.tpl ****************************/
debug($article);
/*
Array
(
    [id_article] => 2
    [produit] =>
    [fabricant] =>
    [pays] => colombie
[ville] => cali
[adresse] => test
[cp] => 89000
    [description] => Descrtestiption...
    [photo] => colombie_cali_testcolombie_cali_test_57cf353ea30e0.jpg
[ean] => 6
    [quantite] => 1
    [categorie] => T
[prix_Achat] => 25.0
    [active] => 1
    [listePrix] => Array
(
)

)

*/
$href = imageExiste($article['photo']);
$titre = strtoupper($article['produit']);
$lien = LINK . "?nav=articles&pos=$position";
$active = "";
$reserver = 'reserver';
$modifier = '';
//$formdate = disponibilite();

if(isset($_SESSION['panierArticles'][$_SESSION['date']][$article['id_article']])){
    $active = "active";
    $reserver = 'enlever';
    $modifier = '<input type="submit" name="reserver" value="'.$this->_trad['modifier'].'">';
}

//$min = ($article['cap_min']<=1)? intval($article['capacite']*0.3) : $article['cap_min'];

if(!empty($article['produits']['affiche'])){
    $entete = '';
    foreach($article['produits']['affiche'] as $col){
        $entete .= "<td class='tableauprix'>$col pers.</td>";
    }
    $prix_article = $liteReservation = '';
    $i = $_total = 0;
    foreach($article['produits']['disponibilite'] as $key=>$data){
        $i++;
        $prix_article .= "<tr><td>{$this->_trad['value'][$key]}</td>";

        foreach($data as $indice => $info ){

            $ref = ($info['reservee'])?
                (($info['membre'])? $this->_trad['RESERVEE'] : (($_SESSION['dateTimeOk'])? $this->_trad['INDISPONIBLE']:"---")) :
                (($_SESSION['dateTimeOk'])? number_format($info['produit']['prix'], 2).
                    "€ <input type='radio' name='prix[$i]' value='$indice' {$info['checked']}>" : "---");

            $liteReservation .= ($info['checked'])? "<div class='tronche'>{$this->_trad['value'][$info['produit']['libelle']]} :</div>
                                    <div class='personne'>{$info['produit']['num']} pers.</div>
                                    <div class='prix'>" . number_format($info['produit']['prix'], 2) . "€</div>" : "";

            $_total = ($info['checked'])? $_total +  $info['produit']['prix'] : $_total;

            $prix_article .= "<td>$ref</td>";
        }
        $prix_article .= "</tr>";
    }

    $tableu = "<table width='100%' border='1' cellspacing='1' BGCOLOR='#ccc'>
            <tr><td class='tableauprix' width='90'>Max. </td>$entete</tr>
            $prix_article
          </table>";
} else {
    $tableu = $this->_trad['produitNonDispoble'];
}

$liteReservation = '';
$total = 0;
if(!empty($article['listePrix'])){
   foreach($article['listePrix'] as $date=>$data){
       $lite = '';
      foreach($data as $id=>$info){
          $lite .= "<div class='ligne'>
                    <div class='tronche'>{$this->_trad['value'][$info['libelle']]}</div>
                    <div class='personne'>{$info['num']}</div>
                    <div class='prix'>".number_format($info['prix'],2)."€</div>
                    </div>";
          $total = $total + $info['prix'];
      }

       $liteReservation .= "<div class='ligne date'>" .
           reperDate($date)
           . "</div> $lite";
   }
$liteReservation .= "<div class='ligne total'>
                    <div class='tronche'>&nbsp;</div>
                    <div class='personne'>TOTAL</div>
                    <div class='prix'>".number_format($total,2)."€</div>
                    </div>";
}

echo <<<EOL
 <div class="ligne">
    <h1>{$this->_trad['titre']['ficheArticles']}</h1>
</div>
<div class="ligne">
    <form name="" method="POST" action="?nav=ficheArticles&id={$article['id_article']}&pos=$position">
    <div id="fiche" class="article">
        <div class="ligne">
            <div class="ville">{$article['ville']} ({$article['pays']})</div>
            <div>{$this->form->msg}</div>
        </div>
        <div class="ligne">
            <div class="photo">
                <div><img src="$href"></div>

                $tableu
            </div>
            <div class="info">
                <div class="titre">$titre</div>
                <div class="fiche">{$article['adresse']}<br>
                    {$article['cp']} {$article['ville']}<br>
                </div>
                    <input type="hidden" name="id" value="{$article['id_article']}">
                    <input type="hidden" name="pos" value="$position">
                    <div class="categorie">
                        Cat. {$this->_trad['value'][$article['categorie']]} ::
                    </div>
                    <div>
                        {$article['description']}
                    </div>
                    <div class="reserve">
                        {$this->_trad['votreReservation']}
                        <hr>
                        $liteReservation
                    </div>
            </div>
        </div>
        <div class="ligne description">
             <div class="ligne">
            </div>
            <div class="reserver $active">
                <input type="submit" name="$reserver" value="{$this->_trad[$reserver]}">
                $modifier
            </div>
            <div class="reserver lien">
                <a href="$lien"><button type="button">{$this->_trad['revenir']}</button></a> :
                <a href="?nav=reservation"><button type="button">{$this->_trad['nav']['reservation']}</button></a>
            </div>
        </div>
    </div>
    </form>
</div>
$alert
EOL;
