<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 11/06/2016
 * Time: 16:22
 */

$pos = isset($_GET['pos'])? '&pos=' . $_GET['pos'] : '';
?>
<div class="ligne">
    <div id="formulaire" class="fichesalle produits">
    <form action="?nav=produits&id=<?php echo $_GET['id'], $pos; ?>" method="POST">
        <?php echo $form; ?>
    </form>
    </div>
</div>
