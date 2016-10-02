<?php

echo <<<EOL
<div id="three-column" class="container">
        <header>
        <h2>{$this->_trad['titre'][$this->nav]}</h2>
        </header>
        <div class="ligne">
                <div id="formulaire">
                        {$this->form->msg}
                        <form action="#" method="POST" enctype="multipart/form-data">
                                $form
                        </form>
                </div>
        </div>
</div>
EOL;
