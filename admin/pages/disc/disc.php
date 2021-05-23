<?php
/**** List of disc's ****/
if(!defined('ROOT')) require_once '../../../boot.php';
$class = Disc::class;

$result = SQL::select(Disc::TBNAME, array('active' => 1), '*', 'support ASC, is_main DESC, date_parution DESC');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_disc" class="mainlist">';
    echo '<tr>';
        echo '<th class="w5">'.$lang->l('id').'</th>';
        echo '<th class="w15">'.$lang->l('name').'</th>';
        echo '<th class="w15">'.$lang->l('artist').'</th>';
        echo '<th class="w10">'.$lang->l('support').'</th>';
        echo '<th class="w10">'.$lang->l('thumb').'</th>';
        echo '<th class="w10">'.$lang->l('date_parution').'</th>';
        echo '<th class="w20">'.$lang->l('description').'</th>';
        echo '<th class="w15">'.$lang->l('slug').'</th>';
        echo '<th></th>';
    echo '</tr>';
    echo '<tr>';
        echo '<td class="w5"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="10">';
            echo '<select id="supportfilter" name="support" onchange="filtertable(\'full_list_disc\', \'supportfilter\', \'support\');">';
                echo '<option value="all" selected>'.$lang->l('all discs').'</option>';
                foreach($list_supports as $id_support => $name_support)
                echo '<option value="'.$id_support.'">'.$name_support.'</option>';
            echo '</select>';
        echo '</td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w20"></td>';
        echo '<td class="w15"></td>';
        echo '<td></td>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="support'.$item['support'].'">';
            echo '<td class="w5">'.$item['id'].'</td>';
            echo '<td class="w15">'.$item['name'].'</td>';
            echo '<td class="w15">'.Artist::getName($item['artist']).'</td>';
            echo '<td class="w10">'.$list_supports[$item['support']].'</td>';
            echo '<td class="w10"><img src="'.URL.'disc-thumb-'.$item['slug'].'-'.$item['id'].'.jpg" alt="" height="50" /></td>';
            echo '<td class="w10">'.date('d.m.Y', $item['date_parution']).'</td>';
            echo '<td class="w20">'.substr(strip_tags($item['description']),0,60).'...</td>';
            echo '<td class="w15">'.$item['slug'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';

$result = SQL::select(Disc::TBNAME, array('active' => 0), '*');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
while($item = $result->fetch_assoc()){
    echo '<table class="mainlist">';
        echo '<tr>';
            echo '<td style="width: 20%;">'.$item['name'].'</td>';
            echo '<td style="width: 20%;">'.$item['artist'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');"></a>';
            echo '</td>';
        echo '</tr>';
    echo '</table>';
}

