<?php
/**** List of picturefile's ****/
if(!defined('ROOT')) require_once '../../../boot.php';
$class = PictureFile::class;

$result = SQL::select(PictureFile::TBNAME, array(), '*', 'page_id ASC, level ASC, position ASC');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_picturefile" class="mainlist">';
    echo '<tr>';
        echo '<th class="w5">'.$lang->l('id').'</th>';
        echo '<th class="w20">'.$lang->l('picturepagename').'</th>';
        echo '<th class="w5">'.$lang->l('level').'</th>';
        echo '<th class="w5">'.$lang->l('position').'</th>';
        echo '<th class="w10">'.$lang->l('picturename').'</th>';
        echo '<th class="w10">'.$lang->l('pictureurl').'</th>';
        echo '<th class="w10">'.$lang->l('picturealt').'</th>';
        echo '<th></th>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="">';
            echo '<td class="w5">'.$item['id'].'</td>';
            echo '<td class="w20">'.PicturePage::getName($item['page_id']).'</td>';
            echo '<td class="w5">'.$item['level'].'</td>';
            echo '<td class="w5">'.$item['position'].'</td>';
            echo '<td class="w10">'.$item['name'].'</td>';
            echo '<td class="w10">'.$item['alt'].'</td>';
            echo '<td class="w10">'.$item['url'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';

