<?php
$position = $position -1;
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['ficheArticles']}</h1>
</div>
<div class="ligne">
    <div id="formulaire" class="fichearticles">
        {$this->form->msg}
        <form action="#P-{$position}" enctype="multipart/form-data" method="POST">
        $form
        </form>
    </div>
</div>
EOL;
