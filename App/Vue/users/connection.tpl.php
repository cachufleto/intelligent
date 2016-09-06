<?php //$this->_trad ?>
<div class="ligne">
    <h1><?php echo $this->_trad['titre']['connection']; ?></h1>
</div>
<div class="ligne">
    <div id="formulaire">
        <p><?php echo $msg; ?></p>
        <form action="#" method="POST">
        <?php echo $form; ?>
        </form>
        <div class="ligneForm">
            <label class="label"><?php echo $this->_trad['pasEncoreMembre']; ?></label>
            <div class="champs"><a href="<?php echo LINK; ?>?nav=inscription"><?php echo $this->_trad['inscrivezVous']; ?></a></div>
        </div>
        <div class="ligneForm">
            <label class="label"><?php echo $this->_trad['motPasseOublie']; ?></label>
            <div class="champs"><a href="<?php echo LINK; ?>?nav=changermotpasse"><?php echo $this->_trad['demandeDeMotPasse']; ?></a></div>
        </div>
    </div>
</div>