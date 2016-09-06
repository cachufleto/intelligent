<?php //$this->_trad ?>
<div class="ligne">
    <h1><?php echo $this->_trad['titre']['contact']; ?></h1>
</div>
<div class="ligne">
    <?php
    foreach($listConctact as $fiche){ ?>
        <div class="ficheContact">
            <div class="ligne"><?php echo $fiche['prenom'] . " " . $fiche['nom']; ?></div>
            <div class="ligne"><a href="mailto:<?php echo $fiche['email']; ?>"><?php echo $fiche['email']; ?></a></div>
            <div class="ligne"><?php echo $this->_trad['value'][$fiche['statut']]; ?></div>
        </div>
    <?php }
    ?>
</div>
