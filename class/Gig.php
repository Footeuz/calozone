<?php

/**
 * Gig : Gig of an artist
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class Gig extends Root {
    const TBNAME = 'caloz_gig';
    
    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'artist_id' => 'int(8) NOT NULL DEFAULT 0',
        'tour_id' => 'int(8) NOT NULL DEFAULT 0',
        'salle_id' => 'int(8) NOT NULL DEFAULT 0',
        'date_start' => 'int (11)',
        'more_infos' => 'varchar(255)',
        'is_cp' => 'int(1) NOT NULL DEFAULT 0',
        'radio' => 'varchar(255)',
        'media_id' => 'int(8) NOT NULL DEFAULT 0',
        'canceled' => 'int(1) NOT NULL DEFAULT 0',
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * Gig's artist
     * @var integer
     */
    var $artist_id = 0;
    /**
     * Gig's tour reference
     * @var int
     */
    var $tour_id = 0;
    /**
     * Gig's salle reference
     * @var int
     */
    var $salle_id = 0;
    /**
     * Gig's date in timestamp
     * @var int
     */
    var $date_start = '';
    /**
     * gig's more infos (1ere partie)
     * @var string
     */
    var $more_infos = '';
    /**
     * Gig's is a concert prive
     * @var int
     */
    var $is_cp = 0;
    /**
     * gig's radio if it's a private gig
     * @var string
     */
    var $radio = '';
    /**
     * Gig's tour media link
     * @var int
     */
    var $media_id = 0;
    /**
     * Gig's is a canceled concert
     * @var int
     */
    var $canceled = 0;
    /**
     * Gig is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Get full stack
     * $status string Type of account
     * @return \Gig[]
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
     * Get stack for one Tour
     * $status string Type of account
     * @param $tour_id integer
     * @return \Gig[]
     */
    public static function getTourStack($tour_id = 0){
        $items = array();
        $where = ($tour_id>0) ? array('tour_id'=>$tour_id, 'active'=>1) : array('active'=>1);
        $result = SQL::select(static::TBNAME, $where, [], 'date_start ASC');
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
