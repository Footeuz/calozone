<?php
/**** List of users's admin ****/
if(!defined('ROOT')) require_once '../../../boot.php';
$class = Podcast::class;

$result = SQL::select(Podcast::TBNAME, array('active' => 1), '*', 'id DESC');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_podcast" class="mainlist">';
    echo '<tr>';
        echo '<th class="width: 40px;">'.$lang->l('episode').'</th>';
        echo '<th class="w15">'.$lang->l('name').'</th>';
        echo '<th class="w10">'.$lang->l('description').'</th>';
        echo '<th class="w10">'.$lang->l('thumb').'</th>';
        echo '<th class="w10">'.$lang->l('socialimg').'</th>';
        echo '<th class="w10">'.$lang->l('path').'</th>';
        echo '<th class="w5">'.$lang->l('stat_listen').'</th>';
        echo '<th class="w5">'.$lang->l('stat_ended').'</th>';
        echo '<th class="w5">'.$lang->l('stat_download').'</th>';
        echo '<th class="w10">'.$lang->l('added_by').'</th>';
        echo '<th class="w10">'.$lang->l('date_add').'</th>';
        echo '<th></th>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="">';
            echo '<td>'.$item['episode'].'</td>';
            echo '<td>'.$item['name'].'</td>';
            echo '<td>'.substr($item['description'],0,40).'...</td>';
            echo '<td><img src="'.URL.'utils/get_img.php?type='.strtolower($class).'&id='.$item['id'].'" alt="" height="50" /></td>';
            echo '<td><img src="'.URL.'utils/get_img.php?type=social'.strtolower($class).'&id='.$item['id'].'" alt="" height="50" /></td>';
            echo '<td>'; if (!empty($item['path'])) { echo '<audio controls><source src="'.URL.$item['path'].'" type="audio/mpeg">Your browser does not support the audio element.</audio>'; } echo '</td>';
            echo '<td>'.$item['nb_listen'].'</td>';
            echo '<td>'.$item['nb_ended'].'</td>';
            echo '<td>'.$item['nb_download'].'</td>';
            echo '<td>'.UserAdmin::getName($item['admin_id']).'</td>';
            echo '<td>'.date('d.m.Y H:i', $item['date_add']).'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';

        if (!empty($item['path'])) {
            echo '<tr>';
                echo '<td class="" colspan="4">Page : <a href="'.URL.'podcast-details-'.$item['episode'].'" target="_blank">'.URL.'podcast-details-'.$item['episode'].'</a></td>';
                echo '<td class="" colspan="7">Lien direct (à ne pas utiliser) : '; echo '<a href="'.URL.$item['path'].'" target="_blank">'.URL.$item['path'].'</a>'; echo '</td>';
            echo '</tr>';
        }
    }
echo '</table>';

$deleted = Podcast::getStack('0');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
if (!empty($deleted)){
    echo '<table class="mainlist">';
    foreach($deleted as $item_id => $itemdeleted) {
        echo '<tr>';
            echo '<td style="width: 20%;">' . $itemdeleted['id'] . '</td>';
            echo '<td style="width: 20%;">' . $itemdeleted['name'] . '</td>';
            echo '<td><a class="icon_btn create_btn" href="javascript:edit(\'' . strtolower($class) . '\', ' . $itemdeleted['id'] . ');"></a></td>';
        echo '</tr>';
    }
    echo '</table>';
}
