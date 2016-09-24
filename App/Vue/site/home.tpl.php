<?php
//$cgv = '**';
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['home']}</h1>
</div>
<div class="homeG">
    $listeArticles
</div>
<div class="homeD">
    <h3>{$this->_trad['dernieresOffres']}</h3>
    $dernieresOffres
</div>
EOL;
