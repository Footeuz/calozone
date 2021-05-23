<?php
/**
 * PicturePage : Page of pictures
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class PicturePage extends Root {
    const TBNAME = TABLEPREFIX.'_picture_page';

    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'slug' => 'varchar(255) NOT NULL',
        'directory' => 'varchar(255) NOT NULL',
        'credits' => 'varchar(255) NOT NULL',
        'meta_title' => 'varchar(255) NOT NULL',
        'meta_description' => 'varchar(255) NOT NULL',
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * picture's page's name
     * @var string
     */
    var $name = '';
    /**
     * picture's page's path slug
     * @var string
     */
    var $slug = '';
    /**
     * picture's page's directory of files
     * @var string
     */
    var $directory = '';
    /**
     * picture's page's credits
     * @var string
     */
    var $credits = '';
    /**
     * picture's page's meta title
     * @var string
     */
    var $meta_title = '';
    /**
     * picture's page's name
     * @var string
     */
    var $meta_description = '';
    /**
     * picture's page is active or not
     * @var integer
     */
    var $active = 1;

    /**
     * Get the name of one instance
     * @param int $id
     * @return string
     */
    static function getName($id){
        $obj = new PicturePage($id);
        return $obj->name;
    }

    /**
     * Get full stack
     * @param $order string
     * @return \PicturePage[]
     */
    public static function getStack($order=''){
        $items = [];
        $where = array('active'=>1);
        $result = SQL::select(static::TBNAME, $where, [], $order);
        while ($item = $result->fetch_assoc()) {
            $items[$item['id']] = $item;
        }
        return $items;
    }
}
