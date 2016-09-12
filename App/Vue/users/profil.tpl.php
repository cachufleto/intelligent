<?php //$this->_trad ?>
<div class="ligne">
    <h1><?php echo $this->_trad['titre']['profil']; ?></h1>
</div>
<div class="ligne">
    <div id="formulaire">
        <?php
        // affichage
        echo $this->form->msg;
        ?>
        <form action="#" method="POST">
            <?php
            // affichage
            echo $form;
            ?>
        </form>
    </div>
</div>