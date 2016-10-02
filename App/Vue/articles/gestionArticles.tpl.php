<?php

echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
    <span id="ajout">{$this->_trad['ajouterArticle']}</span>
    {$this->form->msg}
    <table>
    <tr>
    {$tableau1}
    </tr>
    {$tableau}
    </table>
</div>
EOL;
