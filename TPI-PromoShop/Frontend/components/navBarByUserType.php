<?php
require_once "../../Backend/structs/user.class.php";
require_once "../../Backend/structs/userCategory.class.php";
require_once "../shared/userType.enum.php";
require_once "../shared/frontendRoutes.dev.php";


// Verificamos si existe un usuario en la sesión
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    $userType = $_SESSION["userType"];

    // Carga la navbar según el rol si hay sesión
    if ($user != null && $userType === UserType_enum::Admin) {
        include "../components/adminNavBar.php";
    } elseif ($user != null && $userType === UserType_enum::Owner) {
        include "../components/ownerNavBar.php";
    } elseif ($user != null && $userType === UserType_enum::User) {
        include "../components/userNavBar.php";
    }
} else {
    // Si NO existe $_SESSION["user"], es un usuario no registrado
    include "../components/nonUserNavBar.php";
}
?>