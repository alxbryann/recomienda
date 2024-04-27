<!DOCTYPE html>
<html>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
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
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

$inputs = [];
$errors = [];

if (is_post_request()) {
    $fields = [
        'username' => 'string | required',    
        'password' => 'string | required',
    ];

    [$inputs, $errors] = filter($_POST,$fields);

    if ($errors) {
        redirect_with('login.php', ['errors' => $errors, 'inputs' => $inputs]);
    }

    // if login fails
    if (!login($inputs['username'], $inputs['password'])) {

        $errors['login'] = 'Invalid username or password';

        redirect_with('login.php', [
            'errors' => $errors,
            'inputs' => $inputs
        ]);
    }
    // login successfully
    session_start();
    try {
        $pdo = new PDO($attr, $user, $pass, $opts);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $query = "SELECT * FROM usuarios WHERE email_usuario = '$usuario'";
    $result = $pdo->query($query);
    while ($row = $result->fetch(PDO::FETCH_BOTH)) {
        $id_usuario = strval($row["id_usuario"]);
    
    }
    $_SESSION['email'] = $usuario;
    $_SESSION['id_usuario'] = $id_usuario;
    echo $_SESSION['email'];
    echo $_SESSION['id_usuario'];
    redirect_to('index.php');

} else if (is_get_request()) {
    [$errors, $inputs] = session_flash('errors', 'inputs');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.png">
    <title>Inicio de sesion</title>
    <link rel="stylesheet" href="estilosRegistro.css">
</head>

<body>
    <h2>Inicio de Sesion</h2>
    <div class="register-container">
        <?php if (isset($errors['login'])) : ?>
        <div class="alert alert-error">
            <?= $errors['login'] ?>
        </div>
        <?php endif ?>

        <form action="login.php" method="post">
            <label for="username"><b>Email-usuario:</b></label>
            <input type="text" name="username" id="username" value="<?= $inputs['username'] ?? '' ?>">
            <small>
                <?= $errors['username'] ?? '' ?>
            </small>
            <label for="password"><b>Contrasena:</b></label>
            <input type="password" name="password" id="password">
            <small>
                <?= $errors['password'] ?? '' ?>
            </small>
            <br>
            <input type="submit" value="Enviar">
        </form>
    </div>
    <footer>
        <a href="nuevousuario.php">Registrate aqui</a>
        <a href="olvidarcontraseña.html">¿Olvidaste la contraseña?</a>
    </footer>
</body>

</html>