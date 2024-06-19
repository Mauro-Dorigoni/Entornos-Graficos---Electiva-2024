<?php
// Iniciar la sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['nombre'])) {
    echo  "<h1>Bienvenido " . $_SESSION['nombre'] . "<h1>";
} else {
    echo "<h1>No puede visitar esta pagina</h1>";
}
