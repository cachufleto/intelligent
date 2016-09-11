<?php
namespace Model;
use App\Bdd;

/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 09/03/2016
 * Time: 13:35
 */
class articles extends Bdd
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function articlesUpdate($sql_set, $id_article)
    {
        $sql = 'UPDATE articles SET ' . $sql_set . '  WHERE id_article = ' . $id_article;
        $this->executeRequete($sql);
    }

    protected function setArticlesActive($id, $active)
    {

        $sql = "UPDATE articles SET active = $active WHERE id_article = $id";
        $this->executeRequete($sql);
    }

    protected function selectArticles()
    {
        $sql = "SELECT * FROM articles where active = 1 " . recherchePernonnes();
        return $this->executeRequete($sql);
    }

    protected function selectArticlesOrder($order, $listeId)
    {
        $sql = "SELECT id_article, titre, capacite, categorie, photo
            FROM articles WHERE active = 1 " . ((!empty($listeId)) ? " AND $listeId " : "") .
            recherchePernonnes() . " ORDER BY $order";
        return $this->executeRequete($sql);
    }

    protected function selectArticlesUsers($order)
    {
// selection de tout les users sauffe le super-ADMIN
        $sql = "SELECT id_article, titre, capacite, cap_min, categorie, photo, active, prix_personne, tranche
            FROM articles " . (!isSuperAdmin() ? " WHERE active != 0 " : "") .
            recherchePernonnes() .
            " ORDER BY $order";
        return $this->executeRequete($sql);
    }


    protected function selectListeDistinc($champ, $table)
    {

        $sql = "SELECT DISTINCT $champ FROM $table ORDER BY $champ ASC";
        return $this->executeRequete($sql);

    }

    protected function selectProduitsArticle($id)
    {
        $sql = "SELECT p.*, h.description
            FROM produits p, plagehoraires h
            WHERE id_article = $id
              AND p.id_plagehoraire = h.id
            ORDER BY id_plagehoraire ASC";
        return $this->executeRequete($sql);
    }

    protected function setProduit($_id, $key)
    {
        $sql = "INSERT INTO `produits` (`id`, `id_article`, `id_plagehoraire`) VALUES (NULL, '$_id', '$key');";
        return $this->executeRequete($sql);
    }

    protected function deleteProduit($idproduit)
    {
        $sql = "DELETE FROM `produits` WHERE `id` = $idproduit";
        return $this->executeRequete($sql);
    }

    protected function setArticle($sql_champs, $sql_value)
    {
        // insertion en BDD
        $sql = " INSERT INTO articles ($sql_champs) VALUES ($sql_value)";
        return $this->executeRequete($sql);
        // ouverture d'une session
    }

    protected function selectArticleId($_id)
    {
        $sql = "SELECT * FROM articles WHERE id_article = " . $_id .
            (!isSuperAdmin() ? " AND active != 0" : "") .
            recherchePernonnes();
        return $this->executeRequete($sql);
    }

    protected function selectArticleReserves($date, $id)
    {
        $sql = "SELECT tranche FROM commandes WHERE date_reserve = '$date' AND id_article = $id";
        return $this->executeRequete($sql);
    }

    protected function selectArticleReservesMembres($date, $id)
    {
        $sql = "SELECT c.tranche, r.id_membre
            FROM commandes c, reservations r
            WHERE c.id_article = $id
              AND c.date_reserve = '$date'
              AND c.id_reservation = r.id";
        return $this->executeRequete($sql);
    }
}