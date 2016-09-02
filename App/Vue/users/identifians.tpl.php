<?php $_trad = setTrad(); ?>
<div class="ligne">
    <h1><?php echo $_trad['titre']['validerInscription']; ?></h1>
</div>
<div class="ligne">
    <?php
    // affichage
    if ($_jeton) {
        echo $_trad['redirigeVerConnection'];
    } else {
        echo $_trad['erreur']['redirigeVerConnection'];
    }
    ?>
</div>
