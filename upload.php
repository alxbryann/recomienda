<?php
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["profileImage"]["tmp_name"]);
    if($check !== false) {
        $image = $_FILES['profileImage']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        $user = "u482925761_admin";
        $pass = "Clavetemporal/2024";
        $host = "82.197.80.210";
        $dbname = "u482925761_recomienda"; 
        $connection = mysqli_connect($host, $user, $pass, $dbname);

        if (!$connection) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        $sql = "UPDATE usuarios SET imagen_usuario = ? WHERE id_usuario = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("si", $imgContent, $id_usuario);
        $stmt->execute();
        $stmt->close();

        echo "Imagen subida correctamente.";
    } else {
        echo "Por favor, sube una imagen válida.";
    }
}
?>
