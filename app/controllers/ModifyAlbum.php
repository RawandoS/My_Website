<?php

class ModifyAlbum{
    use Controller;
    public function index(){
        if(isset($_SESSION["canLog"]) && $_SESSION['canLog'] === false){
            $_SESSION['username'] = "";
            $_SESSION['isLoggedIn'] = false;

            redirect('home');
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            show($_POST);
            $targetFile = ROOT."/public/assets/images/covers/".$_POST["title"].".jpg";
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            $album = new Album();
            $check = true;
            $row = $_POST;
            $row['albumId'] = $_SESSION["albumData"]['albumId'];

            if (empty($_FILES["fileInput"]["tmp_name"])) {
                show($_FILES["fileInput"]);
                $check = $album->updateAlbumValues($row);
                if (!$check){
                    echo '<script>alert("Database was not updated")</script>';
                }
                if ($_SESSION["isFromHome"] === true){
                    redirect("datatable");
                }elseif ($_SESSION["isFromHome"] === false){
                    redirect("coverShow");
                }else{
                    echo '<script>alert("Where did you come from")</script>';
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
                    $check = $album->updateAlbumValues($row);
                    if (!$check){
                        echo '<script>alert("Database was not updated")</script>';
                    }
                    if ($_SESSION["isFromHome"] === true){
                        redirect("datatable");
                    }elseif ($_SESSION["isFromHome"] === false){
                        redirect("coverShow");
                    }else{
                        echo '<script>alert("Where did you come from")</script>';
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