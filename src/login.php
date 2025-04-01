<?php
echo"login<br>";
session_start();
define("ACCESS_ALLOWED", true);
require_once '../config.php';



include ('../database/basedados.sql');


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_POST["email"]) || empty($_POST["senha"]) ){
        echo "<script>alert('Tem de preencher todos os campos necessários para continuar!'); </script>";
        exit;
    }

    $emailInput = (htmlspecialchars(trim($_POST['email'])));
    $password = htmlspecialchars(hash('sha256', $_POST['password']));



    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ? AND Password = ?");
    $stmt -> bind_param("ss", $emailInput, $password);
    $stmt ->execute();
    $result = $stmt->get_result();

    if($result->num_rows>0){
        $user = $result->fetch_assoc();
        if($user['Estado_conta'] === 'Ativo'){
            echo"<script>alert('Bem vindo de volta,".addslashes($user['PNome_user'])."!')</script>";
            $_SESSION['utilizadorOn'] = $user;
            
        }else{
            echo"<script>alert('Conta inativa/eliminada')</script>";
        }

    }
    else{
        echo"<script>alert('Credenciais invalidas!')</script>";
    }


}else{
    echo"Erro de ligação!";
}
?>