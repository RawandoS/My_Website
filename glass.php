<?php
    session_start();
    if (!isset($_SESSION['isLoggedIn'])){
        header('Location: login.php');
        exit();
    }
    class Glass {
        private float $height = 0;
        private float $width = 0;
        private float $depth = 0;
        public function __construct($height, $width, $depth) {
            if ($height < 0) {
                $height = 0.1;
            }
            $this->height = $height;
            if ($width < 0) {
                $width = 0.1;
            }
            $this->width = $width;
            if ($depth < 0) {
                $depth = 0.1;
            }
            $this->depth = $depth;
        }
        public function setHeight(float $height) {
            if ($height < 0) {
                $height = 0;
            }
            $this->height = $height;
        }
        public function setWidth(float $width) {
            if ($width < 0) {
                $width = 0;
            }
            $this->width = $width;
        }
        public function setDepth(float $depth) {
            if ($depth < 0) {
                $depth = 0;
            }
            $this->depth = $depth;
        }
        public function getWidth() {
            return $this->width;
        }
        public function getHeight() {
            return $this->height;
        }
        public function getDepth() {
            return $this->depth;
        }

        
        public function getArea(){
            return $this->height*$this->width;
        }
        public function printArea(){
            echo "The area is: ".$this->getArea()."<br>";
        }

        public function getVolume(){
            return $this->width*$this->height*$this->depth;
        }
        public function printVolume(){
            echo "The volume is: ".$this->getVolume()."<br>";
        }

        public function __toString() {
            return "Glass[ widht:({$this->width}), height:({$this->height}), depth:({$this->depth}), Area:({$this->getArea()}), Volume:({$this->getVolume()})]<br>";
        }

        public function isBigger(Glass $glass){
            if ($this->getVolume() > $glass->getVolume()) {
                return true;
            } else if ($this->getVolume() < $glass->getVolume()) {
                return false;
            } else {
                echo '<div id="echos">Equal Size(default true)</div>';
                return true;
            }
        }
    }            
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>MySite</title>
        <link rel="stylesheet" href="CSS/style.css" media="screen">
    </head>
    <body>
        <header><h2>My Site</h2></header>
        <a href="Home.php" target="_self">
            <button>To the HUB</button>
        </a>
        <form method="post">
            <label>Height:</label><br>
            <input type="number", name="Height", min="0" , value="10"><br>
            <label>Widht:</label><br>
            <input type="number", name="Widht", min="0", value="10"><br>
            <label>Depth:</label><br>
            <input type="number", name="Depth", min="0", value="10"><br>
            <input type="submit" value="Creat glass">
        </form>
        <?php
            
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $Glass1 = new Glass(filteredPOST("Height"), filteredPOST("Widht"),filteredPOST("Depth"));
                $Glass2 = new Glass(5,20,10);
                $Glass1->printVolume();
                $Glass2->printVolume();
                if ($Glass1->isBigger($Glass2)){
                    echo "Glass 1 is bigger!<br>";
                } else {
                    echo "Glass 2 is bigger!<br>";
                }
                
            }
            
            function filteredPOST($key){
                return isset($_POST[$key]) ? $_POST[$key] : 0.1;
            }
        ?>

        <footer>
            <a href="home.php">Home</a>
            <a href="index.php">Index</a>
        </footer>
    </body>
</html>
