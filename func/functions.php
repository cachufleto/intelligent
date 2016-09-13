<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 04/09/2016
 * Time: 00:12
 */

/*
 * RETURN array route
 */
/*function file_contents_route(){
    include ( CONF . 'route.php');
    return $route;
}*/



# Fonction isSuperAdmin()
# Verifie SESSION ADMIN ACTIVE
# RETURN Boolean
function isSuperAdmin()
{

    return(utilisateurAdmin() AND $_SESSION['user']['id'] == 1)? true : false;

}

# Fonction utilisateurAdmin()
# Verifie SESSION ADMIN ACTIVE
# RETURN Boolean
function utilisateurAdmin()
{

    return(utilisateurConnecte() AND $_SESSION['user']['statut'] == 'ADM')? true : false;

}

# Fonction utilisateurAdmin()
# Verifie SESSION ADMIN ACTIVE
# RETURN Boolean
function utilisateurEstCollaborateur ()
{

    return(utilisateurConnecte() AND $_SESSION['user']['statut'] == 'COL')? true : false;

}

# Fonction utilisateurConnecte()
# Verifie SESSION ACTIVE
# RETURN Boolean
function utilisateurConnecte()
{

    return (!isset($_SESSION['user']))? false : true;

}
