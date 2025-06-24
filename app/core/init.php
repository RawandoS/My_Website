<?php


spl_autoload_register(function ($classname) {
    $filename = ROOT . "/app/models/" . ucfirst($classname) . ".php";
    if (file_exists($filename)) {
        require $filename;
    }
});

require 'config.php';
require 'function.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';