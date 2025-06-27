<?php

require ROOT."/app/core/Keys.php";

$token = new Token();
define('TOKENDISCOGS', $token->getToken());


/**
 * When given a `keyword` it seraches for it in the discogs API, and from the first
 * result it gets the album id, which it uses to get the json of the album, which is 
 * then returned as an `array`; if no id is found or if the release was removed / never existed
 * it returns `false`
 * @param mixed $keyword
 */
function getAlbum($keyword){
    global $tokenGlobal;
    $curl = curl_init();
    $token = TOKENDISCOGS;
    $query = urlencode($keyword);
    $url = "https://api.discogs.com/database/search?q={$query}&type=release";
    curl_setopt($curl, CURLOPT_URL,"{$url}");
    curl_setopt($curl, CURLOPT_HTTPHEADER,array(
        "Authorization: Discogs token={$token}",
        "User-Agent: R4WANDO/1.0",
        "Accept: application/json"
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    $data = curl_exec($curl);
    
    $data = json_decode($data, true);
    if (!isset($data['results'][0]['id'])) {
        echo "The album id was not found<br>";
         show($data);
        return false;
    }
   
    $albumId = $data['results'][0]['id'];
    $releaseUrl = "https://api.discogs.com/releases/{$albumId}";
    curl_setopt($curl, CURLOPT_URL, $releaseUrl);
    $releaseData = curl_exec($curl);
    
    $releaseData = json_decode($releaseData, true);
    curl_close($curl);
    if (isset($releaseData["message"]) && $releaseData["message"] == "That release does not exist or may have been deleted.") {
        echo "The id is wrong<br>";
        return false;
    }

    return $releaseData;
}

/**
 * The full album array sent to the function is formatted to be then returned as an `array`
 * to give to the query; if the array in input is not an array or it's empty, an empty 
 * `array` is returned
 * @param array $album
 * @return array
 */
function prepareAlbumData($album){
    if(!is_array($album || empty($album))){
        $album = [];
        return $album;
    }

    $data = [];

    $data['albumId'] = $album['id'];
    
    $data['title'] = $album['title'];

    $data['year'] = $album['year'];

    $artists = [];
    foreach ($album['artists'] as $artist){
        array_push($artists, $artist['name']);
    }
    $data['artists'] = implode(',', $artists);


    $genres = [];
    foreach ($album['genres'] as $genre){
        array_push($genres, $genre);
    }
    $data['genres'] = implode(',', $genres);

    $styles = [];
    foreach ($album['styles'] as $style){
        array_push($styles, $style);
    }
    $data['styles'] = implode(',', $styles);

    $labels = [];
    foreach ($album['labels'] as $label){
        array_push($labels, $label['name']);
    }
    $data['labels'] = implode(',', $labels);

    $trackNames = [];
    foreach ($album['tracklist'] as $track){
        array_push($trackNames, $track['position'].".".$track["title"]);
    }
    $data['trackNames'] = implode(",", $trackNames);

    $trackTimes = [];
    foreach ($album["tracklist"] as $track){
        $duration = $track["duration"];
        if ($duration == ""){
            $duration = "00:00";
        }
        array_push($trackTimes, $duration);
    }
    $data['trackTimes'] = implode(",", $trackTimes);
    if (empty($data['trackTimes'])) {
        $data['trackTimes'] = '00:00';
    }
    
    $totSeconds = 0;
    foreach ($trackTimes as $time){
        if (strpos($time,":") === false){
            continue;
        }
        list($minute, $second) = explode(":", $time);
        $totSeconds += $minute*60 + $second;
    }
    $hour = floor($totSeconds /3600);
    $totSeconds %= 3600;
    $minute = floor($totSeconds /60);
    $second = $totSeconds %60;
    $data['albumTime'] = sprintf("%02d:%02d:%02d", $hour, $minute, $second);

    $albumCoverPath = "http://localhost/public/assets/images/covers/".$data['title'].".jpg";
    $data['albumCoverPath'] = preg_replace('/\s+/', '_', $albumCoverPath);
    
    return $data;
}
