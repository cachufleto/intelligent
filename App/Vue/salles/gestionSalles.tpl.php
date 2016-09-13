<?php
$link = LINK;
echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['titre']['gestionSalles']}</h1>
    <span id="ajout">{$this->_trad['ajouterSalle']}</span>
</div>
<div class="ligne">
    {$this->form->msg}
    <table>
    <tr>
EOL;

        foreach($table['champs'] as $champ=>$info ){
            $cols = ($champ == 'active')? ' colspan="2"': '';
            echo <<<EOL
        <th$cols>
        <form action="$link?nav=salles" method="POST">
            <input type="hidden" name="ord" value="$champ">
            <input type="submit" name="" value="$info">
        </form>
        </th>
EOL;
        }
    echo '
    </tr>';

    if(is_array($table) AND !empty($table['info'])){
        foreach($table['info'] as $ligne=>$salle){
                $class = ($ligne%2 == 1)? 'lng1':'lng2';
            echo '
            <tr class="'.$class.'">';
                foreach($salle as $champ=>$info ){
                    echo "<td>$info</td>";
                }
            echo '
            </tr>';
            }
        }
    echo '
    </table>
</div>
', $alert;
