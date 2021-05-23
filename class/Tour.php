<?php

/**
 * Tour : Tour of an artist
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class Tour extends Root {
    const TBNAME = 'caloz_tour';
    
    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'artist_id' => 'int(8) NOT NULL DEFAULT 0',
        'slug' => 'varchar(255)',
        'disc_id' => 'int(8) NOT NULL DEFAULT 0',
        'more_infos' => 'text',
        'img' => 'mediumblob',
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * Tour's name
     * @var string
     */
    var $name = '';
    /**
     * Tour's artist
     * @var integer
     */
    var $artist_id = 0;
    /**
     * Tour's slug path
     * @var string
     */
    var $slug = '';
    /**
     * Tour's associated disc
     * @var integer
     */
    var $disc_id = 0;
    /**
     * Tour's more infos (picture)
     * @var integer
     */
    var $more_infos = '';
    /**
     * Tour's picture
     * @var string mediumblob
     */
    var $img = '';
    /**
     * Tour is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Get the name of one instance
     * @param int $id
     * @return string
     */
    static function getName($id){
        $obj = new Tour($id);
        return $obj->name;
    }

    /**
     * Get full stack
     * $status string Type of account
     * @return \Tour[]
     */
    public static function getStack(){
        $items = array();
        $where = array();
        $result = SQL::select(static::TBNAME, $where, [], '');
        while ($item = $result->fetch_assoc()) {
            $items[$item['id']] = $item;
        }
        return $items;
    }

    /**
     * Get full stack of concerts for this Tour
     * $status string Type of account
     * @param int $tour_id
     * @return \Gig[]
     */
    public function getGigs($tour_id = 0){
        $items = array();
        $where = array('tour_id'=>$tour_id);
        $result = SQL::select(Gig::TBNAME, $where, [], '');
        while ($item = $result->fetch_assoc()) {
            $items[] = $item;
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
