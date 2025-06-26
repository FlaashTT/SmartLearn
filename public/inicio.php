<?php
session_start();
include("../database/basedados.php");
//inicio.php
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartLearn</title>
    <link
        rel="stylesheet"
        href="../assets/fontawesome/fontawesome/css/all.min.css" />

    <?php
    if (!isset($_SESSION['utilizadorOn']) || !$_SESSION['utilizadorOn']) {
        echo '
        <link rel="stylesheet" href="../assets/css/style.css" />
        <link rel="stylesheet" href="../assets/css/style_base.css" />
        ';
    } else {
        echo '
        <link rel="stylesheet" href="../assets/css/style_user.css" />
        <link rel="stylesheet" href="../assets/css/style_logado.css" />
        ';
    }

    ?>

</head>

<body>
    <!-- Cabeçalho -->
    <?php
    include("../src/views/utils/cabacalhoNaoLogado.html");
    ?>

    <!-- Secção Principal (Hero) -->
    <main class="container">
        <section class="hero container">
            <div class="hero-text">
                <h1>Comece a aprender com a melhor plataforma</h1>
                <p>
                    Estude qualquer assunto, a qualquer hora, explore milhares de cursos
                    pelo menor preço de todos!
                </p>
                <div class="search-box">
                    <input type="text" placeholder="O que tu quisseres aprender?" disabled />
                    <button class="btn-box" disabled>Pesquisar</button>
                </div>
            </div>
            <div class="hero-image">
                <div class="image-placeholder">
                    <a><img src="../assets/image/Logo.png" alt="Logo" /></a>
                </div>
            </div>
        </section>

        <!-- Secção de Destaques (3 colunas) -->
        <section class="features container">
            <div class="feature-card">
                <div class="icon-placeholder">
                    <i class="fa-solid fa-arrow-pointer"></i>
                </div>
                <?php

                $stmt = $conn->prepare("SELECT * FROM curso WHERE Estado_curso = ?");
                $estadoPretendido = "ativo";
                $stmt->bind_param("s", $estadoPretendido);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<h3>" . $result->num_rows . " Curso" . ($result->num_rows > 1 ? "s" : "") . " online</h3>";
                } else {
                    echo "<h3>Nenhum curso disponivel atualmente</h3>";
                }

                ?>

                <p>Explore uma variedade de novos tópicos</p>
            </div>
            <div class="feature-card">
                <div class="icon-placeholder">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h3>Instrução especializada</h3>
                <p>Aprende com profissionais experientes</p>
            </div>
            <div class="feature-card">
                <div class="icon-placeholder">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <h3>A qualquer hora</h3>
                <p>Explora quando quiseres e como quiseres</p>
            </div>
        </section>

        <section class="section-title">
            <h1>Principais categorias</h1>
            <hr>
        </section>

        <section class="category-card">
            <div class="categories">
                <?php
                $stmt = $conn->prepare("SELECT * FROM categoria LIMIT 4");
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $estado = 'ativo';
                        $stmtCursos = $conn->prepare("SELECT COUNT(*) AS total_cursos FROM curso WHERE id_categoria = ? AND Estado_curso = ?");
                        $stmtCursos->bind_param("is", $row['Id_categoria'],$estado);
                        $stmtCursos->execute();
                        $resultCursos = $stmtCursos->get_result();
                        $rowtotal = $resultCursos->fetch_assoc();

                        $total = $rowtotal['total_cursos'];
                        echo '
                            <div class="category">
                                <div class="icon-category">
                                    <i class="fa-solid fa-code"></i>
                                </div>
                                <h2 class="title-category">' . htmlspecialchars($row["Nome_cat"]) . '</h2>
                                <p class="p-category">' . $total . ' Curso' . ($total > 1 ? 's' : '') . '</p>
                            </div>
                            ';
                    }
                } else {
                    echo '
                       
                        <div class="category">
                            <p>Categorias indisponiveis</p>
                        </div>
                       
                       ';
                }

                ?>




            </div>
        </section>



        <section class="section-title">
            <?php
            $sql = "SELECT COUNT(*) AS total_ativos FROM curso WHERE Estado_curso = 'ativo'";
            $result = $conn->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                $totalCursosDisponiveis = $row['total_ativos'];

                if ($totalCursosDisponiveis > 8) {
                    echo '<h1>Seis cursos mais recentes</h1>';
                } else {
                    if ($totalCursosDisponiveis == 1) {
                        echo '<h1>Um curso recente</h1>';
                    } else {
                        $texto = "";
                        switch ($totalCursosDisponiveis) {
                            case 2:
                                $texto = "Dois";
                                break;
                            case 3:
                                $texto = "Três";
                                break;
                            case 4:
                                $texto = "Quatro";
                                break;
                            case 5:
                                $texto = "Cinco";
                                break;
                            case 6:
                                $texto = "Seis";
                                break;
                            case 7:
                                $texto = "Sete";
                                break;
                            case 8:
                                $texto = "Oito";
                                break;
                                
                        }
                        Echo "<h1>".$texto." cursos mais recentes</h1>";
                    }
                }
            }

            ?>
            <hr>
        </section>

        <section class="course-card">
            <?php

            $stmt = $conn->prepare("SELECT * FROM curso WHere Estado_curso = 'ativo' ORDER BY Data_criacao DESC LIMIT 6 ");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $sql = "SELECT COUNT(*) AS totalAvaliacoes FROM cursos_adquiridos WHERE Avaliacao IS NOT NULL AND Id_curso = '{$row['Id_curso']}'";
                    $resultavaliacoes = $conn->query($sql);

                    if ($resultavaliacoes) {
                        $rowAv = $resultavaliacoes->fetch_assoc();
                        $totalAvaliacoes = $rowAv['totalAvaliacoes'];
                    } else {
                        echo "Erro na consulta: " . $conn->error;
                    }
                    // Card de Curso
                    echo '
        <form id="formCurso' . $row['Id_curso'] . '" action="curso/curso_capa.php" method="POST" style="margin: 0;">
            <input type="hidden" name="idCurso" value="' . $row['Id_curso'] . '">
            <div class="card">
                <div class="card-image" onclick="document.getElementById(\'formCurso' . $row['Id_curso'] . '\').submit();" style="cursor: pointer;">';
                    $sitioImagem = $row['URL_foto_perfil_curso'];
                    $caminhoImagem = "../assets/image/curso/" . $sitioImagem;

                    if (!empty($sitioImagem) && file_exists($caminhoImagem)) {
                        echo '<img src="../assets/image/curso/' . $row['URL_foto_perfil_curso'] . '" alt=" erro ao carregar imagem">';
                    } else {
                        echo '<img src="../assets/image/curso.png" alt="Erro">';
                    }
                    echo '
                </div>
                <div class="card-content">
                    <span class="badge">' . $row["Dificuldade"] . '</span>
                    <h3>' . $row["Nome_curso"] . '</h3>
                    ';
                    if ($totalAvaliacoes == 0) {
                        echo '<p class="reviews">(Sem avaliações)</p>';
                    } elseif ($totalAvaliacoes == 1) {
                        echo '<p class="reviews">(1 Avaliação)</p>';
                    } else {
                        echo '<p class="reviews">(' . $totalAvaliacoes . ' Avaliações)</p>';
                    }

                    echo '
                    <div class="progress">
                        <div class="stars">
                        ';
                    if ($row['Classificacao'] === 0) {
                        echo ("Sem classificação");
                    } else {
                        for ($i = 0; $i < $row['Classificacao']; $i++) {
                            echo ' <span>★</span>';
                        }
                    }
                    echo '
                           
                        </div>
                    </div>
                    <div class="price">
                        ' . number_format($row["Preco"], 2, ',', '.') . ' €' . '
                    </div>
                    <div class="details">
                        <span>' . $row["Tempo_estimado"] . '</span>
                        
                    </div>';
                    if (isset($_SESSION['utilizadorOn']) && $_SESSION['utilizadorOn']) {
                        echo '
                        <button class="btn-buy" type="submit">Ver mais</button>';
                    }
                    echo '
                </div>
            </div>
        </form>
        ';
                }
            } else {
                echo '
       
        <div class="category">
            <p>Cursos indisponiveis</p>
        </div>
       
       ';
            }

            ?>

        </section>
        <section class="cursos-geral-section">
            <div class="cursos-geral">
                <button class="btn-geral" onclick="window.location.href='categorias.php'">Ver todos os cursos</button>
            </div>
        </section>
        <section class="section-title">

            <hr>
        </section>

        <section class="high">
            <div class="highlight">
                <div class="image-container-highlights">
                    <img src="../assets/image/SmarLearn_base_destaque.png" alt="Imagem do instrutor" class="image-highlights">
                </div>
            </div>

        </section>

    </main>

    <div id="popup-satisfacao" class="popup">
        <div class="popup-content">
            <span class="close-btn">&times;</span>
            <h2>Ajuda-nos a melhorar!</h2>
            <p>
                Ainda não preenches-te o nosso formulário de satisfação. Gostaríamos
                de ouvir a tua opinião.
            </p>
            <a href="https://docs.google.com/forms/d/e/1FAIpQLSeQm_121Zk7IyPpWnUztOW0Pc7ERAEn1jIlXMpNkv36eWB2og/viewform?usp=pp_url" class="btn">Preencher agora</a>
        </div>
    </div>


    <!-- Rodapé -->
    <?php
    include("../src/views/utils/rodape.html");
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const popup = document.getElementById("popup-satisfacao");
            const closeBtn = document.querySelector(".close-btn");

            const FORM_DONE_KEY = "formularioSatisfacaoFeito";
            const LAST_SEEN_KEY = "ultimoPopupSatisfacao";

            // Simula que o formulário foi feito (só para testes)
            // localStorage.setItem(FORM_DONE_KEY, "true");

            const jaPreencheu = localStorage.getItem(FORM_DONE_KEY);
            const ultimaVez = localStorage.getItem(LAST_SEEN_KEY);
            const agora = new Date();

            const doisDiasMs = 2 * 24 * 60 * 60 * 1000;

            if (!jaPreencheu) {
                if (!ultimaVez || agora - new Date(ultimaVez) > doisDiasMs) {
                    popup.style.display = "block";
                    localStorage.setItem(LAST_SEEN_KEY, agora.toISOString());
                }
            }

            closeBtn.addEventListener("click", () => {
                popup.style.display = "none";
            });
        });
    </script>
</body>

</html>