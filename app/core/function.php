<?php

function show($URL): void{
    echo "<pre>";
    print_r($URL);
    echo"</pre>";
}

function esc($str): string {
    return htmlspecialchars($str);
}

function redirect($path): void    {
    header("Location:".BASE_URL."/".$path);
}

function arrayContainsSameValues($array1, $array2): bool {
    $commValuesArray = array_intersect($array1,$array2);
    if($commValuesArray ==  $array1){
        return true;
    }else{
        return false;
    }
}