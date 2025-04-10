<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Sidebar</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
    }

    /* Oculta el checkbox */
    #sidebarToggle {
      display: none;
    }

    /* Icono de menú */
    .toggle-label {
      position: fixed;
      top: 10px;
      left: 10px;
      z-index: 1001;
      background-color: #343a40;
      color: white;
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: -250px;
      width: 250px;
      height: 100vh;
      background-color: #343a40;
      padding-top: 60px;
      transition: left 0.3s ease;
      z-index: 1000;
    }

    .sidebar a {
      display: block;
      padding: 15px 20px;
      color: white;
      text-decoration: none;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    /* Mostrar la sidebar si el checkbox está activado */
    #sidebarToggle:checked ~ .sidebar {
      left: 0;
    }

    /* Mover el contenido cuando la sidebar está activa */
    #sidebarToggle:checked ~ .content {
      margin-left: 250px;
    }

    /* Contenido principal */
    .content {
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    /* Para pantallas grandes: sidebar siempre visible */
    @media (min-width: 768px) {
      .toggle-label {
        display: none;
      }

      .sidebar {
        left: 0;
      }

      .content {
        margin-left: 250px;
      }
    }
  </style>
</head>
<body>

  <!-- Checkbox oculto -->
  <input type="checkbox" id="sidebarToggle">

  <!-- Botón toggle -->
  <label for="sidebarToggle" class="toggle-label">☰</label>

  <!-- Sidebar -->
  <div class="sidebar">
    <a class="nav-link" href=<?php echo frontendURL."/newLocalPage.php"?>>Nuevo local</a>
    <a href="#">Servicios</a>
    <a href="#">Nosotros</a>
    <a href="#">Contacto</a>
    <a href="#">Admin</a>
  </div>


</body>
</html>
