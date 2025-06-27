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

function redirectMessage($path,$message): void {
    $message = str_replace("'","\'",$message);
    echo "<script>
        window.location.href='".BASE_URL."/".$path."';
        alert('".$message."');
    </script>";
}

/**
 * Return `true` if the interesction of the two arrays is equal to the first array,
 * if not it returns `false`
 * @param array $array1
 * @param array $array2
 * @return bool
 */
function arrayContainsSameValues($array1, $array2): bool {
    $commValuesArray = array_intersect($array1,$array2);
    if($commValuesArray ==  $array1){
        return true;
    }else{
        return false;
    }
}

function checkSession (){
    if(isset($_SESSION["canLog"]) && $_SESSION['canLog'] === false){
        $_SESSION['username'] = "";
        $_SESSION['isLoggedIn'] = false;

        redirectMessage('home',"You can't log to the server");
    }
    if (!isset($_SESSION['isLoggedIn'])){
        redirectMessage('login',"You aren't logged to the server");
    }
}

function checkSessionAdmin(){
    checkSession();
    if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
        redirectMessage('login', "You're not an administrator");
    }
}

function customAlert($message): void {
    ?> <script>alert("<?php echo $message; ?>")</script>
    <?php die(); 
}