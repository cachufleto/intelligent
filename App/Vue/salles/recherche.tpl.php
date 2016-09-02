<?php $_trad = setTrad(); ?>
<div class="ligne">
    <h1><?php echo $_trad['titre']['editerSalles']; ?></h1>
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