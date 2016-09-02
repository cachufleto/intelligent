<?php $_trad = setTrad(); ?>
<div class="ligne">
    <h1><?php echo $_trad['titre']['validerMDP']; ?></h1>
</div>
<div class="ligne">
    <div id="formulaire">
        <?php
        // affichage
        if ($_jeton) {
            echo $_trad['redirigeVerConnection'];
        } else {
            echo $msg, '
                    <form action="#" method="POST">
                    ' . $form . '
                    </form>';
        }
        ?>
    </div>
</div>