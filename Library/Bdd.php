<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 03/09/2016
 * Time: 23:51
 */

namespace App;


class Bdd
{
    var $BDD = '';
    var $connexion = FALSE;
    var $_trad = '';
    
    public function __construct()
    {
        $this->BDD = setBDD();
        $this->_trad = setTrad();
        $this->connectMysqli();
    }

    protected function executeRequeteInsert($req)
    {
        _debug($req, 'SQL INSERTION');
        $resultat = $this->connexion->query($req);
        if(!$resultat) {
            die ($this->_trad['erreur']['ATTENTIONErreurSurRequeteSQL']);// . $req . '<br /><b>---> : </b>' . $this->connexion->error . '<br />');
        }
        $resultat = $this->connexion->insert_id;
        return $resultat;
    }

    # Fonction executeRequete()
    # Exe requette SQL
    # $req => string SQL
    # BLOQUANT
    # RETURN object
    protected function executeRequete($req)
    {
        _debug($req, 'SQL REQUETTE');
        $resultat = $this->connexion->query($req);
        if(!$resultat) {
            die ($this->_trad['erreur']['ATTENTIONErreurSurRequeteSQL'] . $req . '<br /><b>---> : </b>' . $this->connexion->error . '<br />');
        }
        return $resultat;
    }

    # Fonction executeMultiRequete()
    # Exe requette SQL
    # $req => string SQL
    # BLOQUANT
    # RETURN object
    protected function executeMultiRequete($req)
    {
        _debug($req, 'SQL Multi - REQUETTE');
        if ($this->connexion->multi_query($req)) {
            $i = 0;
            do {
                $this->connexion->next_result();
                $i++;
            }
            while( $this->connexion->more_results() );
            return true;
        }
        return false;
    }

    protected function connectMysqli()
    {
        $this->connexion = @new \mysqli($this->BDD['SERVEUR_BDD'], $this->BDD['USER'], $this->BDD['PASS'], $this->BDD['BDD']);
        // Jamais de ma vie je ne metterais un @ pour cacher une erreur sauf si je le gere proprement avec ifx_affected_rows
        if($this->connexion->connect_error) {
            die("Un probleme est survenu lors de la connexion à la BDD" . $this->connexion->connect_error);
        }
        $this->connexion->set_charset("utf-8"); // en cas de souci d'encodage avec l'utf-8
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        //$this->connexion->close() or die ($this->_trad['erreur']['ATTENTIONImpossibleFermerConnexionBDD'] . ${$this->connexion}->error . '<br />');
    }
}