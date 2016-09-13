<?php
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['editerArticles']}</h1>
</div>
<div class="ligne">
    <div id="formulaire">
        <form action="" method="POST">
            $echoville
            $echocategorie
            $echocapacite
            <input type="submit" value="chercher">
        </form>
    </div>
</div>
EOL;
