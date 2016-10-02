<?php
$position = $position -1;

echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
    <div id="formulaire" class="fichearticles">
        {$this->form->msg}
        <form action="#P-{$position}" enctype="multipart/form-data" method="POST">
        $form
        </form>
    </div>
</div>
EOL;
