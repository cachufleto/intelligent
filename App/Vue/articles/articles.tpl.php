<?php

$lien = LINK . '?nav=' . $this->nav;
echo <<<EOL
<div id="three-column" class="container">
    <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
    </header>
EOL;
include VUE . 'articles/moteur.tpl.php';

if(!empty($table['info'])){
    foreach($table['info'] as $ligne=>$article){
        $nom = strtoupper($article['nom']);
        $active = isset($_SESSION['panier'][$_SESSION['date']][$article['ref']])? "active" : "";
        $info = listeInfoHeeden($article);
echo <<<EOL
			<div class="tbox">
				<div class="box-style">
					<div class="content">
					    <a href="{$article['link']}" class="image image-full">
					    <img class="trombi" src="{$article['photo']}">
					    </a>
						<h2>$nom</h2>
						<p>{$article['description']}</p>
						<p>REF:{$article['ref']}</p>
						{$article['categorie']}<br>
						{$article['position']}
						<a href="{$article['link']}" class="button-style">Learn More</a>
						</div>
				</div>
	            $info
			</div>
EOL;
    }
} else {
    echo 'Aucun article disponible!';
}
echo <<<EOL
$alert
</div>
EOL;
