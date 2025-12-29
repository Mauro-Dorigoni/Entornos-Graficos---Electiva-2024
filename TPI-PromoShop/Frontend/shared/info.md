Variables de Ambiente

<?php
define("servername", "");
define("username", "");
define("password", "");
define("dbName", "");
?>


Aca en el archivo backendRoutes.dev.php poner: 
<?php
define(constant_name: "backendHTTPLayer", value: "/Entornos-Graficos---Elctiva-2024/TPI-PromoShop/Backend/http")
?>

Aca en el archivo frontendRoutes.dev.php poner:
<?php
define(constant_name: "frontendURL", value: "/Entornos-Graficos---Elctiva-2024/TPI-PromoShop/Frontend/pages")
?>