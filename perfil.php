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

// Obtener calificación promedio del usuario
$sql = "SELECT AVG(estrellas) as promedio_estrellas, COUNT(*) as total_recomendaciones FROM recomendaciones WHERE id_recomendado = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$stmt->bind_result($promedio_estrellas, $total_recomendaciones);
$stmt->fetch();
$stmt->close();

// Obtener recomendaciones hechas por el usuario
$sql = "SELECT * FROM recomendaciones WHERE id_usuario = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result_recomendaciones_hechas = $stmt->get_result();
$recomendaciones_hechas = $result_recomendaciones_hechas->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Obtener recomendaciones recibidas por el usuario
$sql = "SELECT * FROM recomendaciones WHERE id_recomendado = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result_recomendaciones_recibidas = $stmt->get_result();
$recomendaciones_recibidas = $result_recomendaciones_recibidas->fetch_all(MYSQLI_ASSOC);
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
                <?php
                if ($total_recomendaciones > 0) {
                    $promedio_estrellas = round($promedio_estrellas);
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $promedio_estrellas) {
                            echo '<span class="fa fa-star checked"></span>';
                        } else {
                            echo '<span class="fa fa-star"></span>';
                        }
                    }
                    echo "<p>Calificación: $promedio_estrellas de 5</p>";
                } else {
                    echo "<p>Aún no te han recomendado, no podemos obtener una calificación de tus servicios.</p>";
                }
                ?>
            </div>
        </div>
        <div class="container-recomendaciones">
            <h1>Mis recomendaciones</h1>
            <ul>
                <?php
                if (count($recomendaciones_hechas) > 0) {
                    foreach ($recomendaciones_hechas as $recomendacion) {
                        echo "<li>{$recomendacion['descripcion']}</li>";
                    }
                } else {
                    echo "<li>No has hecho ninguna recomendación.</li>";
                }
                ?>
            </ul>
        </div>
        <div class="container-recomendaciones">
            <h1>Me han recomendado</h1>
            <ul>
                <?php
                if (count($recomendaciones_recibidas) > 0) {
                    foreach ($recomendaciones_recibidas as $recomendacion) {
                        echo "<li>{$recomendacion['descripcion']}</li>";
                    }
                } else {
                    echo "<li>No has recibido ninguna recomendación.</li>";
                }
                ?>
            </ul>
        </div>
        <div class="container-recomendaciones">
            <h1>Resumen de recomendaciones</h1>
            <canvas id="recomendacionesChart"></canvas>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('recomendacionesChart').getContext('2d');
        const recomendacionesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Hechas', 'Recibidas'],
                datasets: [{
                    label: 'Recomendaciones',
                    data: [<?php echo count($recomendaciones_hechas); ?>, <?php echo count($recomendaciones_recibidas); ?>],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
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