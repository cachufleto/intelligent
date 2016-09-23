<?php
//if(utilisateurAdmin() && isset($_GET['install']) && $_GET['install'] == 'BDD')
namespace App;
use App\Bdd;

class install extends Bdd
{
    public function __construct()
    {
        parent::__construct();
        $this->install();
    }

    protected function install()
    {
        // initialisation des tables
        $msg = "<p>chargement du fichier shema.sql.....</p>";
        $sql = file_get_contents(INC . '/SQL/shema.sql');

        if (isset($_GET['data'])) {
            // remplisage des tables
            $msg .= "<p>Chargement du fichier data.sql....</p>";
            $sql .= file_get_contents(INC . '/SQL/data.sql');
        }
        // echo "<pre>$sql</pre>";
        if ($this->executeMultiRequete($sql)) {

            $membres = $this->executeRequete("SELECT id, mdp FROM membres");
            while ($membre = $membres->fetch_assoc()) {
                $this->userUpdateMDP($membre['mdp'], $membre['id']);
            }
            header("refresh:2;url=index.php");
            exit($msg);
        }
        exit('ERROR: merci de contacter votre administrateur.');
    }

    protected function userUpdateMDP($mdp, $id)
    {
        $sql = "UPDATE membres SET mdp = '" . hashCrypt($mdp) . "' WHERE id = $id";
        $this->executeRequete($sql);
    }
}

$_i = new install();
unset($_i);