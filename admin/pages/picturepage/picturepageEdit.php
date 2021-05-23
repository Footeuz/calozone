<?php
require '../../../boot.php';

$class = PicturePage::class;
if(isset($_REQUEST['id'])) $item = new PicturePage(intval($_REQUEST['id']));
else $item = new PicturePage();
?>
<form id="picturepage_edit_form" method="post" action="pages/picturepage/picturepageSave.php">
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?'PicturePage : '.$item->name:$lang->l('new_picturepage')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('name'); ?> </label><input type="text" name="name" class="w50" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('picturepage_slug'); ?> </label><input type="text" name="slug" class="w50" value="<?= htmlentities($item->slug) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('picturepage_directory'); ?> </label><input type="text" name="directory" class="w50" value="<?= htmlentities($item->directory) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('picturepage_credits'); ?> </label><input type="text" name="credits" class="w50" value="<?= htmlentities($item->credits) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('picturepage_meta_title'); ?> </label><input type="text" name="meta_title" class="w50" value="<?= htmlentities($item->meta_title) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('picturepage_meta_description'); ?> </label><input type="text" name="meta_description" class="w50" value="<?= htmlentities($item->meta_description) ?>" /></div>
        <div class="f2 clr"><label><?php echo $lang->l('picturepage_active'); ?> </label><?= Render::select('active', $ouinon, $item->active) ?></div>
    </fieldset>
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('picturepage');"/>
</form>

<?php
if(isset($item->id) && $item->id >0) {
    // picture file's list of this picturepage
    $pictures = PictureFile::getStack($item->id);

    $classq = PictureFile::class;
    echo '<h2>'.$lang->l('list_pictures').'</h2>';
    if ($pictures && sizeof($pictures) > 0) {
        echo '<table id="list_pictures" class="mainlist content_sortcat">';
            echo '<tr>';
                echo '<th class="w5"></th>';
                echo '<th class="w5">'.$lang->l('level').'</th>';
                echo '<th class="w5">'.$lang->l('position').'</th>';
                echo '<th class="w15">'.$lang->l('name').'</th>';
                echo '<th class="w15">'.$lang->l('url').'</th>';
                echo '<th class="w15">'.$lang->l('alt').'</th>';
                echo '<th></th>';
            echo '</tr>';
        echo '</table>';

        echo '<ul id="sortable-pictures" class="sortable list">';
        foreach ($pictures as $level => $tab_tmp) {
            foreach ($tab_tmp as $position => $itemq) {
                echo '<li>';
                    echo '<table>';
                        echo '<tr class="">';
                            echo '<td class="w5 text-center "><span class="handle">::</span></td>';
                            echo '<td class="w5">' . $level . '</td>';
                            echo '<td class="w5">' . $position . '</td>';
                            echo '<td class="w15">' . $itemq['name'] . '</td>';
                            echo '<td class="w15">' . $itemq['url'] . '</td>';
                            echo '<td class="w15">' . $itemq['alt'] . '</td>';
                            echo '<td>';
                                echo '<a class="icon_btn create_btn" href="javascript:edit(\'' . strtolower($classq) . '\', ' . $itemq['id'] . ', null, ' . $item->id . ');"></a>';
                                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\'' . strtolower($classq) . '\', ' . $itemq['id'] . ', \'' . str_replace("'", "\'", $itemq['name']) . '\');"></a>';
                            echo '</td>';
                        echo '</tr>';
                    echo '</table>';
                echo '</li>';
            }
        }
        echo '</ul>';
    }
    echo '<p><a class="btn withtxt" href="javascript:edit(\''.strtolower($classq).'\', 0, null, '.$item->id.');"><span class="icon_btn add_btn"></span>'.$lang->l('add_picture').'</a></p>';
}
?>

<script>
    inittiny();

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

    /**** Date picker ****/
    var fieldstart = document.getElementById('datepickerdateparution');
    var pickerstart = new Pikaday({
        field: document.getElementById('datepickerdateparution'),
        onSelect: function(date) {
            fieldstart.value = pickerstart.getDateFormatted();
        },
        showDaysInNextAndPreviousMonths:true
    });
    /**** End Date picker ****/
</script>