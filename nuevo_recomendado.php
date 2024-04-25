<?php

session_start();
//Datos del servidor
$user = "u482925761_admin";
$pass = "Clavetemporal/2024";
$host = "82.197.80.210";

//Conexion a la base de datos
$connection = mysqli_connect($host, $user, $pass);

//Llamamos al input del formulario
$id_usuario = 2;
$id_recomendado = $_POST["id_recomendado"];
$estrellas = intval($_POST["numero-estrellas"]);
$especialidad = $_POST["experto"];
$especialidad_recomendado;
// Switch statement
switch ($especialidad) {
    case "televisores":
        $especialidad_recomendado = 1;
        break;
    case "neveras":
        $especialidad_recomendado = 2;
        break;
    case "lavadoras":
        $especialidad_recomendado = 3;
        break;
    case "microondas":
        $especialidad_recomendado = 4;
        break;
}
$comentario = $_POST["comentario_recomendado"];

//Nombre de la base de datos
$datab = "u482925761_recomienda";
//Seleccionamos la base de datos
$db = mysqli_select_db($connection,$datab);




//Diseñamos la instruccion sql
$instruccion_sql = "insert into recomendaciones(id_usuario, id_recomendado, estrellas, especialidad, comentario) values ('$id_usuario', '$id_recomendado', '$estrellas', '$especialidad_recomendado', '$comentario')";
$resultado = mysqli_query($connection, $instruccion_sql);


if($resultado){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="estilosGenerales.css">
        <link rel="shortcut icon" href="/logo.png" type="image/x-icon">
        <title>Agregando recomendacion...</title>
        <link rel="icon" href="logo.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    </head>
    <body>
        <div class="confirmation-container">
            <h1>Recomendacion agregada con exito</h1>
            <h2>Seras redirigido al inicio en 5 segundos</h2>
            <meta http-equiv="refresh" content="5;url=index.php">
        </div>
    </body>
    </html>
    <?php
}else{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="estilosGenerales.css">
        <link rel="shortcut icon" href="/logo.png" type="image/x-icon">
        <title>Agregando recomendacion...</title>
        <link rel="icon" href="logo.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    </head>
    <body>
        <div class="confirmation-container">
            <h1>Recomendacion fallida</h1>
            <h2>Seras redirigido al inicio en 5 segundos</h2>
            <meta http-equiv="refresh" content="5;url=index.php">
        </div>
    </body>
    </html>
<?php
}