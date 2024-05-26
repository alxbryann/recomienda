<?php
// Datos del servidor
$user = "u482925761_admin";
$pass = "Clavetemporal/2024";
$host = "82.197.80.210";
$dbname = "u482925761_recomienda"; // Nombre de tu base de datos

// Conexión a la base de datos
$connection = mysqli_connect($host, $user, $pass, $dbname);

// Verificar la conexión
if (!$connection) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Iniciar sesión
session_start();
$id_usuario = $_SESSION['id_usuario'];

// Obtener datos del usuario
$sql = "SELECT nombre_usuario, apellido_usuario, email_usuario, tel_usuario FROM usuarios WHERE id_usuario = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$stmt->bind_result($nombre, $apellido, $email, $telefono);
$stmt->fetch();
$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="icon" href="logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="estilosPerfil.css" />
</head>
<body>
    <main>
        <div class="container-profile">
            <div id="container-info">
                <p>Nombre:</p> <h1><?php echo htmlspecialchars($nombre . ' ' . $apellido); ?></h1>
                <p>Email:</p> <h2><?php echo htmlspecialchars($email); ?></h2>
                <p>Teléfono:</p> <h2><?php echo htmlspecialchars($telefono); ?></h2>
                <p>ID Usuario:</p> <h2><?php echo htmlspecialchars($id_usuario); ?></h2>
            </div>
            <div id="stars">
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
            </div>
        </div>
        <div class="container-recomendaciones">
            <h1>Mis recomendaciones</h1>
        </div>
        <div class="container-recomendaciones">
            <h1>Me han recomendado</h1>
        </div>
    </main>
</body>
</html>
