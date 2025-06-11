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
        private string $albumTime;

        function __construct(int $id, array $title, array $artists, int $year, array $genres, array $styles, array $labels, array $trackNames, array $trackTimes, string $albumTime) {
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
        public function getId(): int {
            return $this->id;
        }
        public function getTitle(): array {
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
    }
?>