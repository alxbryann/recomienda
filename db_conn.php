<?php //db_conn.php
    $host='localhost';
    $data='recomienda';
    $user='root';
    $pass='P@ssw0rd';
    $chrs='utf8mb4';
    $attr="mysql:host=$host;dbname=$data;charset=$chrs";
    $opts=
    [
        PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false,
    ];
?>