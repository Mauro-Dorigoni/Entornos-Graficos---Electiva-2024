<?php
session_start();
?>
<html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="text_center">En esta pagina contamos cuantas veces nos visitaste</h1>
        <h6 class="text_center">
            <?php
            echo "Has visitado " . ($_SESSION["contador"]) . " páginas";
            ?>
        </h6>

        <?php
        if (!isset($_SESSION["contador"])) {
            $_SESSION["contador"] = 1;
        } else {
            $_SESSION["contador"]++;
        } ?>
        <a type="button" class="btn btn-secondary align-item-center" href="contador.php">Visitar la pagina</a>

    </div>


</body>

</html>