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

$errors = [];
$inputs = [];

if (is_post_request()) {

    $fields = [
        'email' => 'email | required | email | unique: usuarios, email_usuario',
        'nombre'=>'string',
        'apellido'=>'string',
        'direccion'=>'string',
        'telefono'=>'string',
        'pais'=>'int',
        'departamento'=>'int',
        'municipio'=>'int',    
        'password' => 'string | required | secure',
        'password2' => 'string | required | same: password',
        'agree' => 'string | required'
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

    if (register_user($inputs['email'], $inputs['nombre'], $inputs['apellido'],$inputs['direccion'], $inputs['telefono'],$inputs['pais'],$inputs['departamento'], 
    $inputs['municipio'], $inputs['password'])) {
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

            <h2 style="background-color:#4CAF50; color:white;">Registro nuevo usuario</h2>
            <div>
                <form method="post" action="nuevousuario.php">
                <div>
                    <label for="email" style="left: 60px; top: 90px; position: absolute;">E-mail:</label>
                    <input type="email" name="email" id="email" placeholder="e-mail" style="left: 230px; top: 70px; position: absolute;" value="<?= $inputs['email'] ?? '' ?>"
                        class="<?= error_class($errors, 'email') ?>">
                        <small><?= $errors['email'] ?? '' ?></small>
                    </div>    

                    <label for="NombreUsuario" style="left: 60px; top: 150px; position: absolute;">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Primer nomnbre" style="left: 230px; top: 130px; position: absolute;">
                    <label for="ApellidoUsuario" style="left: 60px; top: 210px; position: absolute;">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" placeholder="Apellido usuario" style="left: 230px; top: 190px; position: absolute;">
                    
                    <div>
                        <label for="password" style="left: 60px; top: 270px; position: absolute;">Contrasena:</label>
                        <input type="password" name="password" id="password" placeholder="contrasena usuario" style="left: 230px; top: 250px; position: absolute;" value="<?= $inputs['password'] ?? '' ?>"
                            class="<?= error_class($errors, 'password') ?>">
                        <small><?= $errors['password'] ?? '' ?></small>
                    </div>
                    
                    <div>
                        <label for="password2" style="left: 60px; top: 330px; position: absolute;">Repetir Contrasena:</label>
                        <input type="password" name="password2" id="password2" placeholder="Repetir Contrasena usuario" style="left: 230px; top: 310px; position: absolute;" value="<?= $inputs['password2'] ?? '' ?>"
                            class="<?= error_class($errors, 'password2') ?>">
                        <small><?= $errors['password2'] ?? '' ?></small>
                    </div>

                      
                    <label for="DirUsuario" style="left: 60px; top: 390px; position: absolute;">Direccion:</label>
                    <input type="text" name="direccion" id="direccion" placeholder="Direccion -" style="left: 230px; top: 370px; position: absolute;">
                    <label for="TelefonoUsuario" style="left: 60px; top: 450px; position: absolute;">Telefono:</label>
                    <input type="text" name="telefono" id="telefono" placeholder="numero de telefono" style="left: 230px; top: 430px; position: absolute;">
                    <label for="pais" style="left: 60px; top: 510px; position: absolute;">Pais:</label>
                    <select id="pais" name="pais" style="left: 230px; top: 490px; position: absolute;">
                        <option value="">Selecciones pais</option>
                        <?php
                            //require_once 'db_conn.php';
                            try
                            { 
                                $pdo=new PDO($attr,$user,$pass,$opts);
                            }
                            catch (PDOException $e)
                            {
                                throw new PDOException($e->getMessage(),(int)$e->getCode());
                            }
                            $query ="SELECT * FROM paises";
                            $result=$pdo->query($query);
                            while ($row=$result->fetch(PDO::FETCH_BOTH))
                            {
                            ?>
                            <option value="<?php echo $row['cod_pais']; ?>"><?php echo $row['nombre_pais']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <label for="Departamento" style="left: 60px; top: 570px; position: absolute;">Departamento:</label>
                    <select id="id_depto" name="departamento" style="left: 230px; top: 550px; position: absolute;"> 
                        <option disabled="" selected="">Seleccione Departamaneto</option>
                    </select>
                    <label for="Municipio" style="left: 60px; top: 630px; position: absolute;">Municipio:</label>
                    <select id="id_mun" name="municipio" style="left: 230px; top: 610px; position: absolute;"> 
                        <option disabled="" selected="">Seleccione municipio</option>
                    </select>

                    <div>
                        <label for="agree" style="left: 230px; top: 690px; position: absolute;">
                            <input type="checkbox" name="agree" id="agree"  value="checked" <?= $inputs['agree'] ?? '' ?> /> 
                            Estoy de acuerdo con los
                            <a href="#" title="term of services" >terminos de servicio</a>
                        </label>
                        <small><?= $errors['agree'] ?? '' ?></small>
                    </div>
                    <br><input type="submit" value="Guardar" style="left: 60px; top: 730px; position: absolute;">
                    <footer style="left: 60px; top: 790px; position: absolute;">Already a member? <a href="login.php">Login here</a></footer> 
                </form>
            </div>
            <script>
	            $(document).ready(function() {
                $("#pais").on('change', function() {
                var countryid = $(this).val();

                $.ajax({
                    method: "POST",
                    url: "consulta.php",
                    data: {
                        id: countryid
                    },
                    datatype: "html",
                    success: function(data) {
                        $("#id_depto").html(data);
                        $("#id_mun").html('<option value="">Seleccione municipio</option');

                        }
                    });
                });


		        //City Selection
		        $("#id_depto").on('change', function() {
                    var stateid = $(this).val();
                $.ajax({
                    method: "POST",
                    url: "consulta.php",
                    data: {
                    sid: stateid
                    },
                    datatype: "html",
                    success: function(data) {
                    $("#id_mun").html(data);

                }

                });
             });
            });
            </script>  
            
    </body>
    </html>