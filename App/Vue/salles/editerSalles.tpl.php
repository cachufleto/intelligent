<?php
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['editerSalles']}</h1>
</div>
<div class="ligne">
    <div id="formulaire">
        {$this->form->msg}
        <form action="#" method="POST" enctype="multipart/form-data">
        $form
        </form>
    </div>
</div>
EOL;
