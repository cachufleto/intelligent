<?php
namespace Model;
use App\Bdd;

/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 20/06/2016
 * Time: 01:14
 */
class commande extends Bdd
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function selectSalleId($_id)
    {
        $sql = "SELECT * FROM salles WHERE id_salle = " . $_id .
            (!isSuperAdmin() ? " AND active != 0" : "") .
            recherchePernonnes();
        return $this->executeRequete($sql);
    }

    protected function selectArticleId($_id)
    {
        $sql = "SELECT * FROM articles WHERE id_article = " . $_id .
            (!isSuperAdmin() ? " AND active != 0" : "") .
            rechercheArticles();
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

    protected function selectProduitsArticle($id)
    {
        $sql = "SELECT p.*, h.description
            FROM produits p, plagehoraires h
            WHERE id_salle = $id
              AND p.id_plagehoraire = h.id
            ORDER BY id_plagehoraire ASC";
        return $this->executeRequete($sql);
    }

    protected function setReservations()
    {
        $sql = "INSERT INTO `reservations` (`id`, `id_membre`, `date_facturacion`)
                VALUES (NULL, '{$_SESSION['user']['id']}', CURRENT_TIMESTAMP)";
        return $this->executeRequeteInsert($sql);
    }

    protected function unStockComandesArticles($commande)
    {
        $sql = "UPDATE articles SET stock = (stock - {$commande['quantite']})
                WHERE id_article = {$commande['id_article']};";
        return $this->executeRequeteInsert($sql);

    }

    protected function setComandesArticles($commande)
    {
        $sql = "INSERT INTO `ventes` (`id`, `id_reservation`, `id_article`, `date_facturacion`, `date_reserve`,
                      `ean`, `quantite`, `prix`, `reduction`, `prix_ttc`)
              VALUES (NULL, '{$commande['id_reservation']}', '{$commande['id_article']}',
                      '{$commande['date_facturation']}', '{$commande['date']}',
                      '{$commande['ean']}', '{$commande['quantite']}', '{$commande['prix']}',
                      '{$commande['reduction']}', '{$commande['prix_ttc']}');";
        return $this->executeRequeteInsert($sql);
    }

    protected function selectProduitsCommandes()
    {
        $date = date('Y-m-d H:i:s', (time() - 10 * (60 * 60 * 24)));
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
        return $this->executeRequete($req);
    }

    protected function selectArticlesCommandes()
    {
        $req = "SELECT
                r.id, r.date_facturacion,
                v.id_article, v.date_reserve, v.ean, v.quantite, v.prix, v.reduction, v.prix_TTC,
                a.produit
            FROM `reservations` as r, `ventes` as v, `articles` as a
            WHERE r.id_membre = {$_SESSION['user']['id']}
              AND v.id_article = a.id_article
              AND r.id = v.id_reservation
            ORDER BY v.date_reserve ASC, a.produit ASC";
        return $this->executeRequete($req);
    }

    protected function selectProduitsGestionCommandes()
    {
        $date = date('Y-m-d H:i:s', (time() - 10 * (60 * 60 * 24)));
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
        return $this->executeRequete($req);
    }
}
