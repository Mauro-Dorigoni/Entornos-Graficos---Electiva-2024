<?php
require_once "../shared/authFunctions.php/admin.auth.function.php";
require_once "../../Backend/structs/user.class.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin landing page</title>
</head>
<body>
    <h1>Landing Page Admin</h1>
    <h2>Bienvenido <?php echo $user->getEmail()?></h2>
</body>
</html>