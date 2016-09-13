<?php //$this->_trad ?>
<div class="ligne">
    <h2><?php echo $this->_trad['titre'][$this->nav]; ?></h2>
</div>
<div class="ligne">
<?php if(file_exists(APP . 'Public/statics/' . $this->nav . '.xhtml')){
    include APP . 'Public/statics/' . $this->nav . '.xhtml';
} else {
    echo $this->_trad['erreur']['statics'];
} ?>
</div>