<?php

//Datos del servidor
$user = "u482925761_admin";
$pass = "Clavetemporal/2024";
$host = "82.197.80.210";

//Conexion a la base de datos
$connection = mysqli_connect($host, $user, $pass);

//Llamamos al input del formulario
$id_usuario = 1;
$id_recomendado = $_POST["id_recomendado"];
$estrellas = 5;
$especialidad = 1;
$comentario = $_POST["comentario_recomendado"];

//Nombre de la base de datos
$datab = "u482925761_recomienda";
//Seleccionamos la base de datos
$db = mysqli_select_db($connection,$datab);
echo $nombre;
//Diseñamos la instruccion sql
$instruccion_sql = "insert into recomendaciones(nombre, email, mensaje) values ('$nombre', '$email', '$mensaje')";
$resultado = mysqli_query($connection, $instruccion_sql);
?>



