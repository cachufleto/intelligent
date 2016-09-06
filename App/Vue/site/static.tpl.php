<?php //$this->_trad ?>
<div class="ligne">
    <h2><?php echo $this->_trad['titre'][$nav]; ?></h2>
</div>
<div class="ligne">
<?php if(file_exists(APP . 'Public/statics/' . $nav . '.xhtml')){
    include APP . 'Public/statics/' . $nav . '.xhtml';
} else {
    echo $this->_trad['erreur']['statics'];
} ?>
</div>