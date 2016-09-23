<?php
//$this->_trad

/***************** ficheArticles.tpl ****************************/
//debug($article);
/*
[id_article] => 4
    [produit] => otro
    [fabricant] => otro
    [pays] => otro
    [ville] => otroa
    [adresse] => ortoa
    [cp] => 784587
    [description] => otro
    [photo] => otro_otroa_otrootro_otroa_otro_57e589f4ba9af.png
    [ean] => 124578963
    [quantite] => 1222
    [categorie] => I
    [prix_Achat] => 1033.00
    [active] => 1
    [listePrix] => Array
        (
        )*/
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
            </div>
            <div class="info">
                <div class="titre">$titre</div>
                <div class="fiche">{$article['fabricant']}<br>
                    {$article['prix_Achat']} {$article['ean']}<br>
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
