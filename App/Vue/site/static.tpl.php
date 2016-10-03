<?php
echo <<<EOL
		<div id="three-column" class="container">
			<header>
				<h2>{$this->_trad['titre'][$this->nav]}</h2>
			</header>
EOL;
if(file_exists(RACINE_SERVER . RACINE_SITE . 'statics/' . $this->nav . '.xhtml')){
    include RACINE_SERVER . RACINE_SITE . 'statics/' . $this->nav . '.xhtml';
} else {
    echo $this->_trad['erreur']['statics'];
}
echo <<<EOL
		</div>
EOL;
