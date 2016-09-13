<?php
echo <<<EOL
<div class="ligne">
    <h2>{$this->_trad['titre'][$this->nav]}</h2>
</div>
<div class="ligne">
EOL;
if(file_exists(APP . 'Public/statics/' . $this->nav . '.xhtml')){
    include APP . 'Public/statics/' . $this->nav . '.xhtml';
} else {
    echo $this->_trad['erreur']['statics'];
}
echo '
</div>';
