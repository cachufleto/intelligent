<?php
$link = LINK;
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['backoffice']}</h1>
</div>
<div class="ligne">
    <form name="index" action="$link?nav=backoffice" method="POST">
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
