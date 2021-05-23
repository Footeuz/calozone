<?php

/**
 * Contributor : Users who manage client
 *
 * @author Stephanie Michel <stephanie@calo.zone>
 */

class Contributor extends Root {
    const TBNAME = 'caloz_contributor';

    static $columns = array(
        'id' => 'int(11) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'slug' => 'varchar(255) NOT NULL',
        'active' => 'tinyint(4) NOT NULL DEFAULT 1'
    );

    /**
     * Client's name
     * @var string
     */
    var $name = '';
    /**
     * Client's slug for url
     * @var string
     */
    var $slug = '';
    /**
     * Contributor is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Get the name of one instance
     * @param int $id
     * @return string
     */
    static function getName($id){
        $obj = new Contributor($id);
        return $obj->name;
    }

    /**
     * Get full stack
     * $active integer
     * @return \Contributor[]
     */
    public static function getStack($active = 1)
    {
        $items = array();
        $where = array('active' => $active);
        $result = SQL::select(static::TBNAME, $where, [], 'name ASC');
        while ($item = $result->fetch_assoc()) {
            $items[$item['id']] = $item;
        }
        return $items;
    }

    /**
     * Check if contributor exist
     * $str string
     * @return integer|false
     */
    public static function checkExist($str='')
    {
        $where = array('name' => $str);
        $result = SQL::select(static::TBNAME, $where, [], '');
        if ($result && $result->num_rows == 1) {
            return $result->fetch_assoc()['id'];
        }
        return false;
    }
}
