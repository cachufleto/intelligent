<?php //$this->_trad ?>
<div class="ligne">
    <h1><?php echo $this->_trad['titre']['editerArticles']; ?></h1>
</div>
<div class="ligne">
    <div id="formulaire">
        <form action="" method="POST">
            <?php
            echo $echoville;
            echo $echocategorie;
            echo $echocapacite;
            ?>
            <input type="submit" value="chercher">
        </form>
    </div>
</div>