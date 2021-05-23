<?php

/**
 * SongContributor : Official song of a contributor
 *
 * @author Stephanie Michel <stephanie@calo.zone>
 */

class SongContributor extends Root {
    const TBNAME = TABLEPREFIX.'_song_contributor';

    const R_AUTHOR = 1;
    const R_COMPOSER = 2;

    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'song_id' => 'int(11) NOT NULL DEFAULT 0',
        'contributor_id' => 'int(11) NOT NULL DEFAULT 0',
        'role' => 'int(1)'
    );

    /**
     * contributor for this song
     * @var integer
     */
    var $contributor_id = 0;
    /**
     * song for this contributor
     * @var integer
     */
    var $song_id = 0;
    /**
     * contributor's role
     * @var integer
     */
    var $role = 1;

    /**
     * Get stack contributors for one Song
     * @param int $id
     * @return \Contributor[]
     */
    public static function getStackSong($id = 0)
    {
        $items = array();

        $req = "SELECT * FROM ".self::TBNAME." WHERE song_id = ".intval($id);
        $result = SQL::query($req);

        while ($item = $result->fetch_assoc()) {
            $items[$item['role']][] = $item;
        }
        return $items;
    }

    /**
     * Get stack songs for one Contributor
     * @param int $id
     * @return \Song[]
     */
    public static function getStackContributor($id = 0)
    {
        $items = array();

        $req = "SELECT * FROM ".self::TBNAME." WHERE contributor_id = ".intval($id);
        $result = SQL::query($req);

        while ($item = $result->fetch_assoc()) {
            $items[$item['role']][] = $item;
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
