<?php

$database = 'smartlearndb';
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';

mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $database);

if(!$conn){
    header("Location: ../public/paginaErro.php");
    exit();
}

?>