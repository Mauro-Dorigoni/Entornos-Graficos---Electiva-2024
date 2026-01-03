<?php 
if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];
        $userType = $_SESSION["userType"];

        if ($user != null && $userType === UserType_enum::Admin) {
        include "../components/adminNavBar.php";
    }
        if ($user != null && $userType === UserType_enum::Owner) {

        include "../components/ownerNavBar.php";
        }
    }
?>