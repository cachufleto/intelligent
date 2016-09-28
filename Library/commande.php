<?php

/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 20/06/2016
 * Time: 22:51
 */

namespace App;

class commande extends \Model\commande
{
    var $_trad = [];

    public function __construct()
    {
        $this->_trad = setTrad();
        parent::__construct();
    }

    protected function listeProduitsFacture()
    {
        $listePrix = [];
        if (isset($_SESSION['panierArticles']) && !empty($_SESSION['panierArticles'])) {
            $listeOrdenee = sortIndice($_SESSION["panierArticles"]);
            foreach ($listeOrdenee as $key => $id) {
                $data = $this->selectArticleId($id);
                $article = $data->fetch_assoc();
                $article['quantite'] = $_SESSION['panierArticles'][$id];
                $this->listeProduitsPrixFacture($article);
                $listePrix[] = $article;
            }
        }
        return $listePrix;
    }

    protected function listeProduitsCommandes()
    {
        $listePrix = [];
        $salles = $this->selectProduitsCommandes();
        $Commandes = $salles->fetch_assoc();

        if (isset($Commandes) && !empty($Commandes)) {
            while ($Commandes = $salles->fetch_assoc()) {
                $listePrix[] = $Commandes;
            }
        }

        return $listePrix;
    }

    protected function listeArticlesCommandes()
    {
        $listePrix = [];
        $articles = $this->selectArticlesCommandes();
        if ($articles->num_rows >0) {
            while ($Commandes = $articles->fetch_assoc()) {
                if(empty($listePrix)){
                    _debug($Commandes, 'COMMANDES '.__FUNCTION__);
                }
                $listePrix[] = $Commandes;
            }
        }

        return $listePrix;
    }

    protected function listeProduitsGestionCommandes()
    {
        $listePrix = [];
        $articles = $this->selectProduitsGestionCommandes();
        $Commandes = $articles->fetch_assoc();

        if (isset($Commandes) && !empty($Commandes)) {
            while ($liste = $Commandes->fetch_assoc()) {
                if(empty($listePrix)){
                    _debug($liste, 'COMMANDES '.__FUNCTION__);
                }
                $listePrix[] = $liste;
            }
        }

        return $listePrix;
    }

    protected function listeProduitsPrixFacture(&$data)
    {
        $data['prix'] = $data['prix_Achat'] * 1.3;
        $data['prix_total'] = $data['prix'] * $data['quantite'];
    }

    protected function listeProduitsPrixCommandes($date, $data)
    {
        $_listeReservation = $_reserve = [];

        $i = $_total = 0;

        if ($prix = $this->selectProduitsSalle($data['id_salle'])) {
            while ($info = $prix->fetch_assoc()) {
                $prixSalle = listeCapacites($data, $info);
                $i++;
                $reservation = (isset($_SESSION['panier'][$date][$data['id_salle']])) ?
                    $_SESSION['panier'][$date][$data['id_salle']] : [];

                foreach ($prixSalle as $key => $produit) {
                    if (isset($reservation[$i]) && $reservation[$i] == $key) {
                        $_reserve['date'] = $date;
                        $_reserve['titre'] = $data['titre'];
                        $_reserve['libelle'] = $produit['libelle'];
                        $_reserve['num'] = $produit['num'];
                        $_reserve['prix'] = $produit['prix'];
                        $_listeReservation[] = $_reserve;
                    }
                }
            }
        }

        return $_listeReservation;
    }

    protected function generationProduitsFacture()
    {
        $listePrix = [];
        if (isset($_SESSION['panierArticles']) && !empty($_SESSION['panierArticles'])) {
            $listeOrdenee = sortIndice($_SESSION["panierArticles"]);
            foreach ($listeOrdenee as $key => $id) {
                    $data = $this->selectArticleId($id);
                    $article = $data->fetch_assoc();
                    $listePrix[] = $this->generationProduitsPrixFacture($article);
            }
        }
        $_liste = [];
        foreach ($listePrix as $date => $info) {
            //foreach ($data as $key => $info) {
                if (!empty($info)) {
                    $commande['id_article'] = $info['id_article'];
                    $commande['date'] = date('Y-m-d H:i:s');
                    $commande['ean'] = $info['ean'];
                    $commande['quantite'] = $info['quantite'];
                    $commande['prix'] = $info['prix'];
                    $commande['reduction'] = 0;
                    $_liste[] = $commande;
                }
            //}
        }
        return $_liste;
    }

    protected function generationProduitsPrixFacture($data)
    {
        $data['quantite'] = $_SESSION['panierArticles'][$data['id_article']];
        $data['prix'] = $data['prix_Achat']* 1.3;
        $data['prix_total'] = $data['prix'] * $data['quantite'];
        return $data;
    }
}
