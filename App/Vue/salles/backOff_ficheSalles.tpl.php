<?php $_trad = setTrad(); ?>
<div class="ligne">
    <h1><?php echo $_trad['titre']['ficheSalles']; ?></h1>
</div>
<div class="ligne">
    <div id="formulaire" class="fichesalles">
        <?php echo $msg; ?>
        <form action="#<?php echo "P-".($position -1); ?>" enctype="multipart/form-data" method="POST">
        <?php echo $form; ?>
        </form>
    </div>
</div>
