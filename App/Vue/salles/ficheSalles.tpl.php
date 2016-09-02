<?php
$_trad = setTrad();

/***************** ficheSalles.tpl ****************************/
$href = imageExiste($salle['photo']);
$titre = strtoupper($salle['titre']);
$lien = LINK . "?nav=salles&pos=$position";
$active = "";
$reserver = 'reserver';
$modifier = '';
$formdate = disponibilite();

if(isset($_SESSION['panier'][$_SESSION['date']][$salle['id_salle']])){
    $active = "active";
    $reserver = 'enlever';
    $modifier = '<input type="submit" name="reserver" value="'.$_trad['modifier'].'">';
}
$min = ($salle['cap_min']<=1)? intval($salle['capacite']*0.3) : $salle['cap_min'];

if(!empty($salle['produits']['affiche'])){
    $entete = '';
    foreach($salle['produits']['affiche'] as $col){
        $entete .= "<td class='tableauprix'>$col pers.</td>";
    }
    $prix_salle = $liteReservation = '';
    $i = $_total = 0;
    foreach($salle['produits']['disponibilite'] as $key=>$data){
        $i++;
        $prix_salle .= "<tr><td>{$_trad['value'][$key]}</td>";

        foreach($data as $indice => $info ){

            $ref = ($info['reservee'])?
                (($info['membre'])? $_trad['RESERVEE'] : (($_SESSION['dateTimeOk'])? $_trad['INDISPONIBLE']:"---")) :
                (($_SESSION['dateTimeOk'])? number_format($info['produit']['prix'], 2).
                    "€ <input type='radio' name='prix[$i]' value='$indice' {$info['checked']}>" : "---");

            $liteReservation .= ($info['checked'])? "<div class='tronche'>{$_trad['value'][$info['produit']['libelle']]} :</div>
                                    <div class='personne'>{$info['produit']['num']} pers.</div>
                                    <div class='prix'>" . number_format($info['produit']['prix'], 2) . "€</div>" : "";

            $_total = ($info['checked'])? $_total +  $info['produit']['prix'] : $_total;

            $prix_salle .= "<td>$ref</td>";
        }
        $prix_salle .= "</tr>";
    }

    $tableu = "<table width='100%' border='1' cellspacing='1' BGCOLOR='#ccc'>
            <tr><td class='tableauprix' width='90'>Max. </td>$entete</tr>
            $prix_salle
          </table>";
} else {
    $tableu = $_trad['produitNonDispoble'];
}

$liteReservation = '';
$total = 0;
if(!empty($salle['listePrix'])){
   foreach($salle['listePrix'] as $date=>$data){
       $lite = '';
      foreach($data as $id=>$info){
          $lite .= "<div class='ligne'>
                    <div class='tronche'>{$_trad['value'][$info['libelle']]}</div>
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
    <h1>{$_trad['titre']['ficheSalles']}</h1>
</div>
<div class="ligne">
    <form name="" method="POST" action="?nav=ficheSalles&id={$salle['id_salle']}&pos=$position">
    <div id="fiche" class="salle">
        <div class="ligne">
            <div class="ville">{$salle['ville']} ({$salle['pays']})</div>
            <div>{$msg}</div>
        </div>
        <div class="ligne">
            <div class="photo">
                <div><img src="$href"></div>
                $formdate
                $tableu
            </div>
            <div class="info">
                <div class="titre">$titre</div>
                <div class="fiche">{$salle['adresse']}<br>
                    {$salle['cp']} {$salle['ville']}<br>
                    {$salle['telephone']}<br>
                    {$salle['gsm']}
                </div>
                    <input type="hidden" name="id" value="{$salle['id_salle']}">
                    <input type="hidden" name="pos" value="$position">
                    <div class="categorie">
                        Cat. {$_trad['value'][$salle['categorie']]} :: $min - {$salle['capacite']} {$_trad['personnes']}
                    </div>
                    <div>
                        {$salle['description']}
                    </div>
                    <div class="reserve">
                        {$_trad['votreReservation']}
                        <hr>
                        $liteReservation
                    </div>
            </div>
        </div>
        <div class="ligne description">
             <div class="ligne">
            </div>
            <div class="reserver $active">
                <input type="submit" name="$reserver" value="{$_trad[$reserver]}">
                $modifier
            </div>
            <div class="reserver lien">
                <a href="$lien"><button type="button">{$_trad['revenir']}</button></a> :
                <a href="?nav=reservation"><button type="button">{$_trad['nav']['reservation']}</button></a>
            </div>
        </div>
    </div>
    </form>
</div>
$alert
EOL;
