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
$numeroFaseExibida = "";
?>

<!DOCTYPE html>
<html lang="pt">
<style>
    .stars {
        display: inline-block;
    }

    .star {
        font-size: 40px;
        color: gray;
        cursor: pointer;
    }

    .star.filled {
        color: gold;
    }
</style>

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
        WHERE ca.Id_user = ? AND ca.Id_curso = ?;
    ");
    $stmt->bind_param("ii", $_SESSION['utilizadorOn']['Id_user'], $idCurso);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $countFases = $conn->prepare("SELECT COUNT(*) AS total FROM fase WHERE Id_curso = ?");
        $countFases->bind_param("i", $idCurso);
        $countFases->execute();
        $resultadoContagem = $countFases->get_result();

        if ($rowCount = $resultadoContagem->fetch_assoc()) {
            $NumeroTotal = $rowCount['total'];
        } else {
            $NumeroTotal = 0;
        }


        $row = $result->fetch_assoc();
        $stmt->close();
        $notas = $row['Notas'];
    ?>

        <!-- Secção Principal (Hero) -->
        <main class="container">
            <main class="container-c">

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
                    echo '
                    <h1>' . $row['Nome_curso'] . '</h1>
                    <p><span id="percentagem">' . $row['Percentagem_progresso'] . '</span>% Concluído</p>
                    <input type="hidden" id="ValorPercentagem" value="' . $row['Percentagem_progresso'] . '">
                    <input type="hidden" id="totalFases" value="' . $NumeroTotal . '">
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
                            echo "<script>console.log('quantidade:" . $NumeroTotal . ")</script>";
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
                                            echo '<div class="media">';
                                            $sitioImagem = $row['Imagem'];
                                            $caminhoImagem = "../../assets/conteudosCursos/imagens/" . $sitioImagem;

                                            if (!empty($sitioImagem) && file_exists($caminhoImagem)) {
                                                echo '
                                                
                                                    <img src="../../assets/conteudosCursos/imagens/' . $row['Imagem'] . '" alt="Imagem do Conteúdo" >
                                                
                                                ';
                                            } else {
                                                echo 'Erro ao carregar imagem';
                                            }
                                            echo '</div>';
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
                                            echo '<h3>Video explicativo</h3>
                                            <div class="media">';
                                            $sitioImagem = $row['video'];
                                            $caminhoImagem = "../../assets/conteudosCursos/videos/" . $sitioImagem;

                                            if (!empty($sitioImagem) && file_exists($caminhoImagem)) {
                                                echo '
                                                
                                                
                                                    <video controls>
                                                        <source src="../../assets/conteudosCursos/videos/' . $row['video'] . '" type="video/mp4" />
                                                        Seu navegador não suporta o elemento de vídeo.
                                                    </video>
                                                ';
                                            } else {
                                                echo "Erro ao carregar o video";
                                            }
                                            echo '</div>';
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

                <div class="stars" id="avaliacao" style="margin-top: 40px; display: flex; flex-direction: column; justify-content: center; align-items: center; height: 50px;">
                    <span style="margin-bottom: 5px;">Avalie o curso aqui</span>
                    <div>
                        <span class="star" data-value="1">&#9734;</span>
                        <span class="star" data-value="2">&#9734;</span>
                        <span class="star" data-value="3">&#9734;</span>
                        <span class="star" data-value="4">&#9734;</span>
                        <span class="star" data-value="5">&#9734;</span>
                    </div>
                </div>

                <footer id="footer" class="footer-c">

                    <br>
                    <?php
                    if ($NumeroTotal != 0) {
                        echo '<button id="btnAvançar" class="avançar" onclick="verFase(2)">Proxima fase</button>';
                    } else if ($NumeroTotal === 1) {
                        echo '
                        <form action="concluirCurso.php" method="post">
                            <input type="hidden" name="cursoAtual" value="' . $idCurso . '">
                            <button type="submit" id="btnAvançar" class="avançar">Concluir</button>
                        </form>
                    ';
                    } else {
                        echo '
                        <form action="../perfil/perfil_cursos.php" method="post">
                            <button type="submit" id="btnAvançar" class="avançar">Voltar aos meus cursos</button>
                        </form>
                    ';
                    }
                    ?>

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
        const notesTextarea = document.getElementById("notes");
        const botao = document.getElementById("btnAvançar");
        const totalFases = parseInt(document.getElementById("totalFases").value); // converter para número
        let txtpercentagem = document.getElementById("percentagem");
        let valorAtual = parseInt(txtpercentagem.textContent); // valor atual em número

        // Calcula quanto vale cada fase
        let percentagemPorFase = 100 / totalFases;

        function verFase(NumFase) {
            // Atualiza percentagem
            let percentagemPorFase = 100 / totalFases;
            let novaPercentagem = percentagemPorFase * (NumFase - 1);

            if (novaPercentagem > valorAtual) {
                valorAtual = novaPercentagem;

                let valorInteiro = Math.floor(valorAtual);
                let valorStr = valorInteiro.toString().slice(0, 2);

                txtpercentagem.textContent = valorStr;
            }

            // Mostra apenas a fase atual
            const todasFases = document.querySelectorAll('[id^="FaseNum_"]');
            todasFases.forEach(div => {
                div.style.display = div.id === 'FaseNum_' + NumFase ? 'block' : 'none';
            });

            const proximaFase = NumFase + 1;
            if (NumFase < totalFases) {
                document.getElementById("footer").innerHTML = `
            <button id="btnAvançar" class="avançar" onclick="verFase(${proximaFase})">Proxima fase</button>
        `;
            }

            if (proximaFase <= totalFases) {
                botao.setAttribute('onclick', `verFase(${proximaFase})`);
            } else {
                const idCurso = <?= json_encode($idCurso); ?>;
                document.getElementById("footer").innerHTML = `
            <form action="concluirCurso.php" method="post">
                <input type="hidden" name="cursoAtual" value="${idCurso}">
                <button type="submit" id="btnAvançar" class="avançar">Concluir</button>
            </form>
        `;
            }
            alterarEstadoVisualizacao(
                parseFloat(document.getElementById("percentagem").textContent),
                notesTextarea.value
            );


        }

        notesTextarea.addEventListener("input", () => {
            const length = notesTextarea.value.length;
            document.getElementById("char-count").textContent = `${length}/500 caracteres`;

            // Chama a função com apenas os dois parâmetros atualizados
            alterarEstadoVisualizacao(
                parseFloat(document.getElementById("percentagem").textContent),
                notesTextarea.value
            );
        });


        const estrelas = document.querySelectorAll('#avaliacao .star');
        let notaSelecionada = 0;

        estrelas.forEach(estrela => {
            estrela.addEventListener('click', () => {
                notaSelecionada = parseInt(estrela.getAttribute('data-value'));
                atualizarEstrelas(notaSelecionada);
                alterarClassificacao(notaSelecionada)
                // Aqui você pode fazer um fetch ou outro processo para enviar a avaliação ao servidor
            });
        });

        function atualizarEstrelas(nota) {
            estrelas.forEach(estrela => {
                if (parseInt(estrela.getAttribute('data-value')) <= nota) {
                    estrela.classList.add('filled');
                    estrela.textContent = '★'; // estrela cheia
                } else {
                    estrela.classList.remove('filled');
                    estrela.textContent = '☆'; // estrela vazia
                }
            });
        }




        function alterarEstadoVisualizacao(percentagem, notas) {
            const dados = {
                percentagem: percentagem,
                notas: notas ?? null,
                idCurso: <?= json_encode($idCurso) ?>,
                idUser: <?= json_encode($_SESSION['utilizadorOn']['Id_user']) ?>
            };

            fetch('atualizarDadosConteudo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dados)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.sucesso) {} else {
                        console.log("Erro ao atualizar: " + data.erro);
                    }
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                });
        }

        function alterarClassificacao(classificacao) {
            const dados = {
                classificacao: classificacao,
                idCurso: <?= json_encode($idCurso) ?>,
                idUser: <?= json_encode($_SESSION['utilizadorOn']['Id_user']) ?>
            };

            fetch('atualizarClassificacaoCurso.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dados)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.sucesso) {
                        alert("Obrigado pela sua avaliacão!")
                    } else {
                        console.log("Erro ao atualizar: " + data.erro);
                    }
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                });
        }
    </script>


</body>

</html>