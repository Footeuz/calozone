<?php
/**** List of picturepage's ****/
if(!defined('ROOT')) require_once '../../../boot.php';
$class = PicturePage::class;

$result = SQL::select(PicturePage::TBNAME, array('active' => 1), '*', '');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_picturepage" class="mainlist">';
    echo '<tr>';
        echo '<th class="w5">'.$lang->l('id').'</th>';
        echo '<th class="w15">'.$lang->l('name').'</th>';
        echo '<th class="w15">'.$lang->l('directory').'</th>';
        echo '<th class="w20">'.$lang->l('credits').'</th>';
        echo '<th class="w10">'.$lang->l('meta_title').'</th>';
        echo '<th class="w20">'.$lang->l('meta_description').'</th>';
        echo '<th class="w15">'.$lang->l('slug').'</th>';
        echo '<th></th>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="">';
            echo '<td class="w5">'.$item['id'].'</td>';
            echo '<td class="w15">'.$item['name'].'</td>';
            echo '<td class="w15">'.$item['directory'].'</td>';
            echo '<td class="w20">'.$item['credits'].'</td>';
            echo '<td class="w10">'.$item['meta_title'].'</td>';
            echo '<td class="w20">'.$item['meta_description'].'</td>';
            echo '<td class="w15">'.$item['slug'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';

$result = SQL::select(PicturePage::TBNAME, array('active' => 0), '*');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
while($item = $result->fetch_assoc()){
    echo '<table class="mainlist">';
        echo '<tr>';
            echo '<td style="width: 20%;">'.$item['name'].'</td>';
            echo '<td style="width: 20%;">'.$item['credits'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');"></a>';
            echo '</td>';
        echo '</tr>';
    echo '</table>';
}

