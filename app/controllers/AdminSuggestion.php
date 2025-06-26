<?php

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
            echo "no data was found";
        }
        
        $this->view('adminSuggestion', $data);
    }

    private function handleAjaxRequest() {
        ob_clean();
    
        header('Content-Type: application/json');
        header('X-Content-Type-Options: nosniff');
    
    try {
        if (!isset($_SESSION['isAdmin'])) {
            throw new Exception('Unauthorized access', 403);
        }

        if (!isset($_POST["suggestionId"])) {
            throw new Exception('No suggestion ID provided', 400);
        }

        $id = (int)$_POST["suggestionId"];
        $suggestion = new Suggestion();
        $check = $suggestion->deleteSuggestion(["id" => $id]);

        if (!$check) {
            throw new Exception('Suggestion deletion failed', 500);
        }

        die(json_encode([
            "success" => true, 
            "id" => $id
        ]));

        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            die(json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]));
        }
    }
}