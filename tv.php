<?php
session_start();
$user = "u482925761_admin";
$pass = "Clavetemporal/2024";
$host = "82.197.82.18";

$connection = mysqli_connect($host, $user, $pass, "u482925761_recomienda");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['eliminar']) && isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1) {
    $id_recomendacion = $_POST['id_recomendacion'];
    $query = "DELETE FROM recomendaciones WHERE id_recomendacion = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id_recomendacion);
    $stmt->execute();
    $stmt->close();
    header("Location: tv.php");
    exit();
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
                $instruccion_sql = "select * from recomendaciones where especialidad = 1";
                $resultado = mysqli_query($connection, $instruccion_sql);
                if($resultado){
                    while($row = $resultado->fetch_array()){
                        $id_recomendacion = $row['id_recomendacion'];
                        $id_usuario = $row['id_usuario'];
                        $id_recomendado = $row['id_recomendado'];
                        $estrellas = $row['estrellas'];
                        $especialidad = $row['especialidad'];
                        $comentario = $row['comentario'];
                        
                        $instruccion_sql_usuarios = "SELECT nombre_usuario FROM usuarios WHERE id_usuario = $id_recomendado";
                        $resultado_usuarios = mysqli_query($connection, $instruccion_sql_usuarios);
                        if($resultado_usuarios){
                            $row_usuarios = $resultado_usuarios->fetch_array();
                            $nombre_recomendado = $row_usuarios['nombre_usuario'];
                        }
                        
                        $instruccion_sql_usuarios2 = "SELECT nombre_usuario FROM usuarios WHERE id_usuario = $id_usuario";
                        $resultado_usuarios2 = mysqli_query($connection, $instruccion_sql_usuarios2);
                        if($resultado_usuarios2){
                            $row_usuarios2 = $resultado_usuarios2->fetch_array();
                            $nombre_usuario = $row_usuarios2['nombre_usuario'];
                        }
                        ?>
                        <div class="card" id="reseñas">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $nombre_recomendado ?></h5>
                                <p class="card-text" id="<?php echo $id_recomendacion ?>" style="display: none;"><?php echo "$nombre_usuario dice: $comentario" ?></p>
                                <div class="d-flex justify-content-between">
                                    <small>Calificación: <?php echo $estrellas ?> estrellas</small>
                                    <small class="text-muted">Fecha: 2024-03-30</small>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-secondary" onclick="verReseñasDetalles('<?php echo $id_recomendacion ?>')">Ver reseñas</button>
                                <a href="perfil.php?id=<?php echo $id_recomendado; ?>" class="btn btn-primary">Ver perfil</a>
                                <?php if (isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1) : ?>
                                <form action="tv.php" method="post" style="display: inline;">
                                    <input type="hidden" name="id_recomendacion" value="<?php echo $id_recomendacion; ?>">
                                    <input type="submit" name="eliminar" value="Eliminar" class="btn btn-danger">
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "No se encontraron recomendaciones.";
                }
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
    