<?php

require ROOT."/app/libraries/albumApi.php";

class AdminDatabase{
    use Controller;
    public function index(){
        if(isset($_SESSION["canLog"]) && $_SESSION['canLog'] === false){
            $_SESSION['username'] = "";
            $_SESSION['isLoggedIn'] = false;
            redirect('home');
        }
        if (!isset($_SESSION['isLoggedIn'])){
            redirect('login');
        }
        if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
            redirect('login');
        }

        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['keyword'])){
            $keyword = filter_input(INPUT_POST,'keyword', 
                            FILTER_SANITIZE_SPECIAL_CHARS);
            if(empty($keyword)){
                redirect('adminDatabase');
            }
            $keyword = trim($keyword);
            
            $data = getAlbum($keyword);
            if (is_bool($data) && !$data) {
                redirectMessage("adminDatabase", "Could not find the album you were looking for");
            }

            $data = prepareAlbumData($data);
            if(empty($data)){
                redirectMessage("adminDatabase", "The album dosen't exists");
            }
            
            $album = new Album();
            $check = $album->addAlbumToDatabase($data);
            if (!$check){
                redirectMessage("adminDatabase", "DB error: Album not added");
            }

            redirectMessage("adminDatabase", "The Album: ".$data['title']." was added");
        }
        
        $this->view('adminDatabase');
    }
}