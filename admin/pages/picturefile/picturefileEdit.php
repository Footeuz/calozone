<?php
require '../../../boot.php';

$class = PictureFile::class;
if(isset($_REQUEST['id'])) $item = new PictureFile(intval($_REQUEST['id'])); else $item = new PictureFile();
if(isset($_REQUEST['parentid'])) $item->page_id = intval($_REQUEST['parentid']);

$list_picturepage[0] = '';
$picturepages = PicturePage::getStack('id ASC');
if (!empty($picturepages)) {
    foreach($picturepages as $val) {
        $list_picturepage[$val['id']] = $val['name'];
    }
}
?>
<form id="picturefile_edit_form" method="post" action="pages/picturefile/picturefileSave.php">
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    <input type="hidden" name="page_id" value="<?= $item->page_id ?>" />

    <h2><?= ($item->id?'Photo de la page : '.PicturePage::getName($item->page_id):$lang->l('new_picturefile')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('picture_page'); ?> </label><?= Render::select('page_id', $list_picturepage, $item->page_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('picture_name'); ?> </label><input type="text" name="name" class="w50" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2 clr"><label><?php echo $lang->l('picture_level'); ?> </label><input type="text" name="level" class="w50" value="<?= htmlentities($item->level) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('picture_position'); ?> </label><input type="text" name="position" class="w50" value="<?= htmlentities($item->position) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('picture_alt'); ?> </label><input type="text" name="alt" class="w50" value="<?= htmlentities($item->alt) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('picture_url'); ?> </label><input type="text" name="url" class="w50" value="<?= htmlentities($item->url) ?>" /></div>
    </fieldset>
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('picturepage');"/>
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
</script>