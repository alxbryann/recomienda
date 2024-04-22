<?php
const APP_URL = 'https://recomienda.site';
const SENDER_EMAIL_ADDRESS = 'jramoscol@gmail.com';

function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}

function send_activation_email(string $email, string $activation_code): void
{
    // create the activation link
    $activation_link = APP_URL . "/activate.php?email=$email&activation_code=$activation_code";

    // set email subject & body
    $subject = 'Por favor active su cuenta';
    $message = <<<MESSAGE
            Hola, estas a punto de poder usar tu cuenta de recomienda.com
            por favor haz click en el siguiente enlace para activar tu cuenta:
            $activation_link
            MESSAGE;
    // email header
    $header = "From:" . SENDER_EMAIL_ADDRESS;

    // send the email
    mail($email, $subject, nl2br($message), $header);

}

function delete_user_by_id(string $id, int $active = 0)
{
    $sql = 'DELETE FROM usuarios
            WHERE email_usuario =:id and active=:active';

    $statement = db()->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_STR);
    $statement->bindValue(':active', $active, PDO::PARAM_INT);

    return $statement->execute();
}


function find_unverified_user(string $activation_code, string $email)
{

    $sql = 'SELECT id_usuario, email_usuario, activation_code, activation_expiry < now() as expired
            FROM usuarios
            WHERE active = 0 AND email_usuario=:email';

    $statement = db()->prepare($sql);

    $statement->bindValue(':email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // already expired, delete the in active user with expired activation code
        if ((int)$user['expired'] === 1) {
            delete_user_by_id($user['id']);
            return null;
        }
        // verify the password
        if (password_verify($activation_code, $user['activation_code'])) {
            return $user;
        }
    }

    return null;
}

function activate_user(int $user_id): bool
{
    $sql = 'UPDATE usuarios
            SET active = 1,
                activation_at = CURRENT_TIMESTAMP
            WHERE id_usuario=:id';

    $statement = db()->prepare($sql);
    $statement->bindValue(':id', $user_id, PDO::PARAM_INT);

    return $statement->execute();
}

?>