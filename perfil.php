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
$sql_usuario = "SELECT nombre_usuario, apellido_usuario, email_usuario, tel_usuario, foto_perfil FROM usuarios WHERE id_usuario = ?";
$stmt_usuario = $connection->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $id_usuario);
$stmt_usuario->execute();
$stmt_usuario->bind_result($nombre, $apellido, $email, $telefono, $foto_perfil);
$stmt_usuario->fetch();
$stmt_usuario->close();

// Obtener recomendaciones hechas por el usuario
$sql_recomendaciones_hechas = "SELECT COUNT(*) FROM recomendaciones WHERE id_usuario = ?";
$stmt_recomendaciones_hechas = $connection->prepare($sql_recomendaciones_hechas);
$stmt_recomendaciones_hechas->bind_param("i", $id_usuario);
$stmt_recomendaciones_hechas->execute();
$stmt_recomendaciones_hechas->bind_result($num_recomendaciones_hechas);
$stmt_recomendaciones_hechas->fetch();
$stmt_recomendaciones_hechas->close();

// Obtener recomendaciones recibidas por el usuario
$sql_recomendaciones_recibidas = "SELECT COUNT(*) FROM recomendaciones WHERE id_recomendado = ?";
$stmt_recomendaciones_recibidas = $connection->prepare($sql_recomendaciones_recibidas);
$stmt_recomendaciones_recibidas->bind_param("i", $id_usuario);
$stmt_recomendaciones_recibidas->execute();
$stmt_recomendaciones_recibidas->bind_result($num_recomendaciones_recibidas);
$stmt_recomendaciones_recibidas->fetch();
$stmt_recomendaciones_recibidas->close();

// Obtener estrellas de las recomendaciones recibidas por el usuario
$sql_estrellas_recibidas = "SELECT AVG(estrellas) FROM recomendaciones WHERE id_recomendado = ?";
$stmt_estrellas_recibidas = $connection->prepare($sql_estrellas_recibidas);
$stmt_estrellas_recibidas->bind_param("i", $id_usuario);
$stmt_estrellas_recibidas->execute();
$stmt_estrellas_recibidas->bind_result($promedio_estrellas_recibidas);
$stmt_estrellas_recibidas->fetch();
$stmt_estrellas_recibidas->close();

// Obtener recomendaciones hechas
$sql_detalle_recomendaciones_hechas = "SELECT descripcion, estrellas FROM recomendaciones WHERE id_usuario = ?";
$stmt_detalle_recomendaciones_hechas = $connection->prepare($sql_detalle_recomendaciones_hechas);
$stmt_detalle_recomendaciones_hechas->bind_param("i", $id_usuario);
$stmt_detalle_recomendaciones_hechas->execute();
$result_recomendaciones_hechas = $stmt_detalle_recomendaciones_hechas->get_result();
$recomendaciones_hechas = $result_recomendaciones_hechas->fetch_all(MYSQLI_ASSOC);
$stmt_detalle_recomendaciones_hechas->close();

// Obtener recomendaciones recibidas
$sql_detalle_recomendaciones_recibidas = "SELECT descripcion, estrellas FROM recomendaciones WHERE id_recomendado = ?";
$stmt_detalle_recomendaciones_recibidas = $connection->prepare($sql_detalle_recomendaciones_recibidas);
$stmt_detalle_recomendaciones_recibidas->bind_param("i", $id_usuario);
$stmt_detalle_recomendaciones_recibidas->execute();
$result_recomendaciones_recibidas = $stmt_detalle_recomendaciones_recibidas->get_result();
$recomendaciones_recibidas = $result_recomendaciones_recibidas->fetch_all(MYSQLI_ASSOC);
$stmt_detalle_recomendaciones_recibidas->close();

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
            <div id="container-picture">
                <img src="<?php echo htmlspecialchars($foto_perfil); ?>" alt="perfil" id="profilepicture">
                <div id="stars">
                    <?php
                    $rounded_stars = round($promedio_estrellas_recibidas);
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rounded_stars) {
                            echo '<span class="fa fa-star checked"></span>';
                        } else {
                            echo '<span class="fa fa-star"></span>';
                        }
                    }
                    ?>
                    <p>Promedio de estrellas: <?php echo htmlspecialchars(number_format($promedio_estrellas_recibidas, 2)); ?></p>
                </div>
            </div>
        </div>
        <div class="container-recomendaciones">
            <h1>Mis recomendaciones (<?php echo $num_recomendaciones_hechas; ?>)</h1>
            <?php foreach ($recomendaciones_hechas as $recomendacion) { ?>
                <div class="recomendacion">
                    <p><?php echo htmlspecialchars($recomendacion['descripcion']); ?></p>
                    <p>Estrellas: <?php echo htmlspecialchars($recomendacion['estrellas']); ?></p>
                </div>
            <?php } ?>
        </div>
        <div class="container-recomendaciones">
            <h1>Me han recomendado (<?php echo $num_recomendaciones_recibidas; ?>)</h1>
            <?php foreach ($recomendaciones_recibidas as $recomendacion) { ?>
                <div class="recomendacion">
                    <p><?php echo htmlspecialchars($recomendacion['descripcion']); ?></p>
                    <p>Estrellas: <?php echo htmlspecialchars($recomendacion['estrellas']); ?></p>
                </div>
            <?php } ?>
        </div>
        <div class="container-grafico">
            <h1>Estadísticas</h1>
            <canvas id="graficoRecomendaciones"></canvas>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficoRecomendaciones').getContext('2d');
        const graficoRecomendaciones = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Recomendaciones Hechas', 'Recomendaciones Recibidas'],
                datasets: [{
                    label: 'Cantidad',
                    data: [<?php echo $num_recomendaciones_hechas; ?>, <?php echo $num_recomendaciones_recibidas; ?>],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
