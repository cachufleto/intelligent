<?php
// affichage
if ($_jeton) {
    $info = $this->_trad['redirigeVerConnection'];
} else {
    $info = $this->_trad['erreur']['redirigeVerConnection'];
}

echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['validerInscription']}</h1>
</div>
<div class="ligne">
    $info
</div>
EOL;
