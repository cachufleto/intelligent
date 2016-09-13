<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 11/06/2016
 * Time: 16:22
 */

$pos = isset($_GET['pos'])? '&pos=' . $_GET['pos'] : '';
echo <<<EOL
<div class="ligne">
    <div id="formulaire" class="fichesalle produits">
    <form action="?nav=location&id={$_GET['id']}$pos" method="POST">
        {$form}
    </form>
    </div>
</div>
EOL;
