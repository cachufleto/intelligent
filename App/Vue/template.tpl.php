<?php
$disponibilite = disponibiliteArticles();
_debug([
	'$disponibilite'=>$disponibilite,
	'$_SESSION[\'lang\']'=>$_SESSION['lang'],
	'$titre'=>$titre,
	'$_link'=>$_link,
	'$navPp'=>$navPp,
	'$footer'=>$footer
], 'TEMPLATE');

echo <<<EOL
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$titre}</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Archivo+Narrow:400,700" rel="stylesheet" type="text/css">
<link href="{$app->_trad['URLSite']}css/style.css" rel="stylesheet" type="text/css" media="all" />
{$_link}
<script src="{$app->_trad['URLSite']}js/script.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper-bg">
	<div id="wrapper">
		<div id="header" class="container">
			<div id="logo">
				<a href="{$app->_trad['URLSite']}" alt="INTELLIGENT Robotique"><img src='img/intelligent.png'></a>
			</div>
			<div id="menu">
				<ul>
					{$navPp}
				</ul>
			</div>
		</div>
		<!-- CORP -->
			$contentPage
		<!-- FIN CORP -->
		<div id="page">
			<div id="content">
			</div>

			<div id="sidebar">
			</div>
		</div>
	</div>
	<div id="footer-content" class="container">
		<!-- div id="fbox1">
			<h2>Recent Updates</h2>
			<ul class="style3">
				<li class="first">
					<p class="date"><a href="#">April<b>20</b></a></p>
					<h3>Amet sed volutpat mauris</h3>
					<p><a href="#">Mauris tempus nibh sodales adipiscing dolore.</a></p>
				</li>
				<li>
					<p class="date"><a href="#">April<b>18</b></a></p>
					<h3>Sagittis diam dolor sit amet</h3>
					<p><a href="#">Duis arcu tortor fringilla sed  sed magna.</a></p>
				</li>
				<li>
					<p class="date"><a href="#">April<b>15</b></a></p>
					<h3>Adipiscing sed consequat</h3>
					<p><a href="#">Pharetra ac velit sed in volutpat nisl mauris vel.</a></p>
				</li>
				<li>
			</ul>
		</div -->
		<div id="fbox2">
			<h2>SUR QUOI!</h2>
			<p>Ceci est un modèle de CSS libre, totalement conforme aux standards conçue par
			<a href="http://domoquick.fr" rel="nofollow">MOIMEMME</a>.
			Ce modèle gratuit est publié sous la licence <a href="http://domoquick.fr">Creative Commons Attribution</a>,
			de sorte que vous êtes à peu près
			libre de faire ce que vous voulez avec elle (même l'utiliser dans le commerce) à condition que vous nous
			donnez le crédit. domoquick.fr</p>
			<a href="{$app->_trad['URLSite']}?nav=cgv" class="button-style">Conditions Générales</a> </div>
		<div id="fbox3">
			<h2>Contact</h2>
			<p>Nam erat a posuere laoreet eget nibh sodales adipiscing. Phasellus tristique dui.</p>
			<ul class="style5">
				<li class="first"><span class="address">Address</span> <span class="address-01">57 Av. Montaigne <br />
					75008 Paris, France</span> </li>
				<li> <span class="mail">Mail</span> <span class="mail-01"><a href="mailto:info@domoquick.fr">info@domoquick.fr</a></span> </li>
				<li> <span class="phone">Phone</span> <span class="phone-01">(33) 09 06 06 06 06</span> </li>
			</ul>
		</div>
	</div>
</div>
<div id="footer">
	<p>&copy; Tout droit réservé. Design par <a href="http://domoquick.fr" rel="nofollow">CHARTRE GRAPHIQUE</a>.
	Photos by <a href="http://domoquick.fr/">Fotogrph</a>.</p>
</div>
<div style="background-color: indianred">
$debug;
</div>
</body>
</html>
EOL;
