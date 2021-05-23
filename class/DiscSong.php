<?php

/**
 * DiscSong : Official song of a disc
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class DiscSong extends Root {
    const TBNAME = TABLEPREFIX.'_disc_songs';

    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'disc_id' => 'int(1) NOT NULL DEFAULT 0',
        'song_id' => 'int(8) NOT NULL DEFAULT 0',
        'track_position' => 'int(8) NOT NULL DEFAULT 0',
        'disk_number' => 'varchar(4) NOT NULL DEFAULT \'1\'',
        'face' => 'varchar(4)',
        'version' => 'varchar(255)'
    );

    /**
     * disc for this song
     * @var integer
     */
    var $disc_id = 0;
    /**
     * song for this disc
     * @var integer
     */
    var $song_id = 0;
    /**
     * song's position on disc
     * @var integer
     */
    var $track_position = 0;
    /**
     * song's disc where is the song
     * @var string
     */
    var $disk_number = 1;
    /**
     * song's face of the disc
     * @var string
     */
    var $face = '';
    /**
     * song's version on this disc
     * @var string
     */
    var $version = '';

    /**
     * Get stack of Disc for one Test
     * @param int $id
     * @param boolean $all
     * @return \Disc[]
     */
    public static function getStackDisc($id = 0, $all = true)
    {
        $items = array();

        $req = "SELECT * FROM ".self::TBNAME." WHERE disc_id = ".intval($id)." ORDER BY disk_number ASC, track_position ASC";
        $result = SQL::query($req);

        while ($item = $result->fetch_assoc()) {
            $items[] = $item;
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
