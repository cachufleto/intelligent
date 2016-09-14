<?php
namespace Model;
use App\Bdd;

/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 09/03/2016
 * Time: 13:35
 */
class salles extends Bdd
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function sallesUpdate($sql_set, $id_salle)
    {
        $sql = 'UPDATE salles SET ' . $sql_set . '  WHERE id_salle = ' . $id_salle;
        $this->executeRequete($sql);
    }

    protected function setSallesActive($id, $active)
    {

        $sql = "UPDATE salles SET active = $active WHERE id_salle = $id";
        $this->executeRequete($sql);
    }

    protected function selectSalles()
    {
        $sql = "SELECT * FROM salles where active = 1 " . recherchePernonnes();
        return $this->executeRequete($sql);
    }

    protected function selectSallesOrder($order, $listeId)
    {
        $sql = "SELECT id_salle, titre, capacite, categorie, photo
            FROM salles WHERE active = 1 " . ((!empty($listeId)) ? " AND $listeId " : "") .
            recherchePernonnes() . " ORDER BY $order";
        return $this->executeRequete($sql);
    }

    protected function selectSallesUsers($order)
    {
        // selection de tout les users sauffe le super-ADMIN
        $sql = "SELECT id_salle, titre, capacite, cap_min, categorie, photo, active, prix_personne, tranche
            FROM salles " . (!isSuperAdmin() ? " WHERE active != 0 " : "") .
            recherchePernonnes() .
            " ORDER BY $order";
        return $this->executeRequete($sql);
    }


    protected function selectListeDistinc($champ, $table)
    {
        $sql = "SELECT DISTINCT $champ FROM $table ORDER BY $champ ASC";
        return $this->executeRequete($sql);
    }

    protected function selectProduitsSalle($id)
    {
        $sql = "SELECT p.*, h.description
            FROM produits p, plagehoraires h
            WHERE id_salle = $id
              AND p.id_plagehoraire = h.id
            ORDER BY id_plagehoraire ASC";
        return $this->executeRequete($sql);
    }

    protected function setProduit($_id, $key)
    {
        $sql = "INSERT INTO `produits` (`id`, `id_salle`, `id_plagehoraire`) VALUES (NULL, '$_id', '$key');";
        return $this->executeRequete($sql);
    }

    protected function deleteProduit($idproduit)
    {
        $sql = "DELETE FROM `produits` WHERE `id` = $idproduit";
        return $this->executeRequete($sql);
    }

    protected function setSalle($sql_champs, $sql_value)
    {
        // insertion en BDD
        $sql = " INSERT INTO salles ($sql_champs) VALUES ($sql_value)";
        return $this->executeRequete($sql);
        // ouverture d'une session
    }

    protected function selectSalleId($_id)
    {
        $sql = "SELECT * FROM salles WHERE id_salle = " . $_id .
            (!isSuperAdmin() ? " AND active != 0" : "") .
            recherchePernonnes();
        return $this->executeRequete($sql);
    }

    protected function selectSalleReserves($date, $id)
    {
        $sql = "SELECT tranche FROM commandes WHERE date_reserve = '$date' AND id_salle = $id";
        return $this->executeRequete($sql);
    }

    protected function selectSalleReservesMembres($date, $id)
    {
        $sql = "SELECT c.tranche, r.id_membre
            FROM commandes c, reservations r
            WHERE c.id_salle = $id
              AND c.date_reserve = '$date'
              AND c.id_reservation = r.id";
        return $this->executeRequete($sql);
    }
}