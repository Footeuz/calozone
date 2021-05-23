<?php

/**
 * ClientTheme : theme of the front interface
 *
 * @author Stephanie Michel <stephanie@boreal-business.net>
 */
class ClientTheme extends Root {
    const TBNAME = 'caloz_client_theme';

    static $columns = array(
        'id' => 'int(11) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'url_json' => 'varchar(255) NOT NULL',
        'active' => 'tinyint(4) NOT NULL DEFAULT 1'
    );       

    /**
     * ClientTheme's name
     * @var string
     */
    var $name = '';

    /**
     * ClientTheme's json's url to load
     * @var string
     */
    var $url_json = '';

    /**
     * Get an instance of ClientTheme
     * @param int $id
     * @return \ClientTheme[]
     */
    public function get($id = 0)
    {
        $items = array();
        $result = SQL::select(self::TBNAME, array('id' => intval($id)), [], 'id');
        while ($item = $result->fetch_assoc()) {
            $items = $item;
        }
        return $items;
    }
}
