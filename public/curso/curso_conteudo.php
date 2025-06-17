<?php
include("../segurança.php");
include("../../database/basedados.php");

$erro = false;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $erro = true;
}
$idCurso = $_POST['idcurso'];
if (empty($idCurso)) {
    echo "
    <script>
        alert('Ocorreu um erro de ligação,tente novamente!');
    </script>";
    $erro = true;
}
$notas = "";
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartLearn</title>
    <link rel="stylesheet" href="../../assets/fontawesome/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/style_user.css" />
    <link rel="stylesheet" href="../../assets/css/style_curso_conteudo.css" />
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
        $notas = $row['Notas'];
    ?>

        <!-- Secção Principal (Hero) -->
        <main class="container">
            <main class="container-c">
                <section class="curso-info">
                    <?php
                    echo '
                    <h1>' . $row['Nome_curso'] . '</h1>
                    <p>' . $row['Percentagem_progresso'] . '% Concluído</p>
                    <input type="hidden" id="ValorPercentagem" value="'.$row['Percentagem_progresso'].'">
                    ';
                    
                    ?>
                    
                    <div class="content">
                        <?php
                        $selectFases = $conn->prepare("SELECT * FROM fase WHERE Id_curso = ?");
                        $selectFases->bind_param("i", $idCurso);
                        $selectFases->execute();
                        $result = $selectFases->get_result();

                        if ($result->num_rows > 0) {
                            $numeroFaseExibida = 1;
                            while ($row = $result->fetch_assoc()) {
                                if ($numeroFaseExibida === 1) {
                                    echo '<div id="FaseNum_' . $numeroFaseExibida . '" class="scrollable-content">';
                                } else {
                                    echo '<div id="FaseNum_' . $numeroFaseExibida . '" class="scrollable-content" style="display:none">';
                                }
                        ?>

                                <section class="step">
                                    <?php
                                    $selectContentFase = "SELECT * FROM fase WHERE Id_curso = ? AND Num_fase = ?";
                                    $stmt = $conn->prepare($selectContentFase);
                                    $stmt->bind_param("ii", $idCurso, $numeroFaseExibida);
                                    $stmt->execute();
                                    $resultContent = $stmt->get_result();
                                    if ($resultContent->num_rows > 0) {

                                        $row = $resultContent->fetch_assoc();
                                        if ($row['Imagem'] != null) {
                                            echo '
                                                <div class="media">
                                                    <img src="../../assets/conteudosCursos/imagens/' . $row['Imagem'] . '" alt="Imagem do Conteúdo" >
                                                </div>
                                                ';
                                        }
                                    ?>

                                        <!-- Título Principal -->
                                        <?php
                                        echo '
                                        <h2> 
                                        ' . $row['Titulo_fase'] . '
                                        </h2>
                                        <p>
                                           ' . str_replace('.', '.<br>', $row['Conteudo_fase']) . ' 
                                        </p>
                                            ';

                                        if ($row['video'] != null) {
                                            echo '
                                                <h3>Video explicativo</h3>
                                                <div class="media">
                                                    <video controls>
                                                        <source src="../../assets/conteudosCursos/videos/' . $row['video'] . '" type="video/mp4" />
                                                        Seu navegador não suporta o elemento de vídeo.
                                                    </video>
                                                </div>';
                                        }
                                        ?>

                                </section>
                    </div>

        <?php
                                        $numeroFaseExibida++;
                                    } else {
                                        echo "Erro ao aceder esta ao conteudo desta fase";
                                    }
                                }
                            } else {
                                echo "<li>Não há fases cadastradas para este curso.</li>";
                            }
        ?>

        <div class="sidebar">
            <h3>Conteúdo</h3>
            <ul>
                <?php
                $sqlFases = "SELECT * FROM fase WHERE Id_curso = ?";
                $stmt = $conn->prepare($sqlFases);
                $stmt->bind_param("i", $idCurso);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<li onclick="verFase(' . $row['Num_fase'] . ')">Fase ' . $row['Num_fase'] . ': ' . $row['Titulo_fase'] . '</li>';
                    }
                } else {
                    echo "Nenhuma fase encontrada para este curso.";
                }
                ?>
            </ul>
        </div>
        </div>
                </section>

                <div class="notes">
                    <label for="notes">Notas:</label>
                    <textarea id="notes" maxlength="500" placeholder="Escreva suas notas aqui..."><?php echo $notas; ?></textarea>
                    <p id="char-count">0/2500 caracteres</p>
                </div>

                <footer class="footer-c">
                    <button id="btnAvançar" class="avançar" onclick="avançarFase()">Concluir</button>
                </footer>
            </main>
        </main>

    <?php
    } else {
        echo "<p>Você não possui cursos adquiridos.</p>";
    }
    ?>

    <!-- Rodapé -->
    <?php include("../../src/views/utils/rodape.html"); ?>

    <script>
        const textarea = document.getElementById('notes');
        const charCount = document.getElementById('char-count');

        textarea.addEventListener('input', () => {
            charCount.textContent = `${textarea.value.length}/2500 caracteres`;
        });

        textarea.addEventListener('input', () => {
            textarea.style.height = 'auto'; // Reseta a altura
            textarea.style.height = `${textarea.scrollHeight}px`; // Ajusta à altura do conteúdo
        });

        textarea.addEventListener('input', () => {
            const maxWords = 100;
            const words = textarea.value.split(/\s+/).filter(word => word.length > 0);
            if (words.length > maxWords) {
                textarea.value = words.slice(0, maxWords).join(' ');
            }
            charCount.textContent = `${words.length}/${maxWords} palavras`;
        });

       
    </script>
    <script>
        const botao = document.getElementById("btnAvançar")
        botao.setAttribute('onclick', 'novaFuncao()');

         function verFase(NumFase) {
            

            const todasFases = document.querySelectorAll('[id^="FaseNum_"]');

            todasFases.forEach(div => {
                if (div.id === 'FaseNum_' + NumFase) {
                    div.style.display = 'block';
                } else {
                    div.style.display = 'none';
                }
            });
        }
    </script>

</body>

</html>