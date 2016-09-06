<!DOCTYPE html>
<?php $_trad = setTrad(); ?>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
	<title><?php echo (isset($_trad['titre'][$nav])? $_trad['titre'][$nav] : "INTELLIGENT"); ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Projet Final DIWoo10 2015 - 2016, Intelligent">
	<meta name="author" content="Carlos PAZ DUPRIEZ">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo LINK;  ?>img/favicon.ico" type="image/x-icon">
	<?php echo $_link; ?>
	<script src="<?php echo LINK;  ?>js/script.js" type="text/javascript"></script>
</head>

<body class="body">
<!-- ENTETE -->
<header class="mainHeader">
	<a class="logo" href="?"><img src="<?php echo LINK; ?>img/intelligent.png" alt="intelligent" class="logo"></a>
	<nav>
		<ul>
			<?php echo $navPp; ?>
		</ul>
	</nav>
</header>
<!-- CORP -->
<section class="mainContent">
	<?php
		echo $contentPage;
	?>
	<div class="barre">&nbsp;</div>
</section>
<!-- DEBUG -->
<section id="debug">
	<?php
	echo $debug;
	?>
</section>
<!-- PIED DE PAGE -->
<footer class="mainFooter">
	<div class="ligne">
		<nav>
			<ul>
				<?php echo $footer['menu']; ?>
				<li>
					<a class="version" href=""><?php echo $footer['version']; ?></a>
				</li>
			</ul>
		</nav>
	</div>
</footer>
</body>
</html>