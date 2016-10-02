<?php
echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
    <form name="index" action="{$this->_trad['URLSite']}?nav=backoffice" method="POST">
        <div class=" col-2">
            <input type="submit" value="modifier" name="activite">
            $activite
        </div>
        <div class=" col-2">
            <input type="submit" value="modifier" name="dernieresOffres">
            $dernieresOffres
        </div>
    </form>
</div>
EOL;
