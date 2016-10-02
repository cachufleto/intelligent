<?php

echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
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
echo <<<EOL
</div>
EOL;
