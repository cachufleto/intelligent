<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 09/03/2016
 * Time: 13:35
 */

function sallesUpdate($sql_set, $id_salle){

    $sql = 'UPDATE salles SET '.$sql_set.'  WHERE id_salle = '.$id_salle;
    executeRequete($sql);
}

function setSallesActive($id, $active){

    $sql = "UPDATE salles SET active = $active WHERE id_salle = $id";
    executeRequete($sql);
}

function selectSalles()
{
    $sql = "SELECT * FROM salles where active = 1 " . recherchePernonnes();
    return executeRequete($sql);
}

function selectSallesOrder($order, $listeId)
{
    $sql = "SELECT id_salle, titre, capacite, categorie, photo
            FROM salles WHERE active = 1 " . ((!empty($listeId))? " AND $listeId " : "") .
            recherchePernonnes() . " ORDER BY $order";
    return executeRequete($sql);
}

function selectSallesUsers($order)
{
// selection de tout les users sauffe le super-ADMIN
    $sql = "SELECT id_salle, titre, capacite, cap_min, categorie, photo, active, prix_personne, tranche
            FROM salles " . (!isSuperAdmin() ? " WHERE active != 0 " : "") .
            recherchePernonnes() .
            " ORDER BY $order";
    return executeRequete($sql);
}


function selectListeDistinc($champ, $table)
{

    $sql = "SELECT DISTINCT $champ FROM $table ORDER BY $champ ASC";
    return   executeRequete($sql);

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

function setProduit($_id, $key)
{
    $sql = "INSERT INTO `produits` (`id`, `id_salle`, `id_plagehoraire`) VALUES (NULL, '$_id', '$key');";
    return executeRequete($sql);
}

function deleteProduit($idproduit)
{
    $sql = "DELETE FROM `produits` WHERE `id` = $idproduit";
    return executeRequete($sql);
}

function setSalle($sql_champs, $sql_value)
{
    // insertion en BDD
    $sql = " INSERT INTO salles ($sql_champs) VALUES ($sql_value)";
    return executeRequete ($sql);
    // ouverture d'une session
}

function selectSalleId($_id)
{
    $sql = "SELECT * FROM salles WHERE id_salle = ". $_id .
        ( !isSuperAdmin()? " AND active != 0" : "" ) .
        recherchePernonnes();
    return executeRequete($sql);
}

function selectSalleReserves($date, $id)
{
    $sql = "SELECT tranche FROM commandes WHERE date_reserve = '$date' AND id_salle = $id";
    return executeRequete($sql);
}

function selectSalleReservesMembres($date, $id)
{
    $sql = "SELECT c.tranche, r.id_membre
            FROM commandes c, reservations r
            WHERE c.id_salle = $id
              AND c.date_reserve = '$date'
              AND c.id_reservation = r.id";
    return executeRequete($sql);
}