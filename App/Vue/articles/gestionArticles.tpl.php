<?php
echo <<<TPL
<div class="ligne">
    <h1>{$this->_trad['titre']['gestionArticles']}</h1>
    <span id="ajout">{$this->_trad['ajouterArticle']}</span>
</div>
<div class="ligne">
    {$this->form->msg}
    <table>
    <tr>
    {$tableau1}
    </tr>
    {$tableau}
    </table>
</div>
TPL;
