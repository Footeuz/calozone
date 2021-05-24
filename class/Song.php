<?php

/**
 * Song : Official song of the artist
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class Song extends Root {
    const TBNAME = TABLEPREFIX.'_song';
    const TBLINKNAME = TABLEPREFIX.'_disc_songs';

    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'lyrics' => 'text',
        'is_cover' => 'int(1) NOT NULL DEFAULT 0',
        'cover_artist_id' => 'int(8) NOT NULL DEFAULT 0',
        'artist_id' => 'int(8) NOT NULL DEFAULT 0',
        'slug' => 'varchar(255) NOT NULL',
        'auteur' => 'varchar(255) NOT NULL',
        'compositeur' => 'varchar(255) NOT NULL',
        'details' => 'varchar(255) NOT NULL',
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * song's name
     * @var string
     */
    var $name = '';
    /**
     * song's lyrics
     * @var string
     */
    var $lyrics = '';
    /**
     * song is a cover song of another artist
     * @var integer
     */
    var $is_cover = 0;
    /**
     * song's reference artist id
     * @var integer
     */
    var $cover_artist_id = 0;
    /**
     * song's interpret artist id
     * @var integer
     */
    var $artist_id = 0;
    /**
     * song's slug
     * @var string
     */
    var $slug = '';
    /**
     * song's author
     * @var string
     */
    var $auteur = '';
    /**
     * song's composer
     * @var string
     */
    var $compositeur = '';
    /**
     * song's details
     * @var string
     */
    var $details = '';
    /**
     * Song is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Get the name of one instance
     * @param int $id
     * @return string
     */
    static function getName($id){
        $obj = new Song($id);
        return $obj->name;
    }

    /**
     * Check if song is a cover
     * @param int $id
     * @return string
     */
    static function isCover($id){
        $obj = new Song($id);
        return $obj->is_cover;
    }

    /**
     * Get full stack
     * $status string Type of account
     * @param string $order
     * @return \Song[]
     */
    public static function getStack($order='')
    {
        $items = array();
        $where = [];
        $strorder = ($order != '') ? $order : '';
        $result = SQL::select(static::TBNAME, $where, [], $strorder);
        while ($item = $result->fetch_assoc()) {
            $items[$item['id']] = $item;
        }
        return $items;
    }

    /**
     * Get stack for specific artist
     * $status string Type of account
     * @param string $order
     * @param integer $artid
     * @return \Song[]
     */
    public static function getStackArtist($order='', $artid=ARTISTID_MAIN)
    {
        $items = array();
        $where = array('artist_id'=> $artid);
        $strorder = ($order != '') ? $order : '';
        $result = SQL::select(static::TBNAME, $where, [], $strorder);
        while ($item = $result->fetch_assoc()) {
            $items[] = $item;
        }
        return $items;
    }

    /**
     * Get stack for covers by Calo
     * $status string Type of account
     * @param string $order
     * @return \Song[]
     */
    public static function getStackCover($order='')
    {
        $items = array();
        $where = array('is_cover'=> 1);
        $strorder = ($order != '') ? $order : '';
        $result = SQL::select(static::TBNAME, $where, [], $strorder);
        while ($item = $result->fetch_assoc()) {
            $items[] = $item;
        }
        return $items;
    }

    /**
     * Get stack for covers by Calo
     * $status string Type of account
     * @param string $order
     * @return \Song[]
     */
    public static function getStackCollaboration($order='')
    {
        $items = array();
        $where = array('is_cover'=> 0, 'artist_id' => 'not in ('.ARTISTID_MAIN.', '.ARTISTID_SECOND.', '.ARTISTID_THIRD.')');
        $strorder = ($order != '') ? $order : '';
        $result = SQL::select(static::TBNAME, $where, [], $strorder);
        while ($item = $result->fetch_assoc()) {
            $items[] = $item;
        }
        return $items;
    }

    /**
     * Get stack of composers for this instance
     * @return array(]
     */
    public function getComposers()
    {
        $items = array();
        $where = array('song_id' => $this->id, 'role'=>SongContributor::R_COMPOSER);
        $result = SQL::select(SongContributor::TBNAME, $where, [], '');
        while ($item = $result->fetch_assoc()) {
            $items[$item['contributor_id']] = new Contributor($item['contributor_id']);
        }
        return $items;
    }

    /**
     * Get stack of authors for this instance
     * @return array(]
     */
    public function getAuthors()
    {
        $items = array();
        $where = array('song_id' => $this->id, 'role'=>SongContributor::R_AUTHOR);
        $result = SQL::select(SongContributor::TBNAME, $where, [], '');
        while ($item = $result->fetch_assoc()) {
            $items[$item['contributor_id']] = new Contributor($item['contributor_id']);
        }
        return $items;
    }

    /**
     * Get id of this object
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }
}
