<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SmartLearn</title>
  <link
    rel="stylesheet"
    href="../../assets/fontawesome/fontawesome/css/all.min.css" />
  <link rel="stylesheet" href="../../assets/css/style.css" />
  <link rel="stylesheet" href="../../assets/css/style_registro.css" />
  
  <script src="../../assets/js/registo.js"></script>

</head>

<body>
  <!-- Cabeçalho -->
  <header>
    <div class="container">
      <nav>
        <div class="nav-left"> 
          <div class="logo">
            <a href="../inicio.php"><img src="../../assets/image/Logo.png" alt="Logo" /></a>
            <span class="brand-name">SmartLearn</span>
          </div>

        </div>
        <div class="nav-right">
          <ul class="nav-links">
            <li><a href="login.php" class="nav-item">Conecte-se</a></li>
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
          <source src="../../assets/video/registro.mp4" type="video/mp4">
        </video>
      </div>



      <form class="register-form" action="registo.php" method="POST">
        <label for="">Primeiro nome:</label>
        <input type="text" name="primeiroNome" placeholder="Primeiro nome" required>
        <label for="">Sobrenome:</label>
        <input type="text" name="sobreNome" placeholder="Sobrenome" required>
        <label for="">Email:</label>
        <input type="text" name="email" placeholder="Email" required>
        <label for="">Senha:</label>
        <input type="password" name="senha" id="passwordInput" placeholder="Senha" required>
        <button type="submit" id="buttonSubmit">Registrar</button>
        <p>Já tem uma conta? <a href="login.php">Conecte-se</a></p>
      </form>
    </section>

  </main>

  <!-- Rodapé -->
  <?php
  include("../../src/views/utils/rodape.html");
  ?>


</body>

</html>






<?php
session_start();
include("../../database/basedados.php");
include("../logs.php");
include("../popup.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($_POST["primeiroNome"]) || empty($_POST["sobreNome"]) || empty($_POST["email"]) || empty($_POST["senha"])) {
    mostrarPopUp('Tem de preencher todos os campos necessários para continuar!');
    exit;
  }


  $primeiroNome = htmlspecialchars(strip_tags(trim($_POST['primeiroNome'])), ENT_QUOTES, 'UTF-8');
  $sobreNome = htmlspecialchars(strip_tags(trim($_POST['sobreNome'])), ENT_QUOTES, 'UTF-8');
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $passwordHash = hash('sha256', htmlspecialchars(trim($_POST['senha']), ENT_QUOTES, 'UTF-8'));




  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    mostrarPopUp('O email inserido é invalido!');
    exit;
  }


  //para verificar se o email ja esta em uso
  $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    mostrarPopUp('Este endereço de e-mail ja esta a ser usado');
    exit;
  }



  date_default_timezone_set("Europe/Lisbon");
  $DataAtual = date("Y-m-d ");

  //comando para inserir o novo utilizador na base de dados 
  $stmt = $conn->prepare("INSERT INTO user (PNome_user, SNome_user, Password, Email, Data_criacao) VALUES  (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $primeiroNome, $sobreNome, $passwordHash, $email, $DataAtual);

  if ($stmt->execute()) {

    mostrarPopUp("Conta criada com sucesso. Bem-vindo, " . addslashes($primeiroNome) . "!", null, "login.php");

    $userID = $conn->insert_id;
    criarLogs("Novo Registo", $userID);
  } else {
    mostrarPopUp('Erro ao criar utilizador.Tente mais tarde');
  }

  $stmt->close();
  $conn->close();
}

?>