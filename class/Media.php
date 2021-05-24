<?php

/**
 * Media : Official Media of the Media
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class Media extends Root {
    const TBNAME = 'archiv_medias';
    
    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'artist' => 'int(8) NOT NULL DEFAULT 0',
        'title' => 'varchar(255) NOT NULL',
        'description' => 'text',
        'media' => 'varchar(255)',
        'path' => 'varchar(255)',
        'lancement' => 'int(8) NOT NULL DEFAULT 0',
        'vues' => 'int(8) NOT NULL DEFAULT 0',
        'datediff' => 'date',
        'heurediff' => 'varchar(100)',
        'type' => '	enum(\'1\', \'2\')', // 1=video / 2=audio
        'duree' => 'int(8) NOT NULL DEFAULT 0',
        'albumid' => 'int(8) NOT NULL DEFAULT 0',
        'stampadd' => 'timestamp',
        'category' => 'enum(\'Collaboration\', \'Autre\') NOT NULL DEFAULT \'Autre\'',
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * Media's artist associated
     * @var int
     */
    var $artist = 0;
    /**
     * Media's title
     * @var string
     */
    var $title = '';
    /**
     * Media's description
     * @var string
     */
    var $description = '';
    /**
     * Media's media
     * @var string
     */
    var $media = '';
    /**
     * Media's directory
     * @var string
     */
    var $path = '';
    /**
     * Media's number of time views
     * @var int
     */
    var $lancement = 0;
    /**
     * Media's number of full time views
     * @var int
     */
    var $vues = 0;
    /**
     * Media's diffusion's date
     * @var string
     */
    var $datediff = '';
    /**
     * Media's diffusion's hour
     * @var string
     */
    var $heurediff = '';
    /**
     * Media's diffusion's hour
     * @var enum(\'1\', \'2\') 1=video / 2=audio
     */
    var $type = '1';
    /**
     * Media's duration
     * @var int
     */
    var $duree = 0;
    /**
     * Media's album id
     * @var int
     */
    var $albumid = 0;
    /**
     * Media's date's add
     * @var string
     */
    var $stampadd = '';
    /**
     * Media's xategory
     * @var enum('Collaboration', 'Autre'
     */
    var $category = 'Autre';
    /**
     * Media is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Get the title of one instance
     * @param int $id
     */
    static function getName($id){
        $obj = new Media($id);
        return $obj->title;
    }

    /**
     * Get full stack
     * $status string Type of account
     * @return \Media[]
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
     * Get artist stack
     * $status string Type of account
     * @param int $artist_id
     * @return \Media[]
     */
    public static function getArtistStack($artist_id = 1){
        $items = array();
        $where = array('artist'=>$artist_id);
        $result = SQL::select(static::TBNAME, $where, [], 'datediff DESC');
        while ($item = $result->fetch_assoc()) {
            $items[$item['id']] = $item;
        }
        return $items;
    }

    /**
     * Get stack for one album
     * $status string Type of account
     * @param int $disc_id
     * @param string $type
     * @return \Media[]
     */
    public static function getDiscStack($disc_id=0, $type=''){
        $items = array();
        $where = ['artist'=>ARTISTID_MAIN];
        if ($disc_id > 0) $where['albumid'] = $disc_id;
        if ($type != '') $where['type'] = $type;
        $artists = Artist::getStack();

        $result = SQL::select(static::TBNAME, $where, [], 'datediff ASC');
        if ($result->num_rows>0) {
            while ($item = $result->fetch_assoc()) {
                $item['artistname'] = $artists[$item['artist']]['name'];
                $item['artistpath'] = $artists[$item['artist']]['path'];
                $items[$item['id']] = $item;
            }
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
     * Get url of this object
     * @return string
     */
    public function getUrl(){
        global $list_types_media;
        return 'https://www.archivons.com/'.strtolower($list_types_media[$this->type]).'-'.strtolower(Artist::getName($this->artist)).'-'.$this->id;
    }
}
