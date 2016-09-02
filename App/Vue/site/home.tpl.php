<?php $_trad = setTrad(); ?>
<div class="ligne">
    <h1><?php echo $_trad['titre']['home']; ?></h1>
</div>
<div class="homeG">
    <?php cgv(); ?>
</div>
<div class="homeD">
    <h3><?php echo $_trad['dernieresOffres']; ?></h3>
    <?php echo $dernieresOffres; ?>
</div>
