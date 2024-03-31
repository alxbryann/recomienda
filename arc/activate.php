<?php
require_once 'helpers.php';
require_once 'flash.php';
require_once 'sanitization.php';
require_once 'validation.php';
require_once 'filter.php';
require_once 'db_conn.php';
require_once 'results.php';
require_once 'connection.php';
require_once 'db.php';
require_once 'app.php';



if (is_get_request()) {

    // sanitize the email & activation code
    [$inputs, $errors] = filter($_GET, [
        'email' => 'string | required | email',
        'activation_code' => 'string | required'
    ]);

    if (!$errors) {

        $user = find_unverified_user($inputs['activation_code'], $inputs['email']);
        // if user exists and activate the user successfully
    
        if ($user && activate_user($user['id_usuario'])) {
            redirect_with_message(
                'login.php',
                'You account has been activated successfully. Please login here.'
            );
        }
    }
}

// redirect to the register page in other cases
redirect_with_message(
    'nuevousuario.php',
    'The activation link is not valid, please register again.',
    FLASH_ERROR
);

?>