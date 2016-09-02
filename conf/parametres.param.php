<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 12/06/2016
 * Time: 11:08
 */
$_trad = setTrad();

$_prixPlage = [];
$_prixPlage[4]['taux'] = 1.15;
$_prixPlage[3]['taux'] = 1;
$_prixPlage[2]['taux'] = 0.95;
$_prixPlage[1]['taux'] = 0.90;

$_prixPlage[4]['libelle'] = 'nocturne';
$_prixPlage[3]['libelle'] = 'soiree';
$_prixPlage[2]['libelle'] = 'journee';
$_prixPlage[1]['libelle'] = 'matinee';

$_prixPlage[4]['horaire'] = '08:00h - 12:00h';
$_prixPlage[3]['horaire'] = '13:00h - 17:00h';
$_prixPlage[2]['horaire'] = '18:00h - 22:00h';
$_prixPlage[1]['horaire'] = '22:00h - 05:00h';

$_tranches = [];
$_tranches['T1'][1] = 1;

$_tranches['T2'][1] = 1.04;
$_tranches['T2'][2] = 1;

$_tranches['T3'][1] = 1.03;
$_tranches['T3'][2] = 1.015;
$_tranches['T3'][3] = 1;

$_tranches['T4'][1] = 1.02;
$_tranches['T4'][2] = 1.01;
$_tranches['T4'][3] = 1;
$_tranches['T4'][4] = 0.985;
