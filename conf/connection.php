<?php

////////////////////////////
///// BDD //////////////////
////////////////////////////
$BDD = array();
switch($_SERVER["SERVER_NAME"]){

	case 'intelligent.domoquick.fr':
		$BDD['SERVEUR_BDD'] = 'rdbms';
		$BDD['USER'] = 'U2682204';
		$BDD['PASS'] = '20Seajar!';
		$BDD['BDD'] = 'DB2682204';
		break;

	default:
		$BDD['SERVEUR_BDD'] = 'localhost';
		$BDD['USER'] = 'root';
		$BDD['PASS'] = '';
		$BDD['BDD'] = 'lokisalle';
}
