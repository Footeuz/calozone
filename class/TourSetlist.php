<?php

/**
 * TourSetlist : Typycal Setlist of a tour
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class TourSetlist extends Root {
    const TBNAME = 'caloz_tour_setlist';
    
    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'tour_id' => 'int(8) NOT NULL DEFAULT 0',
        'img' => 'mediumblob',
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * TourSetlist's name
     * @var string
     */
    var $name = '';
    /**
     * TourSetlist's artist
     * @var integer
     */
    var $tour_id = 0;
    /**
     * TourSetlist's image
     * @var integer
     */
    var $img = '';
    /**
     * TourSetlist is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Get the name of one instance
     * @param int $id
     * @return string
     */
    static function getName($id){
        $obj = new TourSetlist($id);
        return $obj->name;
    }

    /**
     * Get full stack
     * $status string Type of account
     * @return \TourSetlist[]
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
     * Get stack ofr a tour
     * $status string Type of account
     * @param integer $tour_id 
     * @return \TourSetlist[]
     */
    public static function getStackByTour($tour_id=0){
        $items = array();
        $where = ($tour_id>0)?array('tour_id'=>$tour_id):array();
        $result = SQL::select(static::TBNAME, $where, [], '');
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
