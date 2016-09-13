<style>
.row{
   background-color: #FF7F0E;
}
.row_0{
   background-color: #FFFFF8;
}
.row_1{
    background-color: #CCCCCC;
}
.now_0{
    background-color: #d3dbb4;
    color: #CCCCCC;
}
.now_1{
    background-color: #8cb523;
    color: #CCCCCC;
}
.old_0{
    background-color: #e8c1b0;
    color: #CCCCCC;
}
.old_1{
    background-color: #b58896;
    color: #CCCCCC;
}
</style>
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
                    <a href='?nav=ficheSalles&id={$produit['id_salle']}&reservee=".
                    date('Y-m-d', $t1)
                    ."'>
                    <div class='titre'>{$produit['titre']}</div>
                    <div class='tronche'>".
                    date('d M Y ', $t1)
                    ."</div>
                    <div class='personne'>{$_prixPlage[$produit['tranche']]['horaire']} / {$produit['capacitee']} pers.</div>
                    <div class='prix'>{$produit['prix']}€</div>
                    </a>
                </div>";
}

echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['nav'][$this->nav]}</h1>
</div>
<div id="commandes" class="ligne commandes">
<div class='ligne row'>
<div class='titre'>{$this->_trad['salle']}</div>
<div class='tronche'>{$this->_trad['dateReservee']}</div>
<div class='personne'>{$this->_trad['horarirePers']}</div>
<div class='prix'>{$this->_trad['prix']} €</div>
</div>
    $_liste
</div>
EOL;
