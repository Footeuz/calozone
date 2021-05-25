<?php

/**
 * Menu : All menus for the front website
 *
 * @author Stephanie Michel <s.michel@animaute.com>
 */
class Menu extends Root {
    const TBNAME = TABLEPREFIX.'_menu';

    static $columns = array(
        'id' => 'int(11) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * menu's name
     * @var string
     */
    var $name = '';

    /**
     * mennu is active or not
     * @var integer
     */
    var $active = 1;

    /**
     * Get the name of one instance
     * @param int $id
     */
    static function getName($id){
        $obj = new Menu($id);
        return $obj->name;
    }

    /**
     * Get full stack
     * @return \Menu[]
     */
    public static function getStack()
    {
        $items = array();
        $where = array('active'=>1);
        $result = SQL::select(self::TBNAME, $where, [], '');
        if ($result) {
            while ($item = $result->fetch_assoc()) {
                $items[$item['id']]['data'] = $item;
                $items[$item['id']]['links'] = MenuItem::getStackMenu($item['id']);
            }
        }
        return $items;
    }
}
