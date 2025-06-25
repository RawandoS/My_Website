<?php

class ModifyAlbum{
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
        if(!isset($_SESSION['isFromHome'])){
            redirect('home');
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $targetFile = ROOT."/public/assets/images/covers/".$_POST["title"].".jpg";
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            $album = new Album();
            $check = true;
            $row = $_POST;
            unset($row["submit_value"]);
            $row['albumId'] = $_SESSION["albumData"]['albumId'];

            if(arrayContainsSameValues($row, $_SESSION["albumData"])){
                echo '<script>alert("No album values modification")</script>';
                $Update = false;
            }else{
                echo '<script>alert("Album was modified")</script>';
                $Update = true;
            }

            if (empty($_FILES["fileInput"]["tmp_name"])) {
                show($_FILES["fileInput"]);
                if($Update){
                    $check = $album->updateAlbumValues($row);
                    if (!$check){
                        echo '<script>alert("Database was not updated")</script>';
                    }
                }
                if ($_SESSION["isFromHome"] === true){
                    unset($_SESSION["albumData"]);
                    redirect("datatable");
                }elseif ($_SESSION["isFromHome"] === false){
                    unset($_SESSION["albumData"]);
                    redirect("coverShow");
                }else{
                    echo '<script>alert("Where did you come from")</script>';
                    unset($_SESSION["albumData"]);
                    redirect('main');
                }
            }else{
                $uploadFile = $_FILES['fileInput'];
                $check = getimagesize($uploadFile['tmp_name']);
                if (!$check){
                    echo '<script>alert("File in not an image")</script>';
                    unset($_POST);
                    redirect('modifyAlbum');
                }
                if ($uploadFile["size"] > 500000) {
                    echo '<script>alert("File is too large")</script>';
                    unset($_POST);
                    redirect('modifyAlbum');
                }
                if($imageFileType != "jpg" && $imageFileType != "jpeg") {
                    echo '<script>alert("File is not jpg or jpeg")</script>';
                    unset($_POST);
                    redirect('modifyAlbum');
                }
                $targetFile = preg_replace('/\s+/', '_', $targetFile);
                if (move_uploaded_file($uploadFile['tmp_name'],$targetFile)){
                    if($Update){
                        $check = $album->updateAlbumValues($row);
                        if (!$check){
                            echo '<script>alert("Database was not updated")</script>';
                        }
                    }
                    
                    if ($_SESSION["isFromHome"] === true){
                        unset($_SESSION["albumData"]);
                        redirect("datatable");
                    }elseif ($_SESSION["isFromHome"] === false){
                        unset($_SESSION["albumData"]);
                        redirect("coverShow");
                    }else{
                        echo '<script>alert("Where did you come from")</script>';
                        unset($_SESSION["albumData"]);
                        redirect('main');
                    }
                }
            }
        }

        
        $data = $_SESSION["albumData"];
        $albumCoverPath = str_replace(BASE_URL,ROOT, $data["albumCoverPath"]);
        $data["albumCoverPath"] =  (file_exists($albumCoverPath)) ? $data["albumCoverPath"] : BASE_URL."/public/assets/images/defaultVinyl.png";
        
        $this->view('modifyAlbum', $data);
    }
}