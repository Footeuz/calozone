<?php
/**** List of users's admin ****/
if(!defined('ROOT')) require_once '../../../boot.php';
$class = Clip::class;

$result = SQL::select(Clip::TBNAME, array('active' => 1), '*', 'date_parution ASC');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_clip" class="mainlist">';
    echo '<tr>';
        echo '<th class="width: 30px;">'.$lang->l('id').'</th>';
        echo '<th class="w10">'.$lang->l('date_parution').'</th>';
        echo '<th class="w15">'.$lang->l('name').'</th>';
        echo '<th class="w10">'.$lang->l('type_clip').'</th>';
        echo '<th class="w10">'.$lang->l('artist').'</th>';
        echo '<th class="w10">'.$lang->l('disc').'</th>';
        echo '<th class="w10">'.$lang->l('realisateur').'</th>';
        echo '<th class="w15">'.$lang->l('description').'</th>';
        echo '<th class="w10">'.$lang->l('thumb').'</th>';
        echo '<th class="w5">'.$lang->l('song').'</th>';
        echo '<th class="w5">'.$lang->l('path').'</th>';
        echo '<th class="w10">'.$lang->l('added_by').'</th>';
        echo '<th></th>';
    echo '</tr>';
    echo '<tr>';
        echo '<td class="width: 40px;"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w5"></td>';
        echo '<td class="w5"></td>';
        echo '<td class="w10"></td>';
        echo '<td></td>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="">';
            echo '<td class="w5">'.$item['id'].'</td>';
            echo '<td class="w10">'.date('d.m.Y', $item['date_parution']).'</td>';
            echo '<td class="w15">'.$item['name'].'</td>';
            echo '<td class="w10">'.$item['type'].'</td>';
            echo '<td class="w10">'.Artist::getName($item['artist_id']).'</td>';
            echo '<td class="w10">'.Disc::getName($item['disc_id']).'</td>';
            echo '<td class="w10">'.$item['realisateur'].'</td>';
            echo '<td class="w15">'.substr(strip_tags($item['description']),0,60).'...</td>';
            echo '<td class="w10"><img src="'.URL.'utils/get_img.php?type='.strtolower($class).'&id='.$item['id'].'" alt="" height="50" /></td>';
            echo '<td class="w5">'.(($item['song_id']>0) ? Song::getName($item['song_id']) :'').'</td>';
            echo '<td class="w5">'; if (!empty($item['path'])) { echo $item['path']; } echo '</td>';
            echo '<td class="w10">'.UserAdmin::getName($item['admin_id']).'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';

$result = SQL::select(Clip::TBNAME, array('active' => 0), '*');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
while($item = $result->fetch_assoc()){
    echo '<table class="mainlist">';
        echo '<tr>';
            echo '<td style="width: 20%;">'.$item['name'].'</td>';
            echo '<td style="width: 20%;">'.$item['path'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');"></a>';
            echo '</td>';
        echo '</tr>';
    echo '</table>';
}

