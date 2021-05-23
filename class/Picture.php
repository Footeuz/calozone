<?php

/**
 * Picture : Official picture of the artist
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class Picture extends Root {
    const TBNAME = 'caloz_picture';
    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'data' => 'mediumblob',
        'alt' => 'varchar(255) NOT NULL',
        'type' => 'enum(\'1\', \'2\', \'3\', \'4\') NOT NULL DEFAULT \'1\'', // 1=billet ** 2=affiche ** 3=flyer ** 4=live
        'gig_id' => 'int(1) NOT NULL DEFAULT 0',
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * Data of the picture
     * @var string
     */
    var $data = '';
    /**
     * picture's alt
     * @var string
     */
    var $alt = '';
    /**
     * picture's type
     * @var enum('1','2','3','4')
     */
    var $type = '';
    /**
     * picture's is associated with a gig
     * @var integer
     */
    var $gig_id = 0;
    /**
     * Picture is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Get the alt of one instance
     * @param int $id
     */
    static function getAlt($id){
        $obj = new Picture($id);
        return $obj->alt;
    }

    /**
     * Get full stack
     * $status string Type of account
     * @param $type string
     * @param $order string
     * @return \Picture[]
     */
    public static function getStack($type='', $order=''){
        $items = [];
        $where = ($type!='') ? array('type'=>$type, 'active'=>1) : array('active'=>1);
        $result = SQL::select(static::TBNAME, $where, [], $order );
        while ($item = $result->fetch_assoc()) {
            $items[$item['id']] = $item;
        }
        return $items;
    }

    /**
     * Get id of this object
     * @return int
     */
    public function getID(){
        return $this->id;
    }
}
