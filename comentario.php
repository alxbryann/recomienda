<?php

//Datos del servidor
$user = "u482925761_admin";
$pass = "Clavetemporal/2024";
$host = "82.197.80.210";

//Conexion a la base de datos
$connection = mysqli_connect($host, $user, $pass);

//Llamamos al input del formulario
$nombre = $_POST["nombre"];
$email = $_POST["email"];
$mensaje = $_POST["mensaje"];

//Verificamos conexion a bases de datos

if(!$connection){
    echo "No se pudo conectar al servidor";
}
else{
    echo "<b><h3>Conectado mi papacho</h3></b>";
}
//Nombre de la base de datos
$datab = "recomienda";
//Seleccionamos la base de datos
$db = mysqli_select_db($connection,$datab);

if(!$db){
    echo "No se ha podido encontrar la tabla"; 
}
else{
    echo "<h3>Tabla seleccionada</h3>";
}
echo $nombre;
//Diseñamos la instruccion sql
$instruccion_sql = "insert into comentarios(nombre, email, mensaje) values ('$nombre', '$email', '$mensaje')";
$resultado = mysqli_query($connection, $instruccion_sql);
?>



