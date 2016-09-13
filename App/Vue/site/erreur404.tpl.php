<?php
echo <<<EOL
<div class="ligne">
	<h1>{$this->_trad['titre']['erreur404']}</h1>
</div>
<div class="ligne">
    <h2 style="text-align:center"><span style="color:red;">{$this->form->msg}</span></h2>
</div>
EOL;
