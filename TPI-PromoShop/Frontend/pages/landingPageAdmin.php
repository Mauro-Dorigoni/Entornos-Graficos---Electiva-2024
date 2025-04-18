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
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include "../components/header.php"?>
    <?php include "../components/adminNavBar.php"?>

    <div class="content">
        <h1>Landing Page Admin</h1>
        <h2>Bienvenido <?php echo $user->getEmail()?></h2>
        
    </div>

    <?php include "../components/footer.php"?>
</body>
</html>