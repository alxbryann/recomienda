<?php
session_start();
$usuario = $_SESSION['email'];
if($usuario == null || $usuario = ''){
    header("location:login.php");
    die();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea un recomendado!</title>
    <link rel="icon" href="logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="estilosGenerales.css">
</head>

<body>
    <header>
        <div id="tituloImagen">
            <a href="index.php">
                <img src="logo.png" width="80" />
            </a>
        </div>
        <div id="tituloTexto">
            <h1 style="margin-top: -30px;">Creando un recomendado...</h1>
        </div>
    </header>
    <main>
        <div class="container">
            <form action="nuevo_recomendado.php" method="POST">
                <label for="id_recomendado">Id de recomendado:</label>
                <input type="text" id="id_recomendado" name="id_recomendado" required>
                <label for="experto">Experto en:</label>
                <select id="experto" name="experto" required>
                    <option value="televisores">Televisores</option>
                    <option value="neveras">Neveras</option>
                    <option value="lavadoras">Lavadoras</option>
                    <option value="microondas">Microondas</option>
                </select>
                <label for="comentario_recomendado">Comentario sobre el recomendado:</label>
                <input type="text" id="comentario_recomendado" name="comentario_recomendado">
                <label for="estrellas">Agrega estrellas en funcion del servicio:</label>
                <div id=estrellas>
                    <span class="fa fa-star" onclick="calificar(this)" style="cursor: pointer" id=1estrella;"></span>
                    <span class="fa fa-star" onclick="calificar(this)" style="cursor: pointer" id=2estrella;"></span>
                    <span class="fa fa-star" onclick="calificar(this)" style="cursor: pointer" id=3estrella;"></span>
                    <span class="fa fa-star" onclick="calificar(this)" style="cursor: pointer" id=4estrella;"></span>
                    <span class="fa fa-star" onclick="calificar(this)" style="cursor: pointer" id=5estrella;"></span>
                </div>
                <input type="number" id="numero-estrellas" name="numero-estrellas">       
                <button type="submit" class="btn">Enviar</button>
            </form>
        </div>
        <img src="/recomienda_form.jpg" width="100%">
    </main>
    <footer>
        <div id="textoTambien">
            <p>También podría interesarte</p>
        </div>
        <nav>
            <a href="identidad.html">
                <p>Identidad</p>
            </a>
            <a href="contacto.html">
                <p>Contacto</p>
            </a>
        </nav>
    </footer>
    <script>
        function calificar(item){
            contador = item.id[0];
            let nombre = item.id.substring(1);
            for(let i=0;i<5;i++){
                if(i<contador){
                    document.getElementById((i+1)+nombre).style.color = "orange";
                }else{
                    document.getElementById((i+1)+nombre).style.color = "black";
                }
            }    
            document.getElementById("numero-estrellas").value = contador;
        }
    </script>
</body>
</html>
