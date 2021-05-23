<?php
require '../../../boot.php';

$class = TourSetlist::class;
if(isset($_REQUEST['id'])) $item = new TourSetlist(intval($_REQUEST['id'])); else $item = new TourSetlist();
$resRes = SQL::select(UserAdmin::TBNAME, [], ['id', 'name'], 'name');

if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0){
    $user = new UserAdmin($_SESSION['id_user']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else {
    $user = null;
}

$list_tours = [];
$tours = Tour::getStack(1, '');
if (!empty($tours)) {
    foreach($tours as $tour_id => $tour) {
        $list_tours[$tour_id] = $tour['name'];
    }
}
?>
<form id="toursetlist_edit_form" method="post" action="pages/toursetlist/toursetlistSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?'TourSetlist : '.$item->name:$lang->l('new_tour_setlist')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('name'); ?> </label><input type="text" name="name" class="w50" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('tour'); ?> </label><?= Render::select('tour_id', $list_tours, $item->tour_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('tour_setlist_active'); ?> </label><?= Render::select('active', $ouinon, $item->active) ?></div>

        <div class="clr f2">
            <div><label><?php echo $lang->l('img'); ?></label><input type="file" name="img" /><span><?= $lang->l('img_recommanded_size1000'); ?></span></div>
        </div>
        <div class="f2">
            <?php
            if ($item->img != '') {
                echo '<div class="img_wrapper" id="item_img_'.$item->id.'">';
                echo '<img src="'.URL.'utils/get_img.php?type='.strtolower($class).'&id='.$item->id.'" alt="" height="150" />';
                echo '<br/><a class="icon_btn delete_btn" onclick="javascript:itemDeleteImg('.$item->id.')" ></a> ';
                echo '</div>';
            }
            ?>
        </div>
    </fieldset>

    <input type="hidden" value="0" name="imgs_to_delete" id="imgs_to_delete" />
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('toursetlist');"/>
</form>


<?php
if(isset($item->id) && $item->id >0) {
    // song's list of this tour's setlist
    $songs = TourSetlistSong::getStackTourSetlist($item->id);

    $classq = TourSetlistSong::class;
    echo '<h2>'.$lang->l('list_songs').'</h2>';
    if ($songs && sizeof($songs) > 0) {
        echo '<table id="list_song" class="mainlist content_sortcat">';
            echo '<tr>';
                echo '<th class="w5"></th>';
                echo '<th class="w5">'.$lang->l('track_position').'</th>';
                echo '<th class="w15">'.$lang->l('song').'</th>';
                echo '<th class="w15">'.$lang->l('auteur').'</th>';
                echo '<th class="w15">'.$lang->l('compositeur').'</th>';
                echo '<th></th>';
            echo '</tr>';
        echo '</table>';

        echo '<ul id="sortable-songs" class="sortable list">';
        foreach ($songs as $song_id => $itemq) {
            $songitem = new Song($itemq['song_id']);
            echo '<li id="'.$itemq['id'].'">';
                echo '<table>';
                    echo '<tr class="">';
                        echo '<td class="w5 text-center "><span class="handle">::</span></td>';
                        echo '<td class="w5">'.$itemq['track_position'].'</td>';
                        echo '<td class="w15">'.$songitem->name.'</td>';
                        echo '<td class="w15">'.$songitem->auteur.'</td>';
                        echo '<td class="w15">'.$songitem->compositeur.'</td>';
                        echo '<td>';
                            echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($classq).'\', ' . $itemq['id'] . ', null, '.$item->id.');"></a>';
                            echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($classq).'\', ' . $itemq['id'] . ', \'' . str_replace("'", "\'", Song::getName($itemq['song_id'])) . '\');"></a>';
                        echo '</td>';
                    echo '</tr>';
                echo '</table>';
            echo '</li>';
        }
        echo '</ul>';
    }
    echo '<p><a class="btn withtxt" href="javascript:edit(\''.strtolower($classq).'\', 0, null, '.$item->id.');"><span class="icon_btn add_btn"></span>'.$lang->l('add_song').'</a></p>';
}
?>

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