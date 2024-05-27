<?php
$target_dir = "uploads/"; // Directorio donde se guardarán las imágenes
$target_file = $target_dir . basename($_FILES["profilePicture"]["name"]); // Ruta completa del archivo

// Comprueba si el archivo ya existe
if (file_exists($target_file)) {
    echo "Lo siento, el archivo ya existe.";
    exit;
}

// Comprueba el tamaño del archivo (en este caso, el límite es 500KB)
if ($_FILES["profilePicture"]["size"] > 500000) {
    echo "Lo siento, tu archivo es demasiado grande.";
    exit;
}

// Permite ciertos formatos de archivo
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Lo siento, solo se permiten archivos JPG, JPEG y PNG.";
    exit;
}

// Intenta subir el archivo
if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
    echo "El archivo ". htmlspecialchars(basename( $_FILES["profilePicture"]["name"])). " ha sido subido.";
} else {
    echo "Lo siento, hubo un error al subir tu archivo.";
}
?>
