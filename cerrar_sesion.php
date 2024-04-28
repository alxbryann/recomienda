<?php
session_start();
session_destroy(); // Destruye todas las variables de sesión

// Redirige de vuelta al index.php
header("Location: index.php");
exit;
?>
