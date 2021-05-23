<?php

/**
 * Podcast : Audio with a podcast
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class Podcast extends Root {
    const TBNAME = TABLEPREFIX.'_podcast';
    
    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'path' => 'varchar(255) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'description' => 'text NOT NULL',
        'participants' => 'varchar(255) NOT NULL',
        'date_add' => 'int(11) NOT NULL DEFAULT 0',
        'admin_id' => 'int(8) NOT NULL DEFAULT 0',
        'active' => 'tinyint(4) NOT NULL DEFAULT 1',
        'thumb' => 'mediumblob',
        'socialimg' => 'mediumblob',
        'nb_listen' => 'int(8) NOT NULL DEFAULT 0',
        'nb_ended' => 'int(8) NOT NULL DEFAULT 0',
        'nb_download' => 'int(8) NOT NULL DEFAULT 0',
        'duration' => 'varchar(30) NOT NULL',
        'episode' => 'int(8) NOT NULL DEFAULT 0'
    );

    /**
     * podcast's path
     * @var string
     */
    var $path = '';
    /**
     * podcast's name
     * @var string
     */
    var $name = '';
    /**
     * podcast's description
     * @var string
     */
    var $description = '';
    /**
     * Name of podcast's particpants
     * @var string
     */
    var $participants = '';

    /**
     * Podcast's add date
     * @var int (timestamp)
     */
    var $date_add = 0;

    /**
     * Admin's id who add this podcast
     * @var int
     */
    var $admin_id = 0;

    /**
     * Podcast is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Thumb to show for this podcast
     * @var string
     */
    var $thumb = '';

    /**
     * Img for Facebook share
     * @var string
     */
    var $socialimg = '';

    /**
     * Number of time the podcast is listen
     * @var int
     */
    var $nb_listen = 0;

    /**
     * Number of time the podcast is listen fully
     * @var int
     */
    var $nb_ended = 0;

    /**
     * Number of time the podcast is downloaded
     * @var int
     */
    var $nb_download = 0;

    /**
     * Duration text to show for rss
     * @var string
     */
    var $duration = '';

    /**
     * Episode's number
     * @var int
     */
    var $episode = 0;

    /**
     * Get the name of one instance
     * @param int $id
     * @return string
     */
    static function getName($id){
        $obj = new Podcast($id);
        return $obj->name;
    }

    /**
     * Get full stack
     * $active string podcast is active or not
     * @return \Podcast[]
     */
    public static function getStack($active=''){
        $items = array();
        $where = array('active'=>$active);
        $result = SQL::select(static::TBNAME, $where, [], 'date_add DESC');
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

    /**
     * Get episode id of this object
     * @return int
     */
    public function getEpisode(){
        return $this->episode;
    }

    /**
     * Get episode object for episode id
     * @param integer $episode_id
     * @return \Podcast|false
     */
    public static function getEpisodeById($episode_id){
        $where = array('episode'=>$episode_id);
        $result = SQL::select(static::TBNAME, $where, [], '');
        if ($result->num_rows>0) {
            $item = $result->fetch_assoc();
            return new Podcast($item['id']);
        }
        return false;
    }
}
