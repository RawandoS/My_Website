<?php
    class Album {
        private int $id;
        private array $title;
        private array $artists;
        private int $year;
        private array $genres;
        private array $styles;
        private array $labels;
        private array $trackNames;
        private array $trackTimes;
        private array $albumTime;

        function __construct(int $id, array $title, array $artists, int $year, array $genres, array $styles, array $labels, array $trackNames, array $trackTimes, array $albumTime) {
            $this->id = $id;
            $this->title = $title;
            $this->artists = $artists;
            $this->year = $year;
            $this->genres = $genres;
            $this->styles = $styles;
            $this->labels = $labels;
            $this->trackNames = $trackNames;
            $this->trackTimes = $trackTimes;
            $this->albumTime = $albumTime;
        }
    }
?>