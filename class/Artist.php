<?php

/**
 * Artist : Official Artist of the artist
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class Artist extends Root {
    const TBNAME = 'caloz_artist';
    
    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'path' => 'varchar(255)',
        'website' => 'varchar(255)',
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * Artist's name
     * @var string
     */
    var $name = '';
    /**
     * Artist's directory
     * @var string
     */
    var $path = '';
    /**
     * Artist's website
     * @var string
     */
    var $website = '';
    /**
     * Artist is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Get the name of one instance
     * @param int $id
     */
    static function getName($id){
        $obj = new Artist($id);
        return $obj->name;
    }
    /**
     * Get the website of one instance
     * @param int $id
     */
    static function getWebsite($id){
        $obj = new Artist($id);
        return $obj->website;
    }

    /**
     * Get full stack
     * $status string Type of account
     * @return \Artist[]
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
     * Get full stack of songs for this Artist
     * $status string Type of account
     * @return \Song[]
     */
    public function getSongs(){
        $items = array();
        $where = array('artist_id'=>$this->id);
        $result = SQL::select(Song::TBNAME, $where, [], '');
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
