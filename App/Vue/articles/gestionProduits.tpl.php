<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 11/06/2016
 * Time: 16:22
 */
$pos = isset($_GET['pos'])? '&pos=' . $_GET['pos'] : '';


echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
    <div id="formulaire" class="fichearticle produits">
    <form action="?nav=magasin&id={$_GET['id']}$pos" method="POST">
        $form
    </form>
    </div>
</div>
EOL;
