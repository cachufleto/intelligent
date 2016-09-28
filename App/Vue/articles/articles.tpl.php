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
                    <p>REF:{$article['ref']}
                    </p>
            </div>
            <div class="ligne">

            </div>
            <div class="reserver $active">{$article['panier']}</div>
        </div>
EOL;
    }
} else {
    echo 'Aucun article disponible!';
}
echo '</div>' , $alert;