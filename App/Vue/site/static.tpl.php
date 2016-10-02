<?php
echo <<<EOL
		<div id="three-column" class="container">
			<header>
				<h2>{$this->_trad['titre'][$this->nav]}</h2>
			</header>
EOL;
if(file_exists(APP . 'Public/statics/' . $this->nav . '.xhtml')){
    include APP . 'Public/statics/' . $this->nav . '.xhtml';
} else {
    echo $this->_trad['erreur']['statics'];
}
echo <<<EOL
		</div>
EOL;
