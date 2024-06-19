<?php
setcookie('pagina', '', time() - 3600, "/");
header("Location: periodico.php");
exit();
