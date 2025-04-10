<?php
require_once "../shared/authFunctions.php/admin.auth.function.php";
require_once "../shared/backendRoutes.dev.php";
include "../components/messageModal.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/loginPage.css">
</head>
<body>
  <h2>Formulario de Registro</h2>
  <form  method="post" action=<?php echo backendHTTPLayer . '/newLocal.http.php'; ?>>
    <label for="form2Example17">Local:</label><br>
    <input type="text" id="form2Example17" name="local"><br><br>

    <label for="ubiLocal">Ubicacion:</label><br>
    <input type="text" id="ubiLocal" name="ubiLocal"><br><br>

    <label for="emailOwner">Mail del dueño:</label><br>
    <input type="email" id="emailOwner" name="emailOwner"><br><br>
    
    <label for="passwordOwner">Contraseña del dueño:</label><br>
    <input type="password" id="passwordOwner" name="passwordOwner"><br><br>

    <label for="opcion">Seleccioná una opción:</label><br>
    <select id="opcion" name="shopType">
      <option value="1">Opcion 1</option>
    </select><br><br>

    <input type="submit" value="Enviar">
  </form>
</body>
</html>
