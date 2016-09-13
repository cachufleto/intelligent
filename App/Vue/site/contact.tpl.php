<?php
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['contact']}</h1>
</div>
<div class="ligne">
EOL;
    foreach($listConctact as $fiche){
echo <<<EOL
        <div class="ficheContact">
            <div class="ligne">{$fiche['prenom']} {$fiche['nom']}</div>
            <div class="ligne"><a href="mailto:{$fiche['email']}">{$fiche['email']}</a></div>
            <div class="ligne">{$this->_trad['value'][$fiche['statut']]}</div>
        </div>
EOL;
    }
echo '
</div>';
