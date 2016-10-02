<?php
// affichage
if ($_jeton) {
    $info = $this->_trad['redirigeVerConnection'];
} else {
    $info = $this->_trad['erreur']['redirigeVerConnection'];
}

echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
    $info
</div>
EOL;
