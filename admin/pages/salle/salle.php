<?php
/**** List of users's admin ****/
if(!defined('ROOT')) require_once '../../../boot.php';
    $class = Salle::class;

$result = Salle::getStack();
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_artist" class="mainlist">';
    echo '<tr>';
        echo '<th class="width: 40px;">'.$lang->l('id').'</th>';
        echo '<th class="w30">'.$lang->l('name').'</th>';
        echo '<th class="w15">'.$lang->l('city').'</th>';
        echo '<th class="w15">'.$lang->l('dpt').'</th>';
        echo '<th class="w5">'.$lang->l('country').'</th>';
        echo '<th class="w5">'.$lang->l('mail').'</th>';
        echo '<th class="w20">'.$lang->l('website').'</th>';
        echo '<th></th>';
    echo '</tr>';
    echo '<tr>';
        echo '<td class="width: 40px;"></td>';
        echo '<td class="w30"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="w5"></td>';
        echo '<td class="w5"></td>';
        echo '<td class="w30"></td>';
        echo '<td></td>';
    echo '</tr>';
    if (!empty($result)) {
        foreach ($result as $item) {
            echo '<tr class="">';
            echo '<td class="w5">' . $item['id'] . '</td>';
            echo '<td class="w30">' . $item['name'] . '</td>';
            echo '<td class="w15">' . $item['city'] . '</td>';
            echo '<td class="w15">' . $item['dpt'] . '</td>';
            echo '<td class="w5">' . $item['country'] . '</td>';
            echo '<td class="w5">' . $item['mail'] . '</td>';
            echo '<td class="w30">' . $item['website'] . '</td>';
            echo '<td>';
            echo '<a class="icon_btn delete_btn" href="javascript:askDel(\'' . strtolower($class) . '\', ' . $item['id'] . ', \'' . str_replace("'", "\'", $item['id']) . '\');" title="' . $lang->l('action_delete') . '"></a>';
            echo '<a class="icon_btn create_btn" href="javascript:edit(\'' . strtolower($class) . '\', ' . $item['id'] . ');" title="' . $lang->l('action_edit') . '"></a>';
            echo '</td>';
            echo '</tr>';
        }
    }
echo '</table>';

$result = SQL::select(Salle::TBNAME, array('active' => 0), '*');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
while($item = $result->fetch_assoc()){
    echo '<table class="mainlist">';
        echo '<tr>';
            echo '<td style="w20">'.$item['name'].'</td>';
            echo '<td style="w20">'.$item['city'].'</td>';
            echo '<td style="w20">'.$item['website'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');"></a>';
            echo '</td>';
        echo '</tr>';
    echo '</table>';
}
