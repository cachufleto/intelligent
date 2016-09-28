<?php
$lien = LINK . '?nav=' . $this->nav;
include VUE . 'articles/moteur.tpl.php';

echo '
<div class="ligne">';

if(!empty($table['info'])){
    foreach($table['info'] as $ligne=>$article){
        $class = ($ligne%2 == 1)? 'lng1':'lng2' ;
        $nom = strtoupper($article['nom']);
        $active = isset($_SESSION['panierArticles'][$article['ref']])? "active" : "";

echo <<<EOL
        <div class="quart">
            {$article['position']}
            <h3>$nom</h3>
            <div class="quart_photo">
                {$article['photo']}
            </div>
            <div class="ligne">

                    <h4 class="in_catalogue">{$article['categorie']}</h4>
                        REF:{$article['ref']}
                    </p>
            </div>
            <div class="ligne">
            </div>
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
$total = 0;
$reservation = '';
if(!empty($listePrix)){
    $reservation .= "<div class='ligne'><h4>{$this->_trad['votreReservation']}</h4></div>";
foreach($listePrix as $date=>$data){
    foreach($data as $key=>$article){
        //$article = $info['article'];
        $titre = $article['produit'];
        $reservation .= "<div class='ligne'><hr></div>";
        //foreach($article['reservation'] as $_ligne=>$reserve) {
        $prix = $article['prix_Achat'] * 1.3;
        $panier = $article['prix_Achat'] * 1.3 * $article['quantite'];
            $reservation .= "<div class='ligne'>
                            <div class='titre'>$titre</div>
                            <div class='tronche'>".number_format($prix,2)." :</div>
                            <div class='personne'>{$article['quantite']}</div>
                            <div class='prix'>". number_format($panier,2) . "€</div></div>";
            $total = $total + $panier;
            $titre = "&nbsp;";
        //}
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