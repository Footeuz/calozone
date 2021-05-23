<?php
require_once '../boot.php';

$feed = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $feed .= "<rss xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:atom=\"http://www.w3.org/2005/Atom\" version=\"2.0\" xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\">\n";
        $feed .= "<channel>\n";
        $feed .= "<title>". PODCAST_TITLE ."</title>\n";
        $feed .= "<description>Que vous l'ayez connu en Charly, dans un ascenseur, ou avec Liberté Chérie, bienvenue dans ".PODCAST_TITLE."</description>\n";
        $feed .= "<link>".URL."podcast-list</link>\n";
        $feed .= "<image>\n";
            $feed .= "<url>".URL."public/images/home/big/".$mainartistslug."-podcast.jpg</url>\n";
            $feed .= "<title>". PODCAST_TITLE ."</title>\n";
            $feed .= "<link>".URL."podcast-list</link>\n";
        $feed .= "</image>\n";
        $feed .= "<generator>Calo.zone</generator>\n";
        $feed .= "<lastBuildDate>Sun, 08 Sep 2019 23:00:00 GMT</lastBuildDate>\n";
        $feed .= "<atom:link href=\"https://calo.zone/podcast-rss\" rel=\"self\" type=\"application/rss+xml\" />\n";
        $feed .= "<pubDate>Sun, 08 Sep 2019 23:00:00 GMT</pubDate>\n";
        $feed .= "<language>fr</language>\n";
        $feed .= "<webMaster>".PODCAST_MAIL." (". PODCAST_TITLE .")</webMaster>\n";
        $feed .= "<itunes:summary>Podcast sur la carrière de l'artiste ". $mainartist ."</itunes:summary>\n";
        $feed .= "<itunes:subtitle><![CDATA[Pop Culture]]></itunes:subtitle>\n";
        $feed .= "<itunes:explicit>no</itunes:explicit>\n";
        $feed .= "<itunes:keywords>pop, culture, ".$mainartistslug."</itunes:keywords>\n";
        $feed .= "<itunes:author>". PODCAST_TITLE ."</itunes:author>\n";
        $feed .= "<itunes:image href=\"".URL."public/images/home/big/".$mainartistslug."-podcast.jpg\"/>\n";
        $feed .= "<itunes:owner>\n";
            $feed .= "<itunes:name>". PODCAST_TITLE ."</itunes:name>\n";
            $feed .= "<itunes:email>".PODCAST_MAIL."</itunes:email>\n";
        $feed .= "</itunes:owner>\n";
        $feed .= "<itunes:type>episodic</itunes:type>\n";
        $feed .= "<itunes:category text=\"Music\"/>\n";
    
        $result = SQL::select(Podcast::TBNAME, array('active' => 1), '*', 'id DESC');
        while($item = $result->fetch_assoc()) {
        
            $feed .= "<item>\n";
                $feed .= "<title>". PODCAST_TITLE ." - ".$item['name']."</title>\n";
                $feed .= "<description><![CDATA[".html_entity_decode($item['description'])."]]></description>\n";
                $feed .= "<link>".URL."podcast-details-".$item['episode']."</link>\n";
                $feed .= "<dc:creator>". PODCAST_TITLE ."</dc:creator>\n";
                $feed .= "<pubDate>".date(DATE_RSS, $item['date_add'])."</pubDate>\n";
                $feed .= "<enclosure url=\"".URL.$item['path']."\" length=\"".$item['duration']."\" type=\"audio/mpeg\"/>\n";
                $feed .= "<itunes:image href=\"".URL."podcast-img-".$item['id'].".jpg\"/>\n";
                $feed .= "<itunes:summary>". PODCAST_TITLE ." - ".$item['name']."</itunes:summary>\n";
                $feed .= "<itunes:explicit>no</itunes:explicit>\n";
                $feed .= "<itunes:duration>".$item['duration']."</itunes:duration>\n";
                $feed .= "<itunes:author>". PODCAST_TITLE ."</itunes:author>\n";
                $feed .= "<itunes:episodeType>full</itunes:episodeType>\n";
            $feed .= "</item>\n";
        }
$feed .= "</channel>\n";
$feed .= "</rss>\n";

$fp = fopen('../podcast-rss.xml', 'w');
fwrite($fp, $feed);

echo 'Flux mis à jour : <a href="'.URL.'podcast-rss.xml">'.URL.'podcast-rss.xml</a>';