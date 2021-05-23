<?php
/**** List of artists****/
if(!defined('ROOT')) require_once '../../../boot.php';
    $class = Artist::class;

$result = SQL::select(Artist::TBNAME, array('active' => 1), '*');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_artist" class="mainlist">';
    echo '<tr>';
        echo '<th class="width: 40px;">'.$lang->l('id').'</th>';
        echo '<th class="w30">'.$lang->l('name').'</th>';
        echo '<th class="w30">'.$lang->l('path').'</th>';
        echo '<th class="w30">'.$lang->l('website').'</th>';
        echo '<th></th>';
    echo '</tr>';
    echo '<tr>';
        echo '<td class="width: 40px;"></td>';
        echo '<td class="w30"></td>';
        echo '<td class="w30"></td>';
        echo '<td class="w30"></td>';
        echo '<td></td>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="">';
            echo '<td class="w5">'.$item['id'].'</td>';
            echo '<td class="w30">'.$item['name'].'</td>';
            echo '<td class="w30">'.$item['path'].'</td>';
            echo '<td class="w30">'.$item['website'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';

$result = SQL::select(Artist::TBNAME, array('active' => 0), '*');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
while($item = $result->fetch_assoc()){
    echo '<table class="mainlist">';
        echo '<tr>';
            echo '<td style="w20">'.$item['name'].'</td>';
            echo '<td style="w20">'.$item['path'].'</td>';
            echo '<td style="w20">'.$item['website'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');"></a>';
            echo '</td>';
        echo '</tr>';
    echo '</table>';
}
