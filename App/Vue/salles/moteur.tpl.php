<?php
/**
 * Created by PhpStorm.
 * User: Domoquick
 * Date: 22/06/2016
 * Time: 18:44
 */
$disponibilite = disponibilite();

echo <<<EOL
<div class="ligne">
    <h1>{$this->_trad['nav'][$this->nav]}</h1>
</div>
<div class="ligne">
    <p>{$this->form->msg}</p>
    <div class="trier">
        <div>{$this->_trad['trierPar']}</div>
        <div>
            <form action="$lien" method="POST">
                <input type="hidden" name="ord" value="id_salle">
                <input type="submit" name="" value="REF">
            </form>
        </div><div>
            <form action="$lien" method="POST">
                <input type="hidden" name="ord" value="titre">
                <input type="submit" name="" value="{$this->_trad['champ']['titre']}">
            </form>
        </div><div>
            <form action="$lien" method="POST">
                <input type="hidden" name="ord" value="capacite">
                <input type="submit" name="" value="{$this->_trad['champ']['capacite']}">
            </form>
        </div>
        <div>
            <form action="$lien" method="POST">
                <input type="hidden" name="ord" value="categorie">
                <input type="submit" name="" value="{$this->_trad['champ']['categorie']}">
            </form>
        </div>
    </div>
    <div class="trier">
        <div>
            $disponibilite
        </div>
    </div>
</div>
EOL;
