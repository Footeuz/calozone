<?php
/**** List of users's admin ****/
if(!defined('ROOT')) require_once '../../../boot.php';
    $class = Tour::class;

$result = SQL::select(Tour::TBNAME, array('active' => 1), '*');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_tour" class="mainlist">';
    echo '<tr>';
        echo '<th class="width: 40px;">'.$lang->l('id').'</th>';
        echo '<th class="w25">'.$lang->l('name').'</th>';
        echo '<th class="w20">'.$lang->l('artist').'</th>';
        echo '<th class="w15">'.$lang->l('slug').'</th>';
        echo '<th class="w15">'.$lang->l('disc').'</th>';
        echo '<th class="w15">'.$lang->l('img').'</th>';
        echo '<th></th>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="">';
            echo '<td class="">'.$item['id'].'</td>';
            echo '<td class="">'.$item['name'].'</td>';
            echo '<td class="">'.Artist::getName($item['artist_id']).'</td>';
            echo '<td class="">'.$item['slug'].'</td>';
            echo '<td class="">'.Disc::getName($item['disc_id']).'</td>';
            if (!empty($item['img']))
                echo '<td class=""><img src="'.URL.'tourimg-img-'.$item['id'].'.jpg" alt="" height="50" /></td>';
            else
                echo '<td class=""></td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';

$result = SQL::select(Tour::TBNAME, array('active' => 0), '*');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
while($item = $result->fetch_assoc()){
    echo '<table class="mainlist">';
        echo '<tr>';
            echo '<td style="w20">'.$item['name'].'</td>';
            echo '<td style="w20">'.Artist::getName($item['artist_id']).'</td>';
            echo '<td>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');"></a>';
            echo '</td>';
        echo '</tr>';
    echo '</table>';
}
