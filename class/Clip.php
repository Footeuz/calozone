<?php

/**
 * Clip : Official clip of the artist
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class Clip extends Root {
    const TBNAME = TABLEPREFIX.'_clip';
    
    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'path' => 'varchar(255) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'artist_id' => 'int(8) NOT NULL DEFAULT 1',
        'disc_id' => 'int(8) NOT NULL DEFAULT 0',
        'description' => 'text NOT NULL',
        'date_parution' => 'int(11) NOT NULL DEFAULT 0',
        'admin_id' => 'int(8) NOT NULL DEFAULT 0',
        'song_id' => 'int(8) NOT NULL DEFAULT 0',
        'active' => 'tinyint(4) NOT NULL DEFAULT 1',
        'thumb' => 'mediumblob',
        'realisateur' => 'varchar(255)',
        'type' => 'enum(\'solo\',\'duo\',\'participation\',\'cover\') DEFAULT \'solo\' ',
        'complement_type' => 'varchar(255)'
    );

    /**
     * clip's Youtube path
     * @var string
     */
    var $path = '';
    /**
     * clip's name
     * @var string
     */
    var $name = '';
    /**
     * clip's description
     * @var string
     */
    var $description = '';

    /**
     * Clip's Music Artist
     * @var int
     */
    var $artist_id = 1;

    /**
     * Clip's Music Album
     * @var int
     */
    var $disc_id = 0;

    /**
     * Clip parution's date
     * @var int (timestamp)
     */
    var $date_parution = 0;

    /**
     * Admin's id who add this clip
     * @var int
     */
    var $admin_id = 0;

    /**
     * Song's id for this clip
     * @var int
     */
    var $song_id = 0;

    /**
     * Clip is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Thumb to show for this clip
     * @var string
     */
    var $thumb = '';

    /**
     * Clip's Realisateur
     * @var string
     */
    var $realisateur = '';

    /**
     * Clip's type : solo/duo/participation/cover
     * @var string
     */
    var $type = 'solo';

    /**
     * Who is the duo's artist, or more informations
     * @var string
     */
    var $complement_type = '';

    /**
     * Get the name of one instance
     * @param int $id
     */
    static function getName($id){
        $obj = new Clip($id);
        return $obj->name;
    }

    /**
     * Get the name of the artist
     * @param int $id
     */
    static function getArtist($id){
        $obj = new Artist($id);
        return $obj->name;
    }

    /**
     * Get full stack
     * $status string Type of account
     * @param string $order
     * @return \Clip[]
     */
    public static function getStack($order=''){
        $items = [];
        $where = [];
        $artists = Artist::getStack();
        $result = SQL::select(static::TBNAME, $where, [], $order);
        while ($item = $result->fetch_assoc()) {
            $item['artistname'] = $artists[$item['artist_id']]['name'];
            $items[$item['id']] = $item;
        }
        return $items;
    }

    /**
     * Get disc stack
     * $status string Type of account
     * @param int $disc_id
     * @return \Clip[]
     */
    public static function getDiscStack($disc_id=0){
        $items = [];
        $where = [];
        if (($disc_id > 0)) $where = array('disc_id' => $disc_id);
        $artists = Artist::getStack();

        $result = SQL::select(static::TBNAME, $where, [], '');
        while ($item = $result->fetch_assoc()) {
            $item['artistname'] = $artists[$item['artist_id']]['name'];
            $items[$item['id']] = $item;
        }
        return $items;
    }

    /**
     * Get song stack
     * $status string Type of account
     * @param int $song_id
     * @return \Clip[]
     */
    public static function getSongStack($song_id=0){
        $items = [];
        $where = [];
        if (($song_id > 0)) $where = array('song_id' => $song_id);
        $artists = Artist::getStack();

        $result = SQL::select(static::TBNAME, $where, [], '');
        while ($item = $result->fetch_assoc()) {
            $item['artistname'] = $artists[$item['artist_id']]['name'];
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
