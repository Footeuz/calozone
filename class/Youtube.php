<?php

/**
 * Class to get infos of youtube video
 *
 * @author smichel
 */
class Youtube {

    static $api_key = YTAPIKEY;
    static $api_base = 'https://www.googleapis.com/youtube/v3/videos';
    static $thumbnail_base = 'https://i.ytimg.com/vi/';

    /**
     * @param string $vid - video id in youtube
     * @return array[] video info
     */
    public static function getVideoInfo($vid)
    {
        $params = array(
            'part' => 'contentDetails',
            'id' => $vid,
            'key' => self::$api_key,
        );

        $api_url = Youtube::$api_base . '?' . http_build_query($params);
        $result = json_decode(@file_get_contents($api_url), true);

        if(empty($result['items'][0]['contentDetails']))
            return null;
        $vinfo = $result['items'][0]['contentDetails'];

        $interval = new DateInterval($vinfo['duration']);
        $vinfo['duration'] = $interval->h * 3600 + $interval->i * 60 + $interval->s;

        $vinfo['thumbnail']['default']       = self::$thumbnail_base . $vid . '/default.jpg';
        $vinfo['thumbnail']['mqDefault']     = self::$thumbnail_base . $vid . '/mqdefault.jpg';
        $vinfo['thumbnail']['hqDefault']     = self::$thumbnail_base . $vid . '/hqdefault.jpg';

        $vinfo['thumbnail']['sdDefault']     = self::$thumbnail_base . $vid . '/sddefault.jpg';
        $vinfo['thumbnail']['maxresDefault'] = self::$thumbnail_base . $vid . '/maxresdefault.jpg';

        return $vinfo;
    }

}
