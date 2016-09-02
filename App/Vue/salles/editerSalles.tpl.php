<?php $_trad = setTrad(); ?>
<div class="ligne">
    <h1><?php echo $_trad['titre']['editerSalles']; ?></h1>
</div>
<div class="ligne">
    <div id="formulaire">
        <?php echo $msg; ?>
        <form action="#" method="POST" enctype="multipart/form-data">
        <?php echo $form; ?>
        </form>
    </div>
</div>