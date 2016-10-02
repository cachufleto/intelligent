<?php
echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre']['erreur404']}</h2>
    </header>
    <h2 style="text-align:center"><span style="color:red;">{$this->form->msg}</span></h2>
</div>
EOL;
