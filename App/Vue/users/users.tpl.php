<?php
$infoForm = '';
foreach($table['champs'] as $champ=>$info ){
    $cols = ($champ == 'active')? ' colspan="2"': '';
    $infoForm .= "<th$cols>$info</th>";
}

$infoForm .= '
</tr>';

foreach($table['info'] as $ligne=>$membre){
    $class = ($ligne%2 == 1)? 'lng1':'lng2' ;
    $infoForm .= '
    <tr class="'.$class.'">';
        foreach($membre as $champ=>$info ){
            $infoForm .= "<td>$info</td>";
        }
    $infoForm .= '
    </tr>';
}

echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
    <p>{$this->form->msg}</p>
    <table>
        <tr>
        $infoForm
    </table>
</div>
EOL;
