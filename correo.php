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
        .form-container {
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
        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-container label {
            color: #555555;
            display: block;
            margin-bottom: 5px;
        }
        .form-container input[type="email"] {
            width: 100%;
            padding: 15px; 
            margin-bottom: 15px; 
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 15px; 
            background-color: #74748a;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease; 
            color: black;
            font-size: large;
        }
        .form-container button:hover {
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
        .form-container .error {
            color: #E53935;
            margin-bottom: 20px;
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
<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validar el correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El formato del correo electrónico no es válido.";
        exit();
    }

    // Conectar a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Verificar si el correo electrónico existe en la base de datos
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email_usuario = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo "Este correo electrónico no está registrado.";
        exit();
    }

    // Crear el enlace de restablecimiento de contraseña
    $reset_link = "https://recomienda.site/olvidarcontraseña.html?email=" . urlencode($email);

    // Enviar el correo electrónico con el enlace de restablecimiento de contraseña
    $to = $email;
    $subject = "Restablecimiento de contraseña";
    $message = "Para restablecer tu contraseña, haz clic en el siguiente enlace: " . $reset_link;
    $headers = "From: noreply@yourwebsite.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "El correo electrónico de restablecimiento de contraseña ha sido enviado a " . $to;
    } else {
        echo "Hubo un error al enviar el correo electrónico de restablecimiento de contraseña.";
    }
}
?>



    <body>
        <div class="form-container">
            <h2>Recuperar tu cuenta </h2>
            <form method="POST">
                <label for="email">Ingresa tu correo electronico para enviarte el código de verificación</label>
                <input type="email" placeholder="Correo electrónico" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Por favor, introduce un correo electrónico válido." required>
                <button type="submit">Enviar correo electronico</button>
                <a>¿Te acordaste de tu cuenta?</a>
                <a href="login.php">Ve a tu cuenta</a>
            </form>
        </div>
    </body>
    </html>