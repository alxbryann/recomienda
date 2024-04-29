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
        body {
            font-family: Arial, sans-serif;
            background-color: #3c3c47;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .password-panel {
            width: 100%; 
            margin-top: 2%;
            margin-left: 10%;
            margin-right: 10%;
            padding: 50px; 
            background-color: #fff;
            border-radius: 30px;
            border: 3px solid black;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            animation: fadein 2s;
        }
        .password-panel h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .password-panel input[type="password"] {
            width: 100%;
            padding: 15px; 
            margin-bottom: 15px; 
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .password-panel button {
            width: 100%;
            padding: 15px; 
            background-color: #74748a;
            margin-top: 21px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease; 
            color: black;
            font-size: large;
        }
        .password-panel button:hover {
            background-color: #3c3c47;
        }
        .password-panel a {
            display: block;
            margin-top: 20px;
        }
        @keyframes fadein {
            from { opacity: 0; }
            to   { opacity: 3; }
        }
        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }
            .cancelbtn {
                width: 100%;
            }
        }
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

