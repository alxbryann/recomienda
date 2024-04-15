<?php
require_once 'db_conn.php';
//city query
if(isset($_POST['id'])){
	try
    { 
        $pdo=new PDO($attr,$user,$pass,$opts);
    }
     catch (PDOException $e)
    {
        throw new PDOException($e->getMessage(),(int)$e->getCode());
     }
    $Query = "SELECT * FROM departamentos WHERE cod_pais=".$_POST['id'];
    $result=$pdo->query($Query);
        echo '<option value="">Seleccione departamento</option>';
        while ($row=$result->fetch(PDO::FETCH_BOTH))
	    {
            echo '<option value="' . $row['id_departamento'] . '">' . $row['departamento'] . '</option>';
	    }

}

//district query

if(isset($_POST['sid'])){
	try
    { 
        $pdo=new PDO($attr,$user,$pass,$opts);
    }
     catch (PDOException $e)
    {
        throw new PDOException($e->getMessage(),(int)$e->getCode());
     }
    $Query = "SELECT * FROM municipios WHERE id_departamento=".$_POST['sid'];
    $result=$pdo->query($Query);
        echo '<option value="">Seleccione municipio</option>';
        while ($row=$result->fetch(PDO::FETCH_BOTH))
	    {
            echo '<option value="' . $row['id_municipio'] . '">' . $row['municipio'] . '</option>';
	    }

}
?>