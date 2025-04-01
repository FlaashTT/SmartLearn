<?php

include "../src/views/layout/layout_registro.html";
echo "registo<br>";
session_start();
define("ACCESS_ALLOWED", true);
require_once '../config.php';
include ('../database/basedados.sql');


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_POST["primeiroNome"]) || empty($_POST["sobreNome"]) || empty($_POST["email"]) || empty($_POST["senha"]) ){
        echo "<script>alert('Tem de preencher todos os campos necessários para continuar!'); </script>";
        exit;
    }


    $primeiroNome = htmlspecialchars(trim($_POST['primeiroNome']));
    $sobreNome = htmlspecialchars(trim($_POST['sobreNome']));
    $email = htmlspecialchars(trim($_POST['email']));
    $passwordHash = htmlspecialchars(hash('sha256',$_POST['password']));

    

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<script>alert('O email inserido é invalido!');  </script>";
        exit; 
    }
    

    //para verificar se o email ja esta em uso
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt -> bind_param("s", $email);
    $stmt -> execute();
    $result = $stmt -> get_result();

    if($result -> num_rows > 0) {
        echo "<script>alert('Este endereço de e-mail ja esta a ser usado');  </script>";
        exit;
    }

    

    date_default_timezone_set("Europe/Lisbon");
    $DataAtual = date("Y-m-d ");

    //comando para inserir o novo utilizador na base de dados 
    $stmt = $conn -> prepare ("INSERT INTO user (PNome_user, SNome_user, Password, Email, Data_criacao) VALUES  (?, ?, ?, ?, ?)");
    $stmt -> bind_param("sssss", $primeiroNome, $sobreNome, $passwordHash, $email, $DataAtual);
    
    if($stmt -> execute()){
        //para inserir logs no sistema
        $userID = $conn->insert_id;
        include("../src/logs.php");
        criarLogs("Novo Registo",$userID);
        echo "<script>alert('Conta criada com sucesso. Bem-vindo, " . addslashes($primeiroNome) . "!');</script>";
    }else{
        echo "<script>alert('Erro ao criar utilizador.Tente mais tarde') </script>";
    }

    $stmt -> close();
    $conn -> close();


}else{
    echo"Erro de ligação! ";
}

?>