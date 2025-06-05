<?php

$database = 'smartlearndb';
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $database);

if(!$conn){
    header("Location: ../htdocs/SmartLearn/public/paginaErro.php");

    exit();
}

?>