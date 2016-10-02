<?php
namespace Model;
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 09/03/2016
 * Time: 13:35
 */
use App\Bdd;

/**
 * @return bool|mysqli_result
 */
class site extends Bdd
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function userSelectContactAll()
    {
        $sql = "SELECT * FROM membres WHERE statut != 'MEM';";
        return $this->executeRequete($sql);
    }

    protected function selectArticlesActive()
    {
        // selection de tout les users sauffe le super-ADMIN
        $sql = "SELECT *
            FROM articles
            WHERE active != 0
            ORDER BY produit
            LIMIT 0,3;";
        return $this->executeRequete($sql);
    }
}