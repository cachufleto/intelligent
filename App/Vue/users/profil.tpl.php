<?php
echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
    <div id="formulaire">
        {$this->form->msg}
        <form action="#" method="POST">
            $form
        </form>
    </div>
</div>
EOL;
