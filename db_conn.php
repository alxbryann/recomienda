<?php //db_conn.php
    $data = "u482925761_recomienda";;
    $user = "u482925761_admin";
    $pass = "Clavetemporal/2024";
    $host = "82.197.80.210";
    $chrs='utf8mb4';
    $attr="mysql:host=$host;dbname=$data;charset=$chrs";
    $opts=
    [
        PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false,
    ];
?>