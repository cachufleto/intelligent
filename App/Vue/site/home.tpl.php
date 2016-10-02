<?php
echo <<<EOL
	   <div id="banner" class="container">
			<img src="{$this->_trad['URLSite']}img/Robot_Agricole1200x400.jpg" width="1200" height="400" alt="" />
		</div>
		<div id="three-column" class="container">
			<header>
				<h2>{$this->_trad['dernieresOffres']}</h2>
			</header>
			$derniersOffres
		</div>
EOL;
