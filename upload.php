<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database";

$connection = mysqli_connect($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){}
  if(isset($_FILES['imagen_usuario']) && $_FILES['imagen_usuario']['error'] == 0){
    $imgData = addslashes(file_get_contents($_FILES['imagen_usuario']['tmp_name']));
    $imageProperties = getimageSize($_FILES['imagen_usuario']['tmp_name']);
    
    $sql = "INSERT INTO profile_images(imageType ,imageData)
    VALUES('{$imageProperties['mime']}', '{$imgData}')";
    
    if ($conn->query($sql) === TRUE) {
      echo "Imagen subida correctamente.";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

$conn->close();
?>

<form method="post" enctype="multipart/form-data">
  <input type="file" name="imagen_usuario" id="imagen_usuario">
  <input type="submit" value="Subir imagen" name="submit">
</form>


