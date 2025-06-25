<?php

class Album{
    use Model;

    private $table = "albums";

    public function getRows(){
        $sql = "SELECT * FROM albums";
        $result = $this->query($sql);
        if(is_bool($result) && $result == false){
            return false;
        }
        return $result;
    }
    
    public function getNumRows(){
        $sql = "SELECT * FROM albums";
        $result = $this->numRows($sql);
        if(is_bool($result) && $result == false){
            return false;
        }
        return $result;
    }

    public function getRowsPagination($start,$rowPerPage){
        $sql = "SELECT * FROM albums LIMIT $start, $rowPerPage";
        $result = $this->query($sql);
        if(is_bool($result) && $result == false){
            return false;
        }
        return $result;
    }

    public function updateAlbumValues($row){
        $sql = "UPDATE albums SET 
                    title = :title,
                    artists = :artists, 
                    year = :year, 
                    genres = :genres,
                    styles = :styles, 
                    labels = :labels, 
                    trackNames = :trackNames, 
                    trackTimes = :trackTimes, 
                    albumTime = :albumTime
                    WHERE albumId = :albumId";
        $result = $this->query($sql, [
            ':title' => $row['title'],
            ':artists' => $row['artists'],
            ':year' => $row['year'],
            ':genres' => $row['genres'],
            ':styles' => $row['styles'],
            ':labels' => $row['labels'],
            ':trackNames' => $row['trackNames'],
            ':trackTimes' => $row['trackTimes'],
            ':albumTime' => $row['albumTime'],
            ':albumId' => $row['albumId']
        ]);
        if(is_bool($result) && $result == false){
            return false;
        }
        return true;
    }
}
