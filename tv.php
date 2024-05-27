<?php
session_start();

// Datos del servidor
$user = "u482925761_admin";
$pass = "Clavetemporal/2024";
$host = "82.197.80.210";

// Conexión a la base de datos
$connection = new mysqli($host, $user, $pass, "u482925761_recomienda");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Eliminación de una recomendación
if (isset($_POST['eliminar'])) {
    $id_recomendacion = intval($_POST['id_recomendacion']);
    $stmt = $connection->prepare("DELETE FROM recomendaciones WHERE id_recomendacion = ?");
    $stmt->bind_param("i", $id_recomendacion);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recomendados para televisores</title>
    <link rel="icon" href="logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilosEspecialidades.css" />
</head>

<body>
    <header>
        <div id="tituloImagen">
            <a href="index.html">
                <img src="logo.png" width="80" />
            </a>
        </div>
        <div id="tituloTexto">
            <h1>Nuestros recomendados para televisores</h1>
        </div>
    </header>
    <div class="container">
        <div id="reseñas" class="mt-4">
            <?php
            $especialidad = 1;
            $stmt = $connection->prepare("SELECT * FROM recomendaciones WHERE especialidad = ?");
            $stmt->bind_param("i", $especialidad);
            $stmt->execute();
            $resultado = $stmt->get_result();

            while($row = $resultado->fetch_assoc()){
                $id_recomendacion = $row['id_recomendacion'];
                $id_usuario = $row['id_usuario'];
                $id_recomendado = $row['id_recomendado'];
                $estrellas = $row['estrellas'];
                $comentario = htmlspecialchars($row['comentario'], ENT_QUOTES, 'UTF-8');

                $stmt_usuarios = $connection->prepare("SELECT nombre_usuario FROM usuarios WHERE id_usuario = ?");
                $stmt_usuarios->bind_param("i", $id_recomendado);
                $stmt_usuarios->execute();
                $resultado_usuarios = $stmt_usuarios->get_result();
                $nombre_recomendado = $resultado_usuarios->fetch_assoc()['nombre_usuario'];

                $stmt_usuarios2 = $connection->prepare("SELECT nombre_usuario FROM usuarios WHERE id_usuario = ?");
                $stmt_usuarios2->bind_param("i", $id_usuario);
                $stmt_usuarios2->execute();
                $resultado_usuarios2 = $stmt_usuarios2->get_result();
                $nombre_usuario = $resultado_usuarios2->fetch_assoc()['nombre_usuario'];
                ?>
                <div class="card" id="reseñas">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($nombre_recomendado, ENT_QUOTES, 'UTF-8'); ?></h5>
                        <p class="card-text" id="<?php echo $id_recomendacion; ?>" style="display: none;"><?php echo htmlspecialchars("$nombre_usuario dice: $comentario", ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="d-flex justify-content-between">
                            <small>Calificación: <?php echo htmlspecialchars($estrellas, ENT_QUOTES, 'UTF-8'); ?> estrellas</small>
                            <small class="text-muted">Fecha: 2024-03-30</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-secondary" onclick="verReseñasDetalles('<?php echo $id_recomendacion; ?>')">Ver reseñas</button>
                        <a href="perfil.php?id=<?php echo $id_recomendado; ?>" class="btn btn-primary">Ver perfil</a>
                        <?php if (isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1): // Si el usuario es administrador ?>
                        <form action="index.php" method="post" style="display: inline;">
                            <input type="hidden" name="id_recomendacion" value="<?php echo $id_recomendacion; ?>">
                            <input type="submit" name="eliminar" value="Eliminar" class="btn btn-danger">
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            }
            $stmt->close();
            ?>
        </div>
    </div>
    <footer>
        <div id="textoTambien">
            <p>También podría interesarte</p>
        </div>
        <nav>
            <a href="identidad.html">
                <p>Identidad</p>
            </a>
            <a href="contacto.html">
                <p>Contacto</p>
            </a>
        </nav>
    </footer>
</body>
<script>
    function verReseñasDetalles(id) {
        var reseñasTexto = document.getElementById(id);
        if (reseñasTexto.style.display === 'none') {
            reseñasTexto.style.display = 'block';
        } else {
            reseñasTexto.style.display = 'none';
        }
    }
</script>

</html>
