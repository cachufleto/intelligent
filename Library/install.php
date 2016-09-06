<?php
//if(utilisateurAdmin() && isset($_GET['install']) && $_GET['install'] == 'BDD')
namespace App;

class install extends Bdd
{
    public function __construct()
    {
        parent::__construct();
        $this->install();
    }

    public function install()
    {
        include_once MODEL . 'users.php';
        if (isset($_GET['install']) && $_GET['install'] == 'BDD') {

            // initialisation des tables
            header("refresh:2;url=index.php");
            echo "<p>chargement du fichier shema.sql.....</p>";
            $sql = file_get_contents(INC . '/SQL/shema.sql');

            if (isset($_GET['data'])) {
                // remplisage des tables
                echo "<p>Chargement du fichier data.sql....</p>";
                $sql .= file_get_contents(INC . '/SQL/data.sql');
            }
            // echo "<pre>$sql</pre>";
            if ($this->executeMultiRequete($sql)) {

                $membres = $this->executeRequete("SELECT id, mdp FROM membres");
                while ($membre = $membres->fetch_assoc()) {
                    $this->userUpdateMDP($membre['mdp'], $membre['id']);
                }
            }
            exit();
        }
    }

    protected function userUpdateMDP($mdp, $id)
    {
        $sql = "UPDATE membres SET mdp = '" . hashCrypt($mdp) . "' WHERE id = $id";
        $this->executeRequete($sql);
    }
}

$_i = new install();
