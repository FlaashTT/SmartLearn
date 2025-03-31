

<?php
session_start();
require('../database/basedados.h');
require('../');//para colocar o script de segurança


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(empty($_POST["primeiroNome"]) || empty($_POST["sobreNome"]) || empty($_POST["email"]) || empty($_POST["senha"]) ){
        echo "<script>alert('Tem de preencher todos os campos necessários para continuar!'); window.history.back();</script>";
        exit;

    }
}

?>