<?php
$lien = LINK . '?nav=' . $this->nav;
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre'][$this->nav]}</h1>
</div>
<div class="ligne">
    <div class="facture">
EOL;
$_liste = '';
$_total = 0;

foreach($listePrix as $date=>$produit){
    $_liste .= "<div class='ligne'>
                <div class='titre'>{$produit['produit']}</div>
                <div class='tronche'>{$produit['fabricant']}</div>
                <div class='personne'>{$this->_trad['value'][$produit['categorie']]}</div>
                <div class='tronche'>{$produit['quantite']}</div>
                <div class='tronche'>{$produit['prix']}€</div>
                <div class='prix'>{$produit['prix_total']}€</div>
                </div>  ";
        $_total += $produit['prix_total'];
}
$TVA = number_format(round($_total*TVA,2), 2, ',', ' ');
$TTC = number_format(round(($_total+$_total*TVA),2), 2, ',', ' ');
$_total = number_format($_total, 2, ',', ' ');
//number_format ($TTC, 2);
if(!empty($_total)){
    echo <<<EOL
    $_liste
    <div class='ligne'>
    <hr>
        <div class='titre'>&nbsp;</div>
        <div class='tronche total'>&nbsp;</div>
        <div class='personne total'>TOTAL</div>
        <div class='prix total'>{$_total}€</div>
    </div>
    <div class='ligne'>
        <div class='titre'>&nbsp;</div>
        <div class='tronche total'>&nbsp;</div>
        <div class='personne total'>TVA 20%</div>
        <div class='prix total'>{$TVA}€</div>
    </div>
    <div class='ligne'>
        <div class='titre'>&nbsp;</div>
        <div class='tronche total'>&nbsp;</div>
        <div class='personne total'>TTC</div>
        <div class='prix total'>{$TTC}€</div>
    </div>
    <div class='ligne'>
    <hr>
        <div class='valider'>
        <form name='commande' method='POST' action='?nav=validerFacture'>
            <a href='?nav=validerFacture'>
                <input type='submit name='facture' value='FACTURATION'>
        </form>
        </div>
    </div>
EOL;
}
echo <<<EOL
    </div>
</div>
EOL;
