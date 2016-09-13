<?php
echo <<<EOL
<!DOCTYPE html>
<html lang="{$_SESSION['lang']}">
<head>
	<title>$titre</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Projet Final DIWoo10 2015 - 2016, Intelligent">
	<meta name="author" content="Carlos PAZ DUPRIEZ">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="{$link}img/favicon.ico" type="image/x-icon">
	$_link
	<script src="<?php echo LINK;  ?>js/script.js" type="text/javascript"></script>
</head>

<body class="body">
<!-- ENTETE -->
<header class="mainHeader">
	<a class="logo" href="?"><img src="{$link}img/intelligent.png" alt="intelligent" class="logo"></a>
	<nav>
		<ul>
			$navPp
		</ul>
	</nav>
</header>
<!-- CORP -->
<section class="mainContent">
	$contentPage
	<div class="barre">&nbsp;</div>
</section>
<!-- DEBUG -->
<section id="debug">
	$debug
</section>
<!-- Pied de Page -->
<footer class="mainFooter">
	<div class="ligne">
		<nav>
			<ul>
				{$footer['menu']}
				<li>
					<a class="version" href="">{$footer['version']}</a>
				</li>
			</ul>
		</nav>
	</div>
</footer>
</body>
</html>
EOL;
