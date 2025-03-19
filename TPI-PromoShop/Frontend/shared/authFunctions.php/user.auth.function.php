<?php
require_once __DIR__ ."/../userType.enum.php";
require_once __DIR__ ."/../frontendRoutes.dev.php";
require_once __DIR__ ."/../../../Backend/structs/user.class.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];
    $userType = $_SESSION["userType"];

    if($user === null){
        header("Location: ".frontendURL."/loginPage.php");
        exit;
    }
}else{
    header("Location: ".frontendURL."/loginPage.php");
    exit;
}

?>