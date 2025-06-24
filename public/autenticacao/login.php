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
  <link rel="stylesheet" href="../../assets/css/style_login.css" />
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
            <li><a href="#" class="nav-item">Conecte-se</a></li>
            <li><a href="../autenticacao/registo.php" class="btn">Inscrever-se</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <!-- Secção Principal (Hero) -->
  <main class="container">

    <section class="section-title">
      <h1>Conecte-se</h1>
      <p>Forneça suas credenciais de login válidas!</p>
    </section>

    <section class="hero container">


      <div class="image-box">
        <video width="100%" height="100%" autoplay loop muted>
          <source src="../../assets/video/Login.mp4" type="video/mp4">
        </video>
      </div>



      <form class="register-form" action="login.php" method="POST">
        <label for="">Email:</label>
        <input type="text" name="email" placeholder="Email" required>
        <label for="">Senha:</label>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
        <p>Não tem conta? <a href="../autenticacao/registo.php ">Registe-se agora!</a></p>
      </form>
    </section>

  </main>
 


</body>

</html>



<?php
session_start();
include('../../database/basedados.php');
include("../popup.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($_POST["email"]) || empty($_POST["senha"])) {
    mostrarPopUp('Tem de preencher todos os campos necessários para continuar!');
    exit;
  }

  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $password = hash('sha256', $_POST['senha']);



  $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ? AND Password = ?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($user['Estado_conta'] === 'Ativo') {

      $_SESSION['utilizadorOn'] = $user;
      mostrarPopUp("Bem-vindo de volta, " . addslashes($user['PNome_user']) . "!", null, "../inicio.php");

      exit;
    } else {
      mostrarPopUp('Esta conta encontra-se inativa ou eliminada');
    }
  } else {
    mostrarPopUp('Credenciais invalidas!');
  }
}
?>