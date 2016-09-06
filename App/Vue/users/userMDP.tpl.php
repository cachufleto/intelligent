<?php //$this->_trad ?>
<div class="ligne">
    <h1><?php echo $this->_trad['titre']['validerMDP']; ?></h1>
</div>
<div class="ligne">
    <div id="formulaire">
        <?php
        // affichage
        if ($_jeton) {
            echo $this->_trad['redirigeVerConnection'];
        } else {
            echo $msg, '
                    <form action="#" method="POST">
                    ' . $form . '
                    </form>';
        }
        ?>
    </div>
</div>