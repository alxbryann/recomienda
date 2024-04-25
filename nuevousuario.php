<?php
session_start();
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

$errors = [];
$inputs = [];

if (is_post_request()) {

    $fields = [
        'email' => 'email | required | email | unique: usuarios, email_usuario',
        'nombre' => 'string',
        'apellido' => 'string',
        'direccion' => 'string',
        'telefono' => 'string',
        'pais' => 'int',
        'departamento' => 'int',
        'municipio' => 'int',
        'password' => 'string | required | secure',
        'password2' => 'string | required | same: password',
        'agree' => 'string | required',
        'activation_code' => 'string',
    ];

    // custom messages
    $messages = [
        'password2' => [
            'required' => 'Please enter the password again',
            'same' => 'The password does not match'
        ],
        'agree' => [
            'required' => 'You need to agree to the term of services to register'
        ]
    ];

    [$inputs, $errors] = filter($_POST, $fields, $messages);

    if ($errors) {
        redirect_with('nuevousuario.php', [
            'inputs' => $inputs,
            'errors' => $errors
        ]);
    }
    $activation_code = generate_activation_code();

    if (
        register_user(
            $inputs['email'],
            $inputs['nombre'],
            $inputs['apellido'],
            $inputs['direccion'],
            $inputs['telefono'],
            $inputs['pais'],
            $inputs['departamento'],
            $inputs['municipio'],
            $inputs['password'],
            $activation_code
        )
    ) {

        send_activation_email($inputs['email'], $activation_code);

        redirect_with_message(
            'login.php',
            'Your account has been created successfully. Please login here.'
        );

    }

} else if (is_get_request()) {
    [$inputs, $errors] = session_flash('inputs', 'errors');
}

?>
<?php view('header', ['title' => 'Nuevo Usuario']) ?>
<link rel="stylesheet" href="estilosGenerales.css">

<div class="register-container">
    <form method="post" action="nuevousuario.php">
        <h2>Modulo de registro</h2>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" placeholder="e-mail" value="<?= $inputs['email'] ?? '' ?>"
            class="<?= error_class($errors, 'email') ?>">
        <small><?= $errors['email'] ?? '' ?></small>


        <label for="NombreUsuario">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Primer nombre">
        <label for="ApellidoUsuario">Apellido:</label>
        <input type="text" name="apellido" id="apellido" placeholder="Apellido usuario">


        <label for="password">Contrasena:</label>
        <input type="password" name="password" id="password" placeholder="contrasena usuario"
            value="<?= $inputs['password'] ?? '' ?>" class="<?= error_class($errors, 'password') ?>">
        <small><?= $errors['password'] ?? '' ?></small>



        <label for="password2">Repetir Contrasena:</label>
        <input type="password" name="password2" id="password2" placeholder="Repetir Contrasena usuario"
            value="<?= $inputs['password2'] ?? '' ?>" class="<?= error_class($errors, 'password2') ?>">
        <small><?= $errors['password2'] ?? '' ?></small>



        <label for="DirUsuario">Direccion:</label>
        <input type="text" name="direccion" id="direccion" placeholder="Direccion -">
        <label for="TelefonoUsuario">Telefono:</label>
        <input type="text" name="telefono" id="telefono" placeholder="numero de telefono">
        <label for="pais">Pais:</label>
        <select id="pais" name="pais">
            <option value="">Selecciones pais</option>
            <?php
            //require_once 'db_conn.php';
            try {
                $pdo = new PDO($attr, $user, $pass, $opts);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int) $e->getCode());
            }
            $query = "SELECT * FROM paises";
            $result = $pdo->query($query);
            while ($row = $result->fetch(PDO::FETCH_BOTH)) {
                ?>
                <option value="<?php echo $row['cod_pais']; ?>"><?php echo $row['nombre_pais']; ?></option>
                <?php
            }
            ?>
        </select>
        <label for="Departamento">Departamento:</label>
        <select id="id_depto" name="departamento">
            <option disabled="" selected="">Seleccione Departamaneto</option>
        </select>
        <label for="Municipio">Municipio:</label>
        <select id="id_mun" name="municipio">
            <option disabled="" selected="">Seleccione municipio</option>
        </select>


        <label for="agree">
            <input type="checkbox" name="agree" id="agree" value="checked" <?= $inputs['agree'] ?? '' ?> />
            Estoy de acuerdo con los
            <a href="#" title="term of services">terminos de servicio</a>
        </label>
        <small><?= $errors['agree'] ?? '' ?></small>

        <input type="submit" value="Guardar">
        <footer>Already a member? <a href="login.php">Login here</a></footer>
    </form>
</div>
<script>
    $(document).ready(function () {
        $("#pais").on('change', function () {
            var countryid = $(this).val();

            $.ajax({
                method: "POST",
                url: "consulta.php",
                data: {
                    id: countryid
                },
                datatype: "html",
                success: function (data) {
                    $("#id_depto").html(data);
                    $("#id_mun").html('<option value="">Seleccione municipio</option');

                }
            });
        });


        //City Selection
        $("#id_depto").on('change', function () {
            var stateid = $(this).val();
            $.ajax({
                method: "POST",
                url: "consulta.php",
                data: {
                    sid: stateid
                },
                datatype: "html",
                success: function (data) {
                    $("#id_mun").html(data);

                }

            });
        });
    });
</script>

</body>

</html>