<?php
/**** List of song's ****/
if(!defined('ROOT')) require_once '../../../boot.php';
$class = TourSetlistSong::class;

$result = SQL::select(TourSetlistSong::TBNAME, array(), '*', 'id ASC');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_song" class="mainlist">';
    echo '<tr>';
        echo '<th class="w5">'.$lang->l('id').'</th>';
        echo '<th class="w20">'.$lang->l('tour_setlist').'</th>';
        echo '<th class="w10">'.$lang->l('song').'</th>';
        echo '<th class="w10">'.$lang->l('track_position').'</th>';
        echo '<th></th>';
    echo '</tr>';
    echo '<tr>';
        echo '<td class="w5"></td>';
        echo '<td class="w20"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td></td>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="">';
            echo '<td class="w5">'.$item['id'].'</td>';
            echo '<td class="w20">'.TourSetlist::getName($item['tour_setlist_id']).'</td>';
            echo '<td class="w10">'.Song::getName($item['song_id']).'</td>';
            echo '<td class="w10">'.$item['track_position'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';

