<?php
session_start();
$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['profile_picture']['tmp_name'];
        $image_content = file_get_contents($image);
        $image_base64 = base64_encode($image_content);

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
        $stmt->bind_param("si", $image_base64, $id_usuario);
        if ($stmt->execute()) {
            header("Location: perfil.php");
        } else {
            echo "Error al subir la imagen.";
        }

        $stmt->close();
        $connection->close();
    } else {
        echo "Error en la carga de la imagen.";
    }
}
?>

