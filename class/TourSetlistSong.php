<?php

/**
 * TourSetlistSong : Official song of a typycal tour's setlist
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class TourSetlistSong extends Root {
    const TBNAME = 'caloz_tour_setlist_songs';

    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'tour_setlist_id' => 'int(1) NOT NULL DEFAULT 0',
        'song_id' => 'int(8) NOT NULL DEFAULT 0',
        'track_position' => 'int(8) NOT NULL DEFAULT 0',
        'more_infos' => 'varchar(255)'
    );

    /**
     * tour's setlist for this song
     * @var integer
     */
    var $tour_setlist_id = 0;
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
     * song's more informations
     * @var string
     */
    var $more_infos = '';

    /**
     * Get stack of Disc for one Test
     * @param int $id
     * @param boolean $all
     * @return \TourSetlist[]
     */
    public static function getStackTourSetlist($id = 0, $all = true)
    {
        $items = array();

        $req = "SELECT * FROM ".self::TBNAME." WHERE tour_setlist_id = ".intval($id)." ORDER BY track_position ASC";
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
