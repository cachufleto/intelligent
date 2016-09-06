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
                    <p>{$this->_trad['champ']['capacite']} {$salle['capacite']} {$this->_trad['personnes']}<br>
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
echo '</div>' , $alert;