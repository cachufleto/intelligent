<?php
$lien = LINK . '?nav=' . $nav;
include VUE . 'salles/moteur.tpl.php';

echo '
<div class="ligne">';

if(!empty($table['info'])){
    foreach($table['info'] as $ligne=>$salle){
        $class = ($ligne%2 == 1)? 'lng1':'lng2' ;
        $nom = strtoupper($salle['nom']);
        $active = isset($_SESSION['panier'][$_SESSION['date']][$salle['ref']])? "active" : "";

        echo <<<EOL
        <div class="quart">
            {$salle['position']}
            <h3>$nom</h3>
            <div class="quart_photo">
                {$salle['photo']}
            </div>
            <div class="ligne">

                    <h4 class="in_catalogue">{$salle['categorie']}</h4>
                    <p>Jusqu'à {$salle['capacite']} personnes<br>
                        REF:{$salle['ref']}
                    </p>
            </div>
            <div class="ligne">
            </div>
            <div class="reserver $active">{$salle['reservation']}</div>
        </div>
EOL;
    }
}
echo '
</div>
<div classe="ligne">
    ' . $alert . '
</div>
<div class="ligne">
    <hr>
    <div class="reserve">';
$listePrix = $this->listeProduitsReservationPrixTotal();

$total = 0;
$reservation = '';
if(!empty($listePrix)){
    $reservation .= "<div class='ligne'><h4>{$_trad['votreReservation']}</h4></div>";
foreach($listePrix as $date=>$data){
    $reservation .= "<div class='ligne'><div class='ligne date'>" .
        reperDate($date)
        . "</div>";
    foreach($data as $key=>$info){
        $salle = $info['salle'];
        $titre = $salle['titre'];
        $reservation .= "<div class='ligne'><hr></div>";
        foreach($info['reservation'] as $_ligne=>$reserve) {
            $reservation .= "<div class='ligne'>
                            <div class='titre'>$titre</div>
                            <div class='tronche'>{$_trad['value'][$reserve['libelle']]} :</div>
                            <div class='personne'>{$reserve['num']} pers.</div>
                            <div class='prix'>". number_format($reserve['prix'],2) . "€</div></div>";
            $total = $total + $reserve['prix'];
            $titre = "&nbsp;";
        }
    }
}
    $reservation .= "<div class='ligne'>
                        <hr>
                        <div class='titre total'>&nbsp;</div>
                        <div class='tronche total'>&nbsp;</div>
                        <div class='personne total'>TOTAL :</div>
                        <div class='prix total'>" . number_format ($total, 2) . "€</div>
                    </div>
                    <div class='ligne'>
                        <div class='valider'>
                        <a href='?nav=validerCommande'><button>VALIDER LA COMMANDE</button></a>
                        </div>
                    </div>";
}
echo "<div class='ligne'>$reservation</div>";
echo '
    </div>
</div>';