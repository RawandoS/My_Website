<?php

require ROOT."/app/libraries/albumApi.php";

class AdminSuggestion{
    use Controller;
    public function index(){

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->handleAjaxRequest();
            return;
        }

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

        $suggestion = new Suggestion();
        $data = $suggestion->selectFrom();
        if(is_bool($data) && $data === false){
            $data = [];
        }
        
        $this->view('adminSuggestion', $data);
    }

    private function handleAjaxRequest() {
        ob_clean();
    
        header('Content-Type: application/json');
        header('X-Content-Type-Options: nosniff');
        
    try {
        $rawRequest = file_get_contents('php://input');
        $request = json_decode($rawRequest, true);

        if (!isset($_SESSION['isAdmin'])) {
            throw new Exception('Unauthorized access', 403);
        }

        if (!isset($request["myJSON"]["suggestionId"])) {
            throw new Exception('No suggestion ID provided', 400);
        }

        if (!isset($request["myJSON"]["suggestion"])) {
            throw new Exception('No suggestion provided', 400);
        }

        $id = (int)$request["myJSON"]["suggestionId"];
        $suggestion = new Suggestion();
        $check = $suggestion->deleteSuggestion(["id" => $id]);

        if (!$check) {
            throw new Exception('Suggestion deletion failed', 500);
        }

        $keyword = (string)$request["myJSON"]["suggestion"];
        $data = getAlbum($keyword);
        if (is_bool($data) && !$data) {
            throw new Exception('Album wasn\'t found', 400);
        }
        $data = prepareAlbumData($data);
         if(empty($data)){
            throw new Exception('Album dosen\'t exists', 400);
        }
        
        $album = new Album();
        $check = $album->addAlbumToDatabase($data);
        if (!$check){
            throw new Exception('DB error: album not added', 400);
        }

        echo json_encode([
            "success" => true, 
            "id" => $id,
            "message" => "The Album: " . $data['title'] . " was added",
            "redirect" => "adminSuggestion"
        ]);
        exit;

        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            die(json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]));
        }
    }
}