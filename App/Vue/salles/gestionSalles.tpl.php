<?php $_trad = setTrad(); ?>
<div class="ligne">
    <h1><?php echo $_trad['titre']['gestionSalles']; ?></h1>
    <span id="ajout"><?php echo $_trad['ajouterSalle']; ?></span>
</div>
<div class="ligne">
    <?php echo $msg; ?>
    <table>
    <tr>
        <?php
        foreach($table['champs'] as $champ=>$info ){
            $cols = ($champ == 'active')? 'colspan="2"': '';
            echo '<th ' . $cols . '>
                <form action="' . LINK . '?nav=salles" method="POST">
                    <input type="hidden" name="ord" value="' . $champ . '">
                    <input type="submit" name="" value="' . $info . '">
                </form>
                </th>';
        }
        ?>
    </tr>
    <?php
    foreach($table['info'] as $ligne=>$salle){
            $class = ($ligne%2 == 1)? 'lng1':'lng2' ; ?>
        <tr class="<?php echo $class; ?>">
            <?php
            foreach($salle as $champ=>$info ){
                echo "<td>$info</td>";
            }
        ?>
        </tr>
        <?php } ?>
    </table>
</div>
<?php echo $alert; ?>
