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
    function userSelectContactAll()
    {
        $sql = "SELECT * FROM membres WHERE statut != 'MEM';";
        return executeRequete($sql);
    }

    function selectSallesActive()
    {
        // selection de tout les users sauffe le super-ADMIN
        $sql = "SELECT id_salle, pays, ville, titre, capacite, categorie, photo, description, active
            FROM salles
            WHERE active != 0
            ORDER BY titre
            LIMIT 0,3;";
        return executeRequete($sql);
    }
}