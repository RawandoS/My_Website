<?php
    class Album {
        private int $id;
        private int $albumId;
        private string $title;
        private array $artists;
        private int $year;
        private array $genres;
        private array $styles;
        private array $labels;
        private array $trackNames;
        private array $trackTimes;
        private string $albumTime;

        public function __construct(int $id,int $albumId ,string $title, string $artists, int $year, string $genres, string $styles, string $labels, string $trackNames, string $trackTimes, string $albumTime) {
            $this->id = $id;
            $this->albumId = $albumId;
            $this->title = $title;
            $this->artists = explode(",", $artists);
            $this->year = $year;
            $this->genres = explode(",", $genres);
            $this->styles = explode(",", $styles);
            $this->labels = explode(",", $labels);
            $this->trackNames = explode(",", $trackNames);
            $this->trackTimes = explode(",", $trackTimes);
            $this->albumTime = $albumTime;
        }
        public function getId(): int {
            return $this->id;
        }
        public function getAlbumId(): int {
            return $this->albumId;   
        }
        public function getTitle(): string {
            return $this->title;
        }
        public function getArtists(): array {
            return $this->artists;
        }
        public function getYear(): int {
            return $this->year;
        }
        public function getGenres(): array {
            return $this->genres;
        }
        public function getStyles(): array {
            return $this->styles;
        }
        public function getLabels(): array {
            return $this->labels;
        }
        public function getTrackNames(): array {
            return $this->trackNames;
        }
        public function getTrackTimes(): array {
            return $this->trackTimes;
        }
        public function getAlbumTime(): string {
            return $this->albumTime;
        }

        
        public function printAlbum(): void{
            echo "<h1>{$this->title} - {$this->year}</h1>";
            $artistStr = implode(" ",$this->artists);
            $genresStr = implode(", ", $this->genres);
            $stylesStr = implode(", ", $this->styles);
            $labelsStr = implode(", ", $this->labels);
            echo "<h3>Artists: {$artistStr}</h3>";
            echo "<h4>Genres: {$genresStr}<br>Styles: {$stylesStr}<br>Labels: {$labelsStr}</h4>";
            $trackCount = 0;
            foreach ($this->trackNames as $track){
                echo "<p class='albumEcho'>".$track." (".$this->trackTimes[$trackCount].")<p>";
                $trackCount++;
            }
            echo "<h3 class='finalInfo'>".$trackCount." tracks, ".$this->albumTime."</h3>";
        }
    }
?>