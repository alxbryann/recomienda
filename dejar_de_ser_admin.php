<?php
session_start();
require 'conexion.php'; 

if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] != 1) {
    header('Location: index.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

$sql = "UPDATE usuarios SET es_admin = 0 WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_usuario);

if ($stmt->execute()) {
    $_SESSION['es_admin'] = 0;
    echo "Has dejado de ser administrador.";
} else {
    echo "Hubo un error al intentar dejar de ser administrador.";
}

$stmt->close();
$conn->close();
?>
