<?php
if('OK' == $this->form->msg){
    $info = '<a href="'.LINK.'?">'.$this->_trad['validerInscription'].'</a>';
} else{
    $info = $this->form->msg . '
    <form action="#" method="POST">
    '. $form . '
    </form>';
}

echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['inscription']}</h1>
</div>
<div class="ligne">
    <div id="formulaire">
        $info;
    </div>
</div>
EOL;
