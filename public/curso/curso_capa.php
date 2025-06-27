<?php
include('../segurança.php');
include("../../database/basedados.php");
require_once("../popup.php");
$erro = false;
//curso_capa.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

  $erro = true;
}
$idCurso = $_POST['idCurso'];

//funçao de aumentar o numero de visitas
$stmt = $conn->prepare("SELECT Num_visitascurso FROM curso WHERE Id_curso = ?");
$stmt->bind_param("i", $idCurso);
$stmt->execute();
$stmt->bind_result($numVisitas);

if ($stmt->fetch()) {
  $stmt->close();

  // Incrementa e faz o update
  $numVisitas += 1;

  $stmtUpdate = $conn->prepare("UPDATE curso SET Num_visitascurso = ? WHERE Id_curso = ?");
  $stmtUpdate->bind_param("ii", $numVisitas, $idCurso);
  $stmtUpdate->execute();
  $stmtUpdate->close();
} else {
  $stmt->close();
  // Curso não encontrado
}

if (empty($idCurso)) {
  echo "
    <script>
        alert('Ocorreu um erro de ligação,tente novamente!');
    </script>";
  $erro = true;
}
$cursoComprado = false;

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
                SELECT * FROM cursos_adquiridos WHERE Id_user = ? AND Id_curso = ?;
            ");
  $stmt->bind_param("ii", $_SESSION['utilizadorOn']['Id_user'], $idCurso);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $cursoComprado = true;

    $stmt->close();
    //se tiver comprado
    $stmt = $conn->prepare("
    SELECT * 
    FROM cursos_adquiridos ca
    INNER JOIN curso c ON ca.Id_curso = c.Id_curso
    INNER JOIN idioma i ON c.Id_idioma = i.Id_idioma
    WHERE ca.Id_user = ? 
      AND c.Id_curso = ? ;
    ");
    $stmt->bind_param("ii", $_SESSION['utilizadorOn']['Id_user'], $idCurso);
  } else {
    $stmt = $conn->prepare("
                SELECT * 
                FROM curso c
                INNER JOIN idioma i ON c.Id_idioma = i.Id_idioma
                WHERE c.Id_curso = ?;
            ");
    $stmt->bind_param("i", $idCurso);
  }



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
            if($row['Progresso'] =="Concluido"){
                echo'
                <section class="curso-info">
                    <section
                        class="curso-info"
                        style="
              display: flex;
              justify-content: space-between;
              align-items: center;
              flex-wrap: wrap;
              gap: 20px;
            ">
                        <h1 style="margin: 0">Introdução à Programação</h1>

                        <div class="certificacao-download" style="text-align: right">
                            <h3 style="margin: 0">Certificação</h3>
                            <p style="margin: 4px 0 8px 0; margin-bottom: 20px">
                                Podes descarregar aqui o teu certificado de conclusão.
                            </p>
                            <a
                                href="gerar_certificado.php"
                                class="btn-download"
                                download
                                style="
                  padding: 10px 20px;
                  background-color: #4caf50;
                  color: white;
                  text-decoration: none;
                  border-radius: 5px;
                ">
                                Transferir Certificado
                                <i class="fas fa-download" style="margin-left: 5px"></i>
                            </a>
                        </div>
                    </section>
                ';
            }
            ?>
          <?php
          echo '<h1>' . $row['Nome_curso'] . '</h1>';
          if ($cursoComprado === true) {
            echo '<p>' . $row['Percentagem_progresso'] . '% Concluído</p>';
          }

          echo '<div class="content">
          <div class="imagem">
          ';
          $sitioImagem = $row['URL_foto_perfil_curso'];
          $caminhoImagem = "../../assets/image/curso/" . $sitioImagem;

          if (!empty($sitioImagem) && file_exists($caminhoImagem)) {
            echo '<img src="../../assets/image/curso/' . $row['URL_foto_perfil_curso'] . '" alt="Imagem nao encontrada" />';
          } else {
            echo '<img src="../../assets/image/curso/capa_curso.png" alt="Erro">';
          }
          echo '
        
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
              $NumFase = 0;
              while ($fase = $result->fetch_assoc()) {
                $NumFase++;
                if ($NumFase % 2 == 0) {
                  echo '<div class="fase fase-T">Fase ' . $NumFase . ': ' . $fase['Titulo_fase'] . '</div>';
                } else {

                  echo '<div class="fase">Fase ' . $NumFase . ': ' . $fase['Titulo_fase'] . '</div>';
                }
              }
            } else {
              echo "Não foi possovel encontrar nenhuma fase disponivel!";
            }

            ?>
          </section>

          <aside class="dicas">
            <h2>Dicas do curso:</h2>
            <ul>
              <?php
              $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM fase WHERE Id_curso = ?");
              $stmt->bind_param("i", $idCurso);
              $stmt->execute();
              $result = $stmt->get_result();
              $totalFase = $result->fetch_assoc();

              $quantidadeFase = $totalFase['total'];
              echo '
            <li><strong>Tempo estimado:</strong> ' . $row['Tempo_estimado'] . '</li>
            <li><strong>Idioma:</strong> ' . $row['Nome_idioma'] . '</li>
            <li><strong>Fases do Curso:</strong> ' . $quantidadeFase . '</li>
            <li><strong>Classificação:

            ';
              if ($row['Classificacao'] == 0) {
                echo "Sem classificação";
              } else {
                for ($i = 0; $i < $row['Classificacao']; $i++) {
                  echo ' <i class="fas fa-star" style="color: gold;"></i>';
                }
              }
              echo '</li>
              <li><strong>Preço:</strong>' . $row["Preco"] . '€</li>';
              ?>

          </aside>
        </div>
        <?php
        $semFases = false;
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM fase WHERE Id_curso = ?");
        $stmt->bind_param("i", $idCurso);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalFase = $result->fetch_assoc();

        $quantidadeFase = $totalFase['total'];
        if ($quantidadeFase == 0) {
          $semFases = true;
        }
        if ($cursoComprado === true) {
          echo '
            <footer class="footer-c">
            <form action="curso_conteudo.php" method="POST">
              <button name="idcurso" value=" ' . $idCurso . '" class="avançar"' . ($semFases ? 'disabled style="background-color: #ccc; cursor: not-allowed;"' : '') . '>
                Avançar conteúdo
              </button>
            </form>
          </footer>
          ';
        } else {
          echo '
            <div class="botoes-curso">
              <form action="../carrinho/adicionarAocarrinho.php" method="POST">
                <button name="IdCurso" value="' . $idCurso . '" class="botao-acao">
                  Adicionar ao carrinho!
                </button>
              </form>

              <form action="../perfil/adicionarFav.php" method="POST">
                <button name="idFav" value="' . $idCurso . '" class="botao-acao">
                  Adicionar aos favoritos!
                </button>
              </form>
            </div>
          ';
        }


        ?>

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
  mostrarPopUp("ERRO");

  exit();
}
?>