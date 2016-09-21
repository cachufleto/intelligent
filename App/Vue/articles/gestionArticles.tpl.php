<?php //$this->_trad ?>
<div class="ligne">
    <h1><?php echo $this->_trad['titre']['gestionArticles']; ?></h1>
    <span id="ajout"><?php echo $this->_trad['ajouterArticle']; ?></span>
</div>
<div class="ligne">
    <?php echo $this->form->msg; ?>
    <table>
    <tr>
        <?php
        foreach($table['champs'] as $champ=>$info ){
            $cols = ($champ == 'active')? 'colspan="2"': '';
            echo '<th ' . $cols . '>
                <form action="' . LINK . '?nav=articles" method="POST">
                    <input type="hidden" name="ord" value="' . $champ . '">
                    <input type="submit" name="" value="' . $info . '">
                </form>
                </th>';
        }
        ?>
    </tr>
    <?php
    if(is_array($table) AND !empty($table['info'])){
    foreach($table['info'] as $ligne=>$article){
            $class = ($ligne%2 == 1)? 'lng1':'lng2' ; ?>
        <tr class="<?php echo $class; ?>">
            <?php
            foreach($article as $champ=>$info ){
                echo "<td>$info</td>";
            }
        ?>
        </tr>
        <?php }
        } ?>
    </table>
</div>
<?php
//echo $alert;
?>
