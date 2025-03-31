

<?php
session_start();
require('../database/basedados.h');
require('../');//para colocar o script de segurança


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(empty($_POST["primeiroNome"]) || empty($_POST["sobreNome"]) || empty($_POST["email"]) || empty($_POST["senha"]) ){
        echo "<script>alert('Tem de preencher todos os campos necessários para continuar!'); window.history.back();</script>";
        exit;
    }

    $primeiroNome = trim($_POST['']);
    $sobreNome = trim($_POST['']);
    $email = trim($_POST['']);
    $password = ($_POST['']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<script>alert('O email inserido é invalido!'); window.history.back(); </script>";
        exit; 
    }

    $passwordHash = hash('sha256', $password);

    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt -> bind_param("s", $email);
    $stmt -> execute();
    $result = $stmt -> get_result();

    if($result -> num_rows > 0) {
        echo "<script>alert('Este endereço de e-mail ja esta a ser usado'); window.history.back(); </script>";
        exit;
    }


}

?>