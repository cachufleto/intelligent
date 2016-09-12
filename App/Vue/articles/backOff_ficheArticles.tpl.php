<?php //$this->_trad ?>
<div class="ligne">
    <h1><?php echo $this->_trad['titre']['ficheArticles']; ?></h1>
</div>
<div class="ligne">
    <div id="formulaire" class="fichearticles">
        <?php echo $this->form->msg; ?>
        <form action="#<?php echo "P-".($position -1); ?>" enctype="multipart/form-data" method="POST">
        <?php echo $form; ?>
        </form>
    </div>
</div>
