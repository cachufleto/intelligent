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
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
    <div id="formulaire">
        $info
    </div>
</div>
EOL;

