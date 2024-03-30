<?php

//funcion para modificar el titulo de la pagina de manera dinamica

function view(string $filename, array $data = []): void
{ 
    // create variables from the associative array
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require_once $filename . '.php';
}


//funcion para validar si la peticion es un POST
function is_post_request(): bool 
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

//funcion para validar si la peticion es un GET
function is_get_request(): bool 
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

//funcion usada para mostrar errores de validacion

function error_class(array $errors, string $field): string 
{
    return isset($errors[$field]) ? 'error' : '';
}

//Funcion usada para redireccionar el usuario a una pagina

function redirect_to(string $url): void
{
    header('Location:' . $url);
    exit;
}

//funcion para redireccionar al usuario de regreso a la pagina cuando hay errores de validacion de datos
function redirect_with(string $url, array $items): void
{
    foreach ($items as $key => $value) {
        $_SESSION[$key] = $value;
    }

    redirect_to($url);
}

//funcion para redireccionar al usuario con un mensaje

function redirect_with_message(string $url, string $message, string $type=FLASH_SUCCESS)
{
    flash('flash_' . uniqid(), $message, $type);
    redirect_to($url);

}

//Funcion para capturar datos de la session

function session_flash(...$keys): array
{
    $data = [];
    foreach ($keys as $key) {
        if (isset($_SESSION[$key])) {
            $data[] = $_SESSION[$key];
            unset($_SESSION[$key]);
        } else {
            $data[] = [];
        }
    }
    return $data;
}
?>