<?php //$this->_trad ?>
<div class="ligne">
    <h1><?php echo $this->_trad['titre']['validerInscription']; ?></h1>
</div>
<div class="ligne">
    <?php
    // affichage
    if ($_jeton) {
        echo $this->_trad['redirigeVerConnection'];
    } else {
        echo $this->_trad['erreur']['redirigeVerConnection'];
    }
    ?>
</div>
