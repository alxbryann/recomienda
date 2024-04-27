<?php
    session_start();
    $usuario = $_SESSION['email'];
    $id_usuario = $_SESSION['id_usuario'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recomienda!</title>
    <link rel="icon" href="logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilosLanding.css" />
</head>

<body>
    <div class="landing">
        <div class="izquierda">
            <div id="primerTexto">
                <p>Recomienda</p>
            </div>
            <div id="segundoTexto">
                <p>¿Estas buscando un recomendado?</p>
            </div>
            <div id="tercerTexto">
                <p>Con esta pagina web, puedes encontrar
                    al recomendado perfecto para la labor
                    que necesites
                </p>
            </div>
            <div id="botonPrin">
                <a class="btn" href="#tituloImagen">ir</a>
            </div>
        </div>
        <div class="derecha">
            <img class="imagen" src="ar1.webp" alt="">
        </div>
    </div>
    <header>
        <div id="tituloImagen">
            <a href="index.php">
                <img src="logo.png" width="80" />
            </a>
        </div>
        <div id="tituloTexto">
            <h1>¡Bienvenido a recomienda!</h1>
        </div>
        <div id="sesion">
            <?php
                if (isset($usuario)) {
                    echo '<a href="/CAMBIAR">Bienvenido, '. $usuario .'</a>';
                } else {
                    echo '<a href="login.php">Iniciar sesión</a>';
                    echo '<a href="nuevousuario.php">Registrarse</a>';
                }            
            ?>
        </div>
    </header>
    <div id="pregunta">
        <div id="textoPregunta">
            <p>Selecciona el tipo de trabajo que necesitas</p>
        </div>
    </div>
    <div class="tarjetas">
        <div class="card" style="width: 25%;" id="tar1">
            <img src="mo.png" alt="" />
            <div class="card-body">
                <h1>Microondas</h1>
                <div id="boton">
                    <a class="btn" href="microondas.php">ir</a>
                </div>
            </div>
        </div>
        <div class="card" style="width: 25%;" id="tar2">
            <img src="ne.png" alt="" />
            <div class="card-body">
                <h1>Neveras</h1>
                <div id="boton">
                    <a class="btn" href="neveras.php">ir</a>
                </div>
            </div>
        </div>
        <div class="card" style="width: 25%;" id="tar3">
            <img src="la.jpg" alt="" />
            <div class="card-body">
                <h1>Lavadoras</h1>
                <div id="boton">
                    <a class="btn" href="lavadoras.php">ir</a>
                </div>
            </div>
        </div>
        <div class="card" style="width: 25%;" id="tar4">
            <img src="tv.png" />
            <div class="card-body">
                <h1>Televisores</h1>
                <div id="boton">
                    <a class="btn" href="tv.php">ir</a>
                </div>
            </div>
        </div>
    </div>
</body>
<div class="recomendar">
    <div class="izquierda">
        <div id="primerTexto">
            <p>Recomienda</p>
        </div>
        <div id="segundoTexto">
            <p>¿Deseas recomendar a alguien?</p>
        </div>
        <div id="tercerTexto">
            <p>Sigue este enlace, y llena el formulario para agregar tu recomendado a nuestra pagina web</p>
        </div>
        <div id="botonPrin">
            <a class="btn" href="formulario_de_recomendacion.php">ir</a>
        </div>
    </div>
    <div class="derecha">
        <img class="imagen" src="recomendando.jpg" alt="">
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>


</html>