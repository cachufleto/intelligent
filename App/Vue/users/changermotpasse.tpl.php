<?php
if($this->form->msg == 'OK'){
    $info = $this->_trad['priseEnCompteMDP'];
} else {
    $info = $this->form->msg . '
    <form action="#" method="POST">
        '.$form.'
    </form>';
}

echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['validerMDP']}</h1>
</div>
<div class="ligne">
    <div id="formulaire">
        $info
    </div>
</div>
EOL;
