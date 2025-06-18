<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
        header('Location: login.php');
        exit();
    }
    if (isset($_SESSION["canLog"]) && $_SESSION["canLog"] == false) {
        echo '<script>
                alert("You are banned from the server");
                window.location.href = "index.php";
            </script>';
        $_SESSION['username'] = "";
        $_SESSION['isLoggedIn'] = false;
        session_destroy();
       exit();
    }

    //returns the string array from the converted json file from album specific ID
    function returnAlbum($searchString): mixed {
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
        if (!isset($data['results'][0]['id'])) {
            echo "The album id was not found<br>";
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
    
    //searches for an album and prints the results
    function printSearchAlbum($searchString): void {
        $album = returnAlbum($searchString);
        if (is_bool($album) && !$album) {
            echo "Could not print the album";
            return;
        }
        $artists = "";
        foreach ($album['artists'] as $artist){
            $artists .= " ".$artist['name'];
        }
        echo "<h1>{$artists}: {$album['title']}<br>
            ({$album['year']})
            {$album['released']}</h1>";
        $genres = "";
        foreach ($album['genres'] as $genre){
            $genres .= " ".$genre;
        }
        echo "<h2>{$genres}</h2>";
        $styles = "";
        foreach ($album['styles'] as $style){
            $styles .= ' '.$style;
        }
        echo "<h2>{$styles}</h2>";
        foreach ($album['tracklist'] as $track) {
            echo "{$track['position']}. {$track['title']} ({$track['duration']})<br>";
        }
        $albumId = $album['id'];
        echo'<br>Album ID:'.$albumId.'<br>';
    }

    //returns albumID from search
    function getAlbumId($searchString): mixed {
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
        if (!isset($data['results'][0]['id'])) {
            echo "The album id was not found<br>";
            return false;
        }
        $albumId = $data['results'][0]['id'];
        curl_close($curl);
        return $albumId;
    }

    //searches album and then adds it to the database
    function addAlbumToDatabase($searchString): bool{
        include("database.php");
        $album = returnAlbum($searchString);
        if (!$album) return false;

        $sql = mysqli_prepare($conn, 
            "INSERT INTO albums (albumId, title, artists, year, genres, styles, labels, trackNames, trackTimes, albumTime, albumCoverPath)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if (!$sql) {
            echo "SQL error: " . mysqli_error($conn);
            return false;
        }

        $albumId = $album['id'];
        
        $title = $album['title'];

        $year = $album['year'];

        $artists = [];
        foreach ($album['artists'] as $artist){
            array_push($artists, $artist['name']);
        }
        $artistStr = implode(',', $artists);


        $genres = [];
        foreach ($album['genres'] as $genre){
            array_push($genres, $genre);
        }
        $genresStr = implode(',', $genres);

        $styles = [];
        foreach ($album['styles'] as $style){
            array_push($styles, $style);
        }
        $stylesStr = implode(',', $styles);

        $labels = [];
        foreach ($album['labels'] as $label){
            array_push($labels, $label['name']);
        }
        $labelsStr = implode(',', $labels);

        $trackNames = [];
        foreach ($album['tracklist'] as $track){
            array_push($trackNames, $track['position'].".".$track["title"]);
        }
        $trackNamesStr = implode(",", $trackNames);

        $trackTimes = [];
        foreach ($album["tracklist"] as $track){
            $duration = $track["duration"];
            if ($duration == ""){
                $duration = "00:00";
            }
            array_push($trackTimes, $duration);
        }
        $trackTimeStr = implode(",", $trackTimes);
        if (empty($trackTimeStr)) {
            $trackTimeStr = '00:00';
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
        $albumTime = sprintf("%02d:%02d:%02d", $hour, $minute, $second);

        $albumCoverPath = "covers/{$title}.jpg";

        mysqli_stmt_bind_param(
            $sql, 
            'sssisssssss', 
            $albumId, $title, $artistStr, $year, $genresStr, $stylesStr, $labelsStr, $trackNamesStr, $trackTimeStr, $albumTime, $albumCoverPath
        );

        try {
            mysqli_stmt_execute($sql);
            return true;
        } catch(mysqli_sql_exception $e) {
            echo "Database error: " . $e->getMessage();
            return false;
        } finally {
            mysqli_stmt_close($sql);
        }
    }

    //returns an album from an ID if found else it returns false
    function getAlbumFromDatabase($albumId): Album|bool {
        include("database.php");
        $albumId = filter_var($albumId, FILTER_SANITIZE_NUMBER_INT);

        if(empty($albumId)){
            echo'<script>alert("Please enter the album ID")</script>';
            return false;
        }

        $sql = "SELECT * FROM albums
                WHERE albumId = '$albumId' LIMIT 1";
        try {
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            if (mysqli_num_rows($result) == 0) {
                return false;
            }
            $album = new Album(
                $row["id"], 
                $row["albumId"], 
                $row["title"], 
                $row["artists"], 
                $row["year"], 
                $row["genres"], 
                $row["styles"], 
                $row["labels"], 
                $row["trackNames"], 
                $row["trackTimes"], 
                $row["albumTime"]);
            return $album;
        }catch(mysqli_sql_exception $e) {
            echo "Album not found:". $e->getMessage();
            return false;
        }
    }

    function updateAlbumValues(array $row): bool {
        include("database.php");

        $sql = mysqli_prepare($conn, 
            "UPDATE albums SET 
                    title = ?,
                    artists = ?, 
                    year = ?, 
                    genres = ?,
                    styles = ?, 
                    labels = ?, 
                    trackNames = ?, 
                    trackTimes = ?, 
                    albumTime = ?
                    WHERE albumId = ?"
        );
        mysqli_stmt_bind_param(
            $sql, 
            'ssisssssss',
             $row["title"], $row["artists"], $row["year"], $row["genres"], $row["styles"], $row["labels"], $row["trackNames"], $row["trackTimes"], $row["albumTime"], $row["albumId"]
        );

        try {
            mysqli_stmt_execute($sql);
            return true;
        } catch(mysqli_sql_exception $e) {
            echo "Database error: " . $e->getMessage();
            return false;
        } finally {
            mysqli_stmt_close($sql);
        }
    }

    //prints an album from the database using the album
    function printAlbumFromDatabase($albumId): void {
        include('album.php');
        $album = getAlbumFromDatabase($albumId);
        if ($album === false) {
            echo'Wrong input id';
            exit();
        }
        $album->printAlbum() ;
    }

    function printAlbumFromDatabaseKeyword($keyword): void {
        include('album.php');
        $album = searchAlbumFromDatabase($keyword);
        if ($album === false) {
            echo'Wrong input id';
            exit();
        }
        $album->printAlbum() ;
    }

    function searchAlbumFromDatabase($keyword) {
        include("database.php");
        $keyword = filter_var($keyword, FILTER_SANITIZE_SPECIAL_CHARS);

        $sql = "SELECT * FROM albums WHERE title LIKE '%$keyword%' LIMIT 1";
        try {
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            if (mysqli_num_rows($result) == 0) {
                return false;
            }
            $album = new Album(
                $row["id"], 
                $row["albumId"], 
                $row["title"], 
                $row["artists"], 
                $row["year"], 
                $row["genres"], 
                $row["styles"], 
                $row["labels"], 
                $row["trackNames"], 
                $row["trackTimes"], 
                $row["albumTime"]);
            return $album;
        }catch(mysqli_sql_exception $e) {
            echo "Album not found:". $e->getMessage();
            return false;
        }
    }    

    function oldCreateAlbum($searchString){
        $album = returnAlbum($searchString);

        $albumId = $album['id'];
        echo'this is id:'.$albumId.'<br>';
        $title = $album['title'];
        echo'title:'.$title.'<br>';
        $artists = [];
        foreach ($album['artists'] as $artist){
            array_push($artists, $artist['name']);
        }
        $artistStr = implode(',', $artists);
        echo "Artist: {$artistStr}<br>";
        $year = $album['year'];
        echo 'year:'.$year.'<br>';
        $genres = [];
        foreach ($album['genres'] as $genre){
            array_push($genres, $genre);
        }
        print_r($genres);
        echo '<br>';
        $styles = [];
        foreach ($album['styles'] as $style){
            array_push($styles, $style);
        }
        print_r($styles);
        echo '<br>';
        $labels = [];
        foreach ($album['labels'] as $label){
            array_push($labels, $label['name']);
        }
        print_r($labels);
        echo '<br>';
        $trackNames = [];
        foreach ($album['tracklist'] as $track){
            array_push($trackNames, $track['position'].".".$track["title"]);
        }
        print_r($trackNames);
        echo "<br>";
        $trackTimes = [];
        foreach ($album["tracklist"] as $track){
            $duration = $track["duration"];
            if ($duration == ""){
                $duration = "00:00";
            }
            array_push($trackTimes, $duration);
        }
        print_r($trackTimes);
        echo "<br>";
        
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
        $time = sprintf("%02d:%02d:%02d", $hour, $minute, $second);
        echo "total time $time<br>";
    }
?>