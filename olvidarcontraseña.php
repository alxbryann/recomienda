<?php
$message = ""; // Variable para almacenar mensajes de éxito o error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new-password'];
    $repeat_password = $_POST['repeat-password'];

    // Comprobar si las contraseñas coinciden
    if ($new_password !== $repeat_password) {
        $message = "<div class='error'>Las contraseñas no coinciden.</div>";
    } else {
        // Conectar a la base de datos
        $conn = new mysqli("82.197.80.210", "u482925761_admin", "Clavetemporal/2024", "u482925761_recomienda");
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Obtener el correo electrónico del enlace
        $email = $_GET['email'];

        // Cifrar la nueva contraseña
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos
        $stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE email_usuario = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        if ($stmt->execute()) {
            $message = "<div class='success'>La contraseña se cambió exitosamente.</div>";
            // Redireccionar a login.php después de cambiar la contraseña
            header("Location: login.php");
            exit();
        } else {
            $message = "<div class='error'>Hubo un error al cambiar la contraseña.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.png">
    <style>
        /* Estilos CSS aquí */
    </style>
</head>
<body>
    <div class="password-panel">
        <form method="POST">
            <h2>Cambio de Contraseña</h2>
            <label for="new-password">Nueva Contraseña:</label><br>
            <input type="password" id="new-password" name="new-password" required><br>
            <label for="repeat-password">Repite la Contraseña:</label><br>
            <input type="password" id="repeat-password" name="repeat-password" required><br>
            <button type="submit">Cambiar Contraseña</button>
            <a>¿No tienes cuenta aún?</a>
            <a href="nuevousuario.php">Regístrate Aquí</a>
            <?php echo $message; ?> <!-- Mostrar mensajes de éxito o error -->
        </form>
    </div>
</body>
</html>

