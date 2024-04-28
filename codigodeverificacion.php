<?php

require_once 'db.php'; 

function find_user_by_email(string $email)
{
    $sql = 'SELECT * FROM usuarios WHERE email_usuario = :email';
    $statement = db()->prepare($sql);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function generate_verification_code(): string
{
    return strval(rand(100000, 999999));
}

function save_verification_code(int $user_id, string $verification_code): bool
{
    $sql = 'UPDATE usuarios SET verification_code = :verification_code WHERE id_usuario = :user_id';
    $statement = db()->prepare($sql);
    $statement->bindValue(':verification_code', $verification_code, PDO::PARAM_STR);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    return $statement->execute();
}

function send_verification_code(string $email, string $verification_code): bool
{
    $subject = 'Código de verificación';
    $message = "Tu código de verificación es: $verification_code";
    $headers = 'From: noreply@yourwebsite.com' . "\r\n" .
               'Reply-To: noreply@yourwebsite.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    return mail($email, $subject, $message, $headers);
}
function verify_code(string $code): bool
{
    // Asegúrate de que el correo electrónico del usuario está almacenado en la sesión
    if (!isset($_SESSION['email'])) {
        return false;
    }

    $email = $_SESSION['email'];
    $user = find_user_by_email($email);
    if ($user && $user['verification_code'] === $code) {
        // El código es correcto, puedes permitir al usuario restablecer su contraseña
        return true;
    }
    return false;
}

?>
