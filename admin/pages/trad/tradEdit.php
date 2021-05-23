<?php
require '../../../boot.php';

$class = 'trad';
$id = Request::requestId();
if ($id>0) {
    $resRes = SQL::select(Lang::STORAGE, array('id' => $id), '*', '');
    if ($resRes)
        $item = $resRes->fetch_object();
}
?>
<form id="trad_edit_form" method="post" action="pages/trad/tradSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?'Trad : '.$item->text:$lang->l('new_trad')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('text'); ?> </label><input type="text" name="text" class="w50" value="<?= (isset($item)) ? htmlentities($item->text) : '' ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('trad_fr'); ?> </label><input type="text" name="fr" value="<?= (isset($item)) ? htmlentities($item->fr) : '' ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('trad_en'); ?> </label><input type="text" name="en" value="<?= (isset($item)) ? htmlentities($item->en) : '' ?>" /></div>
    </fieldset>
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('trad');"/>
</form>
<script>
    var isCtrl = false;
    document.onkeyup=function(e){
        if(e.keyCode == 17) isCtrl=false;
    }
    document.onkeydown=function(e){
        if(e.keyCode == 17) isCtrl=true;
        if(e.keyCode == 83 && isCtrl == true) {
            return save('<?= strtolower($class) ?>', 0);
        }
    }
    inittiny();
</script>