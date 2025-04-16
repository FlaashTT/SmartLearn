<?php
include('../segurança.php');
include("../../database/basedados.sql");
$erro = false;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

  $erro = true;
}
$idCurso = $_POST['idCurso'];
if (empty($idCurso)) {
  echo "
    <script>
        alert('Ocorreu um erro de ligação,tente novamente!');
    </script>";
  $erro = true;
}


?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SmartLearn</title>
  <link
    rel="stylesheet"
    href="../../assets/fontawesome/fontawesome/css/all.min.css" />
  <link rel="stylesheet" href="../../assets/css/style_user.css" />
  <link rel="stylesheet" href="../../assets/css/style_curso_capa.css" />
</head>

<body>
  <!-- Cabeçalho -->
  <?php
  include("../../src/views/utils/cabecalho.html");

  $stmt = $conn->prepare("
                SELECT * 
                FROM cursos_adquiridos ca
                INNER JOIN curso c ON ca.Id_curso = c.Id_curso
                WHERE ca.Id_user = ?;
            ");
  $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stmt->close();

  ?>

    <!-- Secção Principal (Hero) -->
    <main class="container">
      <main class="container-c">
        <section class="curso-info">
          <?php
          echo '
        <h1>' . $row['Nome_curso'] . '</h1>
        <p>' . $row['Percentagem_progresso'] . '% Concluído</p>
        <div class="content">
          <div class="imagem">
            <img src="../../assets/image/capa_curso.png" alt="Imagem do Curso" />
          </div>
        ';

          ?>

          <div class="descricao">
            <p class="title-descricao">Descrição</p>
            <p><?php echo $row['Descricao']; ?></p>
          </div>
          </div>
        </section>

        <div class="fases-dicas">
          <section class="fases">
            <?php
            $stmt = $conn->prepare("
              SELECT * 
              FROM fase f
              INNER JOIN curso c ON f.Id_curso = c.Id_curso
              WHERE f.Id_curso = ?;
          ");
            $stmt->bind_param("i", $idCurso);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
              $quantidadeFases = 0;
              while ($fase = $result->fetch_assoc()) {
                $quantidadeFases++;
                if ($quantidadeFases % 4 == 0) {
                  echo '<div class="fase fase-T">Fase ' . $quantidadeFases . '</div>';
                } else {

                  echo '<div class="fase">Fase ' . $quantidadeFases . '</div>';
                }
              }
            }

            ?>
            <!--
              <div class="fase">Fase 1</div>
              <div class="fase">Fase 2</div>
              <div class="fase">Fase 3</div>
              <div class="fase fase-4">Fase 4</div>
              <div class="fase">Fase 5</div>
              <div class="fase">Fase 6</div>
              <div class="fase fase-7">Fase 7</div>
              <div class="fase">Fase 6</div>
              <div class="fase">Fase 6</div>
              <div class="fase">Fase 6</div>
              <div class="fase fase-7">Fase 6</div>
              <div class="fase">Fase 6</div>
              <div class="fase">Fase 6</div>
              <div class="fase fase-7">Fase 6</div>
              <div class="fase">Fase 6</div>
              <div class="fase">Fase 6</div>
            -->

          </section>

          <aside class="dicas">
            <h2>Dicas do curso:</h2>
            <ul>
              <?php
              echo '
            <li><strong>Tempo estimado:</strong> ' . $row['Tempo_estimado'] . '</li>
            <li><strong>Idioma:</strong> ' . $row['Idioma_principal'] . '</li>
            <li><strong>Fases do Curso:</strong> ' . $row['Quantidade_fases'] . '</li>
            <li><strong>Classificação:

            ';
              if ($row['Classificacao'] == 0) {
                echo "Sem classificação";
              } else {
                for ($i = 0; $i < $row['Classificacao']; $i++) {
                  echo ' <i class="fa-regular fa-star"></i>';
                }
              }

              ?>

          </aside>
        </div>

        <footer class="footer-c">
          <button class="avançar">Avançar conteúdo</button>
        </footer>
      </main>
    </main>

    <!-- Rodapé -->
  <?php
  }

  include("../../src/views/utils/rodape.html");

  ?>


</body>

</html>



<?php

if ($erro) {
  echo "
    <script>
        window.history.back();
    </script>
    ";
  exit();
}
?>