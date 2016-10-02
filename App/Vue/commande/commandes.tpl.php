<?php
$lien = LINK . '?nav=' . $this->nav;
include CONF . 'parametres.param.php';

$_liste = '';
$_total = 0;
$i = 1;
foreach($listePrix as $reservee=>$produit){
    $i++;
    $d1 = new DateTime($produit['date_reserve'], new DateTimeZone('Europe/Paris'));
    $t1 = $d1->getTimestamp();
    $row = (($t1 < time())? (($t1 > (time() - 60*60*24))? 'now_' : 'old_') : 'row_') .($i%2);

    $_liste .= "<div class='ligne $row'>
                    <a href='?nav=ficheSalles&id={$produit['id_article']}&reservee=".
        date('Y-m-d', $t1)
        ."'>
                    <div class='titre'>{$produit['produit']}</div>
                    <div class='tronche'>".
        date('d M Y ', $t1)
        ."</div>
                    <div class='personne'>{$produit['ean']} / {$produit['quantite']}</div>
                    <div class='prix'>{$produit['prix']}€</div>
                    </a>
                </div>";
}

echo <<<EOL
<div id="three-column" class="container">
    <header>
    <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
    <div id="commandes" class="ligne commandes">
        <div class='ligne row'>
            <div class='titre'>{$this->_trad['article']}</div>
            <div class='tronche'>{$this->_trad['dateReservee']}</div>
            <div class='personne'>{$this->_trad['horarirePers']}</div>
            <div class='prix'>{$this->_trad['prix']} €</div>
        </div>
        $_liste
    </div>
</div>
EOL;
