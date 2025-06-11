<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "usersdatabase";
    $conn = "";

    try {
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }catch(mysqli_sql_exception $e) {
        echo "You're not connected";
    }

    printAlbum("Damn");

    function returnAlbum($searchString) {
        include("keys.php");
        $curl = curl_init();
        $token = $tokenKey;
        $query = urlencode($searchString);
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
        $albumId = $data['results'][0]['id'];
        
        $releaseUrl = "https://api.discogs.com/releases/{$albumId}";
        curl_setopt($curl, CURLOPT_URL, $releaseUrl);
        $releaseData = curl_exec($curl);
        $releaseData = json_decode($releaseData, true);
        
        curl_close($curl);
        return $releaseData;
    }
    
    function printAlbum($searchString) {
        $releaseData = returnAlbum($searchString);
        $artists = "";
        foreach ($releaseData['artists'] as $artist){
            $artists .= " ".$artist['name'];
        }
        echo "<h1>{$artists}: {$releaseData['title']}<br>
            ({$releaseData['year']})
            {$releaseData['released']}</h1>";
        echo "<br>";
        // TODO: adding genre and styles
        foreach ($releaseData['tracklist'] as $track) {
            echo "{$track['position']}. {$track['title']} ({$track['duration']})<br>";
        }
    }

    function getAlbumId($searchString) {
        include("keys.php");
        $curl = curl_init();
        $token = $tokenKey;
        $query = urlencode("$searchString");
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
        $albumId = $data['results'][0]['id'];
        curl_close($curl);
        return $albumId;
    }

    function addAlbumToDatabase($searchString){
        $album = returnAlbum($searchString);
        
    }
    
?>