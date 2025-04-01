<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartLearn</title>
    <link
      rel="stylesheet"
      href="../assets/fontawesome/fontawesome/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/style_registro.css" />
  </head>
  <body>
    <!-- Cabeçalho -->
    <header>
      <div class="container">
        <nav>
          <div class="nav-left">
            <div class="logo">
              <a href="../layout/layout_base.html"><img src="../assets/image/Logo.png" alt="Logo" /></a>
              <span class="brand-name">SmartLearn</span>
            </div>
            
          </div>
          <div class="nav-right">
            <ul class="nav-links">
              <li><a href="#" class="nav-item">Conecte-se</a></li>
              <li><a href="#" class="btn">Inscrever-se</a></li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    
    <!-- Secção Principal (Hero) -->
    <main class="container">

      <section class="section-title">
        <h1>Inscrever-se</h1>
        <p>Inscrever-se e começa a aprender!</p>
      </section>

      <section class="hero container">
        

        <div class="image-box">
          <video width="100%" height="100%" autoplay loop muted>
            <source src="../assets/video/registro.mp4" type="video/mp4">
          </video>
        </div>

        

        <form  class="register-form" action="registo.php" method="POST">
            <label for="">Primeiro nome:</label>
            <input type="text" name="primeiroNome"  placeholder="Primeiro nome" >
            <label for="">Sobrenome:</label>
            <input type="text" name="sobreNome"  placeholder="Sobrenome">
            <label for="">Email:</label>
            <input type="text" name="email"  placeholder="Email" >
            <label for="">Senha:</label>
            <input type="password" name="senha"  placeholder="Senha" >
            <button type="submit">Registrar</button>
            <p>Já tem uma conta? <a href="layout_login.html">Conecte-se</a></p>
        </form>
      </section>

    </main>

    <!-- Rodapé -->
  <footer class="footer">
    <div class="footer-map">
        <!-- Aqui podes adicionar um iframe com o Google Maps 
        <iframe src="https://g.co/kgs/bK5fDXa"
                width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                -->
      </div>
      <div class="container footer-content">
        <p>2025 Copyright by Leando Pinto e Ruben Pinheiro</p>
        <p>Castelo Branco – Rua Esperança – 6200-000</p>
        <p>Email: teste@gmail.com | Telefone: 255 777 222 | Fax: 966 662 222</p>
        <p>Privacy Policy | Terms & Conditions</p>
      </div>
  </footer>

  
  </body>
</html>



<?php

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
    $passwordHash = htmlspecialchars(hash('sha256',$_POST['senha']));

    

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