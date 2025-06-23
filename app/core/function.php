<?php

function show($URL){
    echo "<pre>";
    print_r($URL);
    echo"</pre>";
}

function esc($str) {
    return htmlspecialchars($str);
}