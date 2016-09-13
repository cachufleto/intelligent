<?php
$lien = LINK . '?nav=' . $this->nav;
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['nav'][$this->nav]}</h1>
</div>
<div class="ligne">
    <div class="facture">
EOL;
$_liste = '';
$_total = 0;
foreach($listePrix as $date=>$data){
    foreach($data as $key=>$info){
        foreach($info as $item=>$produit) {
            $_liste .= "
                    <div class='titre'>{$produit['titre']}</div>
                    <div class='tronche'>$date</div>
                    <div class='personne'>{$produit['libelle']} {$produit['num']} pers.</div>
                    <div class='prix'>{$produit['prix']}€</div>";
            $_total = $_total + $produit['prix'];


            //$_liste .= $info['reservation']['reserve'];
            //$_total = $_total + $info['reservation']['couts'];
        }
    }
}

$TTC = round($_total*(1+TVA),2);
$TVA = $TTC - $_total;
echo !empty($_total)? $_liste . "
                            <div class='ligne'>
                            <hr>
                                <div class='titre'>&nbsp;</div>
                                <div class='tronche total'>&nbsp;</div>
                                <div class='personne total'>TOTAL</div>
                                <div class='prix total'>" . number_format ($_total, 2) . "€</div>
                            </div>
                            <div class='ligne'>
                                <div class='titre'>&nbsp;</div>
                                <div class='tronche total'>&nbsp;</div>
                                <div class='personne total'>TVA 20%</div>
                                <div class='prix total'>" . number_format ($TVA, 2) . "€</div>
                            </div>
                            <div class='ligne'>
                                <div class='titre'>&nbsp;</div>
                                <div class='tronche total'>&nbsp;</div>
                                <div class='personne total'>TTC</div>
                                <div class='prix total'>" . number_format ($TTC, 2) . "€</div>
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
                            " : "";
    echo <<<EOL
    </div>
</div>
EOL;
