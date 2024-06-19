<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bienvenido</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Bienvenido</h2>
        <div class="mt-3">
            <?php
            if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
                echo "<p><strong>Nombre de Usuario:</strong> " . htmlspecialchars($_SESSION['username']) . "</p>";
                echo "<p><strong>Clave:</strong> " . htmlspecialchars($_SESSION['password']) . "</p>";
            } else {
                echo "<div class='alert alert-warning' role='alert'>No has iniciado sesión.</div>";
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
