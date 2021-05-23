<?php
/**** List of traduction ****/
if(!defined('ROOT')) require_once '../../../boot.php';
$class = 'trad';

$result = SQL::select(Lang::STORAGE, array(), '*');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_lang" class="mainlist">';
    echo '<tr>';
        echo '<th class="width: 40px;">'.$lang->l('id').'</th>';
        echo '<th class="w30">'.$lang->l('text').'</th>';
        echo '<th class="w30">'.$lang->l('trad_fr').'</th>';
        echo '<th class="w30">'.$lang->l('trad_en').'</th>';
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
            echo '<td class="w30">'.$item['text'].'</td>';
            echo '<td class="w30">'.$item['fr'].'</td>';
            echo '<td class="w30">'.$item['en'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';