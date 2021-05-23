<?php

/**
 * Disc : Official disc of the artist
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class Disc extends Root {
    const TBNAME = 'caloz_disc';

    const SUPPORT_CD = '1';
    const SUPPORT_SINGLE = '2';
    const SUPPORT_DVD = '3';
    const SUPPORT_VINYLE = '4';

    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'artist' => 'int(8) NOT NULL DEFAULT 0',
        'thumb' => 'mediumblob',
        'cover' => 'mediumblob',
        'date_parution' => 'int(11) NOT NULL DEFAULT 0',
        'description' => 'text',
        'isrc' => 'varchar(50)',
        'lnk_difymusic' => 'varchar(255)',
        'lnk_amazon' => 'varchar(255)',
        'lnk_fnac' => 'varchar(255)',
        'lnk_deezer' => 'varchar(255)',
        'lnk_itunes' => 'varchar(255)',
        'lnk_spotify' => 'varchar(255)',
        'slug' => 'varchar(255)',
        'producer' => 'varchar(255)',
        'type' => 'enum(\'1\', \'2\') NOT NULL DEFAULT \'1\'',
        'is_main' => 'int(1) NOT NULL DEFAULT 1',
        'role1' => 'enum(\'1\',\'2\',\'3\',\'4\')',
        'role2' => 'enum(\'1\',\'2\',\'3\',\'4\')',
        'role3' => 'enum(\'1\',\'2\',\'3\',\'4\')',
        'role4' => 'enum(\'1\',\'2\',\'3\',\'4\')',
        'support' => 'enum(\'1\',\'2\',\'3\')', // 1=Disque ** 2=Single ** 3=DVD/Bluray
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * disc's name
     * @var string
     */
    var $name = '';
    /**
     * disc's artist id
     * @var integer
     */
    var $artist = '';
    /**
     * Thumb to show for this disc 200x200
     * @var string
     */
    var $thumb = '';
    /**
     * Cover image to show for this disc 1000x1000
     * @var string
     */
    var $cover = '';
    /**
     * Disc parution's date
     * @var int (timestamp)
     */
    var $date_parution = 0;
    /**
     * disc's description
     * @var string
     */
    var $description = '';
    /**
     * disc's ISRC code
     * @var string
     */
    var $isrc = '';
    /**
     * disc's amazon link
     * @var string
     */
    var $lnk_amazon = '';
    /**
     * disc's fnac link
     * @var string
     */
    var $lnk_fnac = '';
    /**
     * disc's Difymusic link
     * @var string
     */
    var $lnk_difymusic = '';
    /**
     * disc's itunes link
     * @var string
     */
    var $lnk_itunes = '';
    /**
     * disc's Deezer link
     * @var string
     */
    var $lnk_deezer = '';
    /**
     * disc's Spotify link
     * @var string
     */
    var $lnk_spotify = '';
    /**
     * disc's slug
     * @var string
     */
    var $slug = '';
    /**
     * disc's producer
     * @var string
     */
    var $producer = '';
    /**
     * disc's type (studio or live)
     * @var string
     */
    var $type = '1';
    /**
     * disc's is a main album (full songs from main artist
     * @var integer
     */
    var $is_main = 1;
    /**
     * disc's role1
     * @var enum('1','2','3','4')
     */
    var $role1 = '';
    /**
     * disc's role1
     * @var enum('1','2','3','4')
     */
    var $role2 = '';
    /**
     * disc's role1
     * @var enum('1','2','3','4')
     */
    var $role3 = '';
    /**
     * disc's role1
     * @var enum('1','2','3','4')
     */
    var $role4 = '';
    /**
     * disc's support
     * @var enum('1','2','3','4')
     */
    var $support = '';
    /**
     * Disc is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Get the name of one instance
     * @param int $id
     */
    static function getName($id){
        $obj = new Disc($id);
        return $obj->name;
    }

    /**
     * Get the name of the artist
     * @param int $id
     */
    public function getArtist(){
        $obj = new Artist($this->artist);
        return $obj->name;
    }

    /**
     * Get full stack
     * $status string Type of account
     * @param $support string
     * @param $order string
     * @return \Disc[]
     */
    public static function getStack($support='1', $order=''){
        $items = [];
        $where = ($support!='0') ? array('support'=>$support, 'active'=>1) : array('active'=>1);
        $artists = Artist::getStack();
        $strorder = ($order != '') ? $order.', date_parution DESC' : 'date_parution DESC';
        $result = SQL::select(static::TBNAME, $where, [], $strorder );
        while ($item = $result->fetch_assoc()) {
            $item['artistname'] = $artists[$item['artist']]['name'];
            $items[$item['id']] = $item;
        }
        return $items;
    }


    /**
     * Get full stack of disc with this song
     * $status string Type of account
     * @param int $song_id
     * @return \Clip[]
     */
    public static function getSongStack($song_id=0){
        $items = [];
        $where = [];
        if (($song_id > 0)) $where = array('song_id' => $song_id);

        $result = SQL::select(DiscSong::TBNAME, $where, [], '');
        while ($item = $result->fetch_assoc()) {
            $disc = new Disc($item['disc_id']);
            $disc->version = $item['version'];
            $items[$item['disc_id']] = $disc;
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
