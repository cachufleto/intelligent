<?php
echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre']['connection']}</h2>
    </header>
    <div id="formulaire">
        <p>{$this->form->msg}</p>
        <form action="#" method="POST">
        $form
        </form>
        <div class="ligneForm">
            <label class="label">{$this->_trad['pasEncoreMembre']}</label>
            <div class="champs"><a href="{$this->_trad['URLSite']}?nav=inscription">{$this->_trad['inscrivezVous']}</a></div>
        </div>
        <div class="ligneForm">
            <label class="label">{$this->_trad['motPasseOublie']}</label>
            <div class="champs"><a href="{$this->_trad['URLSite']}    ?nav=changermotpasse">{$this->_trad['demandeDeMotPasse']}</a></div>
        </div>
    </div>
</div>
EOL;

