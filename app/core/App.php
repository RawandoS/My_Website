<?php

class App{

    private $controller = "Home";
    private $method = "Index";
    private function splitURL(){
        $URL = $_GET["url"] ?? 'home';
        $URL = explode("/",trim($URL,"/"));
        return $URL;
    }

    public function loadController(){
        $URL = $this->splitURL();

        $filename = "./app/controllers/".ucfirst($URL[0]).".php";
        if(file_exists($filename)){
            require $filename;
            $this->controller = ucfirst($URL[0]);
            $controller = new $this->controller;

            if(isset($URL[1]) && method_exists($controller, $URL[1])){
                $this->method = $URL[1];
            }
            
            call_user_func_array([$controller, $this->method], []);
        }else{
            $filename = ROOT."/app/controllers/_404.php";
            require $filename;
            $this->controller = "_404";
            $controller = new $this->controller;
            call_user_func_array([$controller, $this->method], []);
        }
    }
}

