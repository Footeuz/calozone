<?php
/**
 * PictureFile : File for a picture's file
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class PictureFile extends Root {
    const TBNAME = TABLEPREFIX.'_picture_file';

    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'page_id' => 'int(8) NOT NULL DEFAULT 0',
        'name' => 'varchar(255) NOT NULL',
        'url' => 'varchar(255) NOT NULL',
        'alt' => 'varchar(255) NOT NULL',
        'level' => 'int(8)',
        'position' => 'int(8)'
    );

    /**
     * picture's file's page reference
     * @var string
     */
    var $page_id = 0;
    /**
     * picture's file's name
     * @var string
     */
    var $name = '';
    /**
     * picture's file's url
     * @var string
     */
    var $url = '';
    /**
     * picture's file's alt
     * @var string
     */
    var $alt = '';
    /**
     * picture's file's level
     * @var integer
     */
    var $level = 0;
    /**
     * picture's file's position in level in page
     * @var integer
     */
    var $position = 0;

    /**
     * Get the name of one instance
     * @param int $id
     * @return string
     */
    static function getName($id){
        $obj = new PictureFile($id);
        return $obj->name;
    }

    /**
     * Get full stack
     * @param $page_id integer
     * @param $order string
     * @return \PictureFile[]
     */
    public static function getStack($page_id=0, $order=''){
        $items = [];
        $where = array('page_id'=>$page_id);
        $result = SQL::select(static::TBNAME, $where, [], $order);
        if ($result && $result->num_rows>0) {
            while ($item = $result->fetch_assoc()) {
                $items[$item['level']][$item['position']]['id'] = $item['id'];
                $items[$item['level']][$item['position']]['name'] = $item['name'];
                $items[$item['level']][$item['position']]['url'] = $item['url'];
                $items[$item['level']][$item['position']]['alt'] = $item['alt'];
            }
        }
        return $items;
    }
}
