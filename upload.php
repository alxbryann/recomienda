<?php
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["profilePic"]["tmp_name"]);
    if($check !== false) {
        $image = $_FILES['profilePic']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        // Conexión a la base de datos
        $db = new mysqli($host, $user, $pass, $dbname);
        if($db->connect_error){
            die("Conexión fallida: " . $db->connect_error);
        }

        // Insertar imagen en la base de datos
        $insert = $db->query("UPDATE usuarios SET imagen_usuario = '$imgContent' WHERE id_usuario = '$id_usuario'");
        if($insert){
            echo "Archivo subido correctamente.";
        }else{
            echo "Ha ocurrido un error al subir el archivo.";
        } 
    }else{
        echo "Por favor, selecciona una imagen para subir.";
    }
}
?>

