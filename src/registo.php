

<?php
echo "ola";
session_start();
define("ACCESS_ALLOWED", true);
require_once '../config.php';



include ('../database/basedados.sql');
//require('../');//para colocar o script de segurança


//if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $primeiroNome = "Ruben";
    $sobreNome = "Bras";
    $email = "rubenbras@gmail.com";
    $password ="teste123";

    /*if(empty($_POST["primeiroNome"]) || empty($_POST["sobreNome"]) || empty($_POST["email"]) || empty($_POST["senha"]) ){
        echo "<script>alert('Tem de preencher todos os campos necessários para continuar!'); window.history.back();</script>";
        exit;
    }*/
/*
    $primeiroNome = htmlspecialchars(trim($_POST['primeiroNome']));
    $sobreNome = htmlspecialchars(trim($_POST['sobreNome']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = ($_POST['']);
*/

    

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

    //comando para inserir o novo utilizador na base de dados 
    $stmt = $conn -> prepare ("INSERT INTO user (PNome_user, SNome_user, Password, Email) VALUES  (?, ?, ?, ?)");
    $stmt -> bind_param("ssss", $primeiroNome, $sobreNome, $passwordHash, $email);
    
    if($stmt -> execute()){
        $userID = $conn -> insert_id;
        echo"$userID";

        include("../logs.php");
        criarLogs("Novo Registo",$userID);

    }


//}

?>