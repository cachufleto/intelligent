<?php
$link = LINK;
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['connection']}</h1>
</div>
<div class="ligne">
    <div id="formulaire">
        <p>{$this->form->msg}</p>
        <form action="#" method="POST">
        $form
        </form>
        <div class="ligneForm">
            <label class="label">{$this->_trad['pasEncoreMembre']}</label>
            <div class="champs"><a href="$link?nav=inscription">{$this->_trad['inscrivezVous']}</a></div>
        </div>
        <div class="ligneForm">
            <label class="label">{$this->_trad['motPasseOublie']}</label>
            <div class="champs"><a href="$link?nav=changermotpasse">{$this->_trad['demandeDeMotPasse']}</a></div>
        </div>
    </div>
</div>
EOL;
