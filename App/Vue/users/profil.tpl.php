<?php $_trad = setTrad(); ?>
<div class="ligne">
    <h1><?php echo $_trad['titre']['profil']; ?></h1>
</div>
<div class="ligne">
    <div id="formulaire">
        <?php
        // affichage
        echo $msg;
        ?>
        <form action="#" method="POST">
            <?php
            // affichage
            echo $form;
            ?>
        </form>
    </div>
</div>