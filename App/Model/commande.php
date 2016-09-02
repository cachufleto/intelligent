<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 20/06/2016
 * Time: 01:14
 */
function selectSalleId($_id)
{
    $sql = "SELECT * FROM salles WHERE id_salle = ". $_id .
        ( !isSuperAdmin()? " AND active != 0" : "" ) .
        recherchePernonnes();
    return executeRequete($sql);
}

function selectProduitsSalle($id)
{
    $sql = "SELECT p.*, h.description
            FROM produits p, plagehoraires h
            WHERE id_salle = $id
              AND p.id_plagehoraire = h.id
            ORDER BY id_plagehoraire ASC";
    return executeRequete($sql);
}

function setReservations()
{
    $sql = "INSERT INTO `reservations` (`id`, `id_membre`, `date_facturacion`) VALUES (NULL, '{$_SESSION['user']['id']}', CURRENT_TIMESTAMP)";
    return executeRequeteInsert($sql);
}

function setComandes($commande)
{
    $sql = "INSERT INTO `commandes` (`id`, `id_reservation`, `id_salle`, `date_facturacion`, `date_reserve`,
                                      `tranche`, `capacitee`, `prix`, `reduction`, `prix_ttc`)
                              VALUES (NULL, '{$commande['id_reservation']}', '{$commande['id_salle']}',
                                      '{$commande['date_facturation']}', '{$commande['date']}',
                                      '{$commande['tranche']}', '{$commande['capacitee']}', '{$commande['prix']}',
                                      '{$commande['reduction']}', '{$commande['prix_ttc']}');";
    return executeRequeteInsert($sql);
}

function selectProduitsCommandes()
{
    $date = date('Y-m-d H:i:s', (time()-10*(60*60*24)));
    $req = "SELECT
                r.id, r.date_facturacion,
                c.id_salle, c.date_reserve, c.tranche, c.capacitee, c.prix, c.reduction, c.prix_TTC,
                s.titre
            FROM `reservations` as r, `commandes` as c, `salles` as s
            WHERE r.id_membre = {$_SESSION['user']['id']}
              AND c.date_reserve >= '$date'
              AND c.id_salle = s.id_salle
              AND r.id = c.id_reservation
            ORDER BY c.date_reserve ASC, c.tranche ASC";
    return executeRequete($req);
}

function selectProduitsGestionCommandes()
{
    $date = date('Y-m-d H:i:s', (time()-10*(60*60*24)));
    $req = "SELECT
                r.id, r.date_facturacion,
                c.id_salle, c.date_reserve, c.tranche, c.capacitee, c.prix, c.reduction, c.prix_TTC,
                s.titre,
                m.nom, m.prenom
            FROM `reservations` as r, `commandes` as c, `salles` as s, membres as m
            WHERE c.date_reserve >= '$date'
              AND r.id = c.id_reservation
              AND c.id_salle = s.id_salle
              AND r.id_membre = m.id
            ORDER BY c.tranche ASC, c.date_reserve ASC";
    return executeRequete($req);
}

