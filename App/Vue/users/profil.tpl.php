<?php
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['profil']}</h1>
</div>
<div class="ligne">
    <div id="formulaire">
        {$this->form->msg}
        <form action="#" method="POST">
            $form
        </form>
    </div>
</div>
EOL;
