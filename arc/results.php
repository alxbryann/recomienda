<?php

function register_user(string $email, string $nombre, string $apellido, string $direccion, string $telefono, int $cod_pais, 
int $id_dpto, int $id_mun, string $password, bool $is_admin = false): bool
{
    $sql = 'INSERT INTO usuarios (email_usuario,nombre_usuario, apellido_usuario, dir_usuario, tel_usuario, cod_pais, id_departamento,id_municipio, password, is_admin)
            VALUES(:email, :nombre, :apellido, :dir, :tel, :cod_pais, :depto, :mun, :password, :is_admin)';

    $statement = db()->prepare($sql);
                

    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':nombre', $nombre, PDO::PARAM_STR);
    $statement->bindValue(':apellido', $apellido, PDO::PARAM_STR);
    $statement->bindValue(':dir', $direccion, PDO::PARAM_STR);
    $statement->bindValue(':tel', $telefono, PDO::PARAM_STR);
    $statement->bindValue(':cod_pais', $cod_pais, PDO::PARAM_INT);
    $statement->bindValue(':depto', $id_dpto, PDO::PARAM_INT);
    $statement->bindValue(':mun', $id_mun, PDO::PARAM_INT);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
    $statement->bindValue(':is_admin', (int)$is_admin, PDO::PARAM_INT);

    return $statement->execute();   

}

function find_user_by_username(string $username)
{
    $sql = 'SELECT email_usuario, password
            FROM usuarios
            WHERE email_usuario=:username';

    $statement = db()->prepare($sql);
    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function is_user_logged_in(): bool
{
    return isset($_SESSION['username']);
}
function require_login(): void
{
    if (!is_user_logged_in()) {
        redirect_to('login.php');
    }
}

function logout(): void
{
    if (is_user_logged_in()) {
        unset($_SESSION['username'], $_SESSION['user_id']);
        session_destroy();
        redirect_to('login.php');
    }
}

function current_user()
{
    if (is_user_logged_in()) {
        return $_SESSION['username'];
    }
    return null;
}

function login(string $username, string $password): bool
{
    $user = find_user_by_username($username);

    // if user found, check the password
    if ($user && password_verify($password, $user['password'])) {

        // prevent session fixation attack
        session_regenerate_id();

        // set username in the session
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id']  = $user['id'];


        return true;
    }

    return false;
}
?>