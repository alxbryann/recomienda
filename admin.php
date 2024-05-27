<?php
require_once 'db_conn.php';
require_once 'connection.php';
require_once 'db.php';

session_start();

if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] != 1) {
    echo "No tienes permiso para acceder a esta página.";
    exit;
}

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int) $e->getCode());
}

if (isset($_POST['eliminar'])) {
    $id_usuario = $_POST['id_usuario'];
    $query = "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'";
    $pdo->exec($query);
}

if (isset($_POST['convertir'])) {
    $id_usuario = $_POST['id_usuario'];
    $query = "UPDATE usuarios SET es_admin = 1 WHERE id_usuario = '$id_usuario'";
    $pdo->exec($query);
}

$query = "SELECT * FROM usuarios";
$result = $pdo->query($query);
$usuarios = $result->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>

<h1>Panel de administrador</h1>

<table>
    <tr>
        <th>Nombre de usuario</th>
        <th>Email</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($usuarios as $usuario) : ?>
    <tr>
        <td><?= $usuario['nombre_usuario'] ?></td>
        <td><?= $usuario['email_usuario'] ?></td>
        <td>
            <form action="admin.php" method="post">
                <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
                <input type="submit" name="eliminar" value="Eliminar">
                <?php if ($usuario['es_admin'] != 1) : ?>
                <input type="submit" name="convertir" value="Convertir en admin">
                <?php endif ?>
            </form>
        </td>
    </tr>
    <?php endforeach ?>
</table>
</html>
