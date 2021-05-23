<?php
/**** List of song's ****/
if(!defined('ROOT')) require_once '../../../boot.php';
$class = Song::class;

$result = SQL::select(Song::TBNAME, array('active' => 1), '*', 'id ASC');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_song" class="mainlist">';
    echo '<tr>';
        echo '<th class="w5">'.$lang->l('id').'</th>';
        echo '<th class="w20">'.$lang->l('name').'</th>';
        echo '<th class="w10">'.$lang->l('auteur').'</th>';
        echo '<th class="w10">'.$lang->l('compositeur').'</th>';
        echo '<th class="w10">'.$lang->l('is_cover').'</th>';
        echo '<th class="w20">'.$lang->l('covert_artist').'</th>';
        echo '<th class="w20">'.$lang->l('slug').'</th>';
        echo '<th></th>';
    echo '</tr>';
    echo '<tr>';
        echo '<td class="w5"></td>';
        echo '<td class="w20"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w20"></td>';
        echo '<td class="w20"></td>';
        echo '<td></td>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="'.((empty($item['lyrics'])) ? 'todo' : '').'">';
            echo '<td class="w5">'.$item['id'].'</td>';
            echo '<td class="w20">'.$item['name'].'</td>';
            echo '<td class="w10">'.$item['auteur'].'</td>';
            echo '<td class="w10">'.$item['compositeur'].'</td>';
            echo '<td class="w10">'.(($item['is_cover']) ? 'Oui' : 'Non').'</td>';
            echo '<td class="w20">'.Artist::getName($item['cover_artist_id']).'</td>';
            echo '<td class="w20">'.$item['slug'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';

$result = SQL::select(Song::TBNAME, array('active' => 0), '*');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
while($item = $result->fetch_assoc()){
    echo '<table class="mainlist">';
        echo '<tr>';
            echo '<td class="w20">'.$item['name'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');"></a>';
            echo '</td>';
        echo '</tr>';
    echo '</table>';
}

