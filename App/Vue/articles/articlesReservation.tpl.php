<?php
$lien = LINK . '?nav=' . $this->nav;
include VUE . 'articles/moteur.tpl.php';

echo '
<div class="ligne">';

if(!empty($table['info'])){
    foreach($table['info'] as $ligne=>$article){
        $class = ($ligne%2 == 1)? 'lng1':'lng2' ;
        $nom = strtoupper($article['nom']);
        $active = isset($_SESSION['panier'][$_SESSION['date']][$article['ref']])? "active" : "";

echo <<<EOL
        <div class="quart">
            {$article['position']}
            <h3>$nom</h3>
            <div class="quart_photo">
                {$article['photo']}
            </div>
            <div class="ligne">

                    <h4 class="in_catalogue">{$article['categorie']}</h4>
                    <p>Jusqu'à {$article['capacite']} personnes<br>
                        REF:{$article['ref']}
                    </p>
            </div>
            <div class="ligne">
            </div>
            <div class="reserver $active">{$article['reservation']}</div>
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
    $reservation .= "<div class='ligne'><h4>{$this->_trad['votreReservation']}</h4></div>";
foreach($listePrix as $date=>$data){
    $reservation .= "<div class='ligne'><div class='ligne date'>" .
        reperDate($date)
        . "</div>";
    foreach($data as $key=>$info){
        $article = $info['article'];
        $titre = $article['titre'];
        $reservation .= "<div class='ligne'><hr></div>";
        foreach($info['reservation'] as $_ligne=>$reserve) {
            $reservation .= "<div class='ligne'>
                            <div class='titre'>$titre</div>
                            <div class='tronche'>{$this->_trad['value'][$reserve['libelle']]} :</div>
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
echo "<div class='ligne'>$reservation</div>
    </div>
</div>";