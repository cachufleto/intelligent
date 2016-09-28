<?php
namespace commande;
use App\formulaire;

include_once MODEL . 'commande.php';
include_once LIB . 'commande.php';

/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 20/06/2016
 * Time: 01:02
 */

class commande extends \App\commande
{
    var $form = false;
    var $nav = 'commande';

    public function __construct()
    {
        $this->form = new formulaire();
        parent::__construct();
    }

    public function validerCommande()
    {
        $this->urlReservation();
        $listePrix = $this->listeProduitsFacture();
        include_once VUE . 'commande/validerCommande.tpl.php';
    }

    protected function urlReservation()
    {
            if(utilisateurConnecte()){
                return true;
            }
            header('refresh:0;url=index.php?nav=actif');
            echo "<html>{$this->_trad['erreur']['produitConnexion']}</html>";
    }

    public function validerFacture()
    {
        //$this->_trad
        $facture = $this->generationProduitsFacture();
        $id = $this->setReservations();
        $date_facturation = date('Y-m-d H:i:s');
        foreach($facture as $key=>$commande){
            $commande['id_reservation'] = $id;
            $commande['date_facturation'] = $date_facturation;
            $commande['prix_ttc'] = $commande['quantite'] * ($commande['prix'] - $commande['reduction'] ) * (1 + TVA);
            $this->unStockComandesArticles($commande);
            $this->setComandesArticles($commande);
        }
        //unset($_SESSION['panierArticles']);
        header('refresh:2;url=index.php');
        echo "<h4>{$this->_trad['factureOk']}</h4>";
    }

    public function commandes()
    {
        //$nav = 'commande';
        //$this->_trad
        //$listePrix = $this->listeProduitsCommandes();
        $listePrix = $this->listeArticlesCommandes();

        include_once VUE . 'commande/commandes.tpl.php';
    }

    public function backOff_gestionCommandes()
    {
        //$nav = 'commande';
        //$this->_trad
        $listePrix = $this->listeProduitsGestionCommandes();

        include_once VUE . 'commande/gestionCommandes.tpl.php';
    }
}
