<?php

$database = 'smartlearndb';
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $database);

if(!$conn){
    die("Erro na ligação com a base de dados: ". mysqli_connect_error());
}

?>