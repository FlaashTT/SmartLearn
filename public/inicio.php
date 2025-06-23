<?php
session_start();
include("../database/basedados.php");

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
                $stmt = $conn->prepare("SELECT * FROM categoria ORDER BY Quantidade_cursos DESC LIMIT 4 ");
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="category">
                            <div class="icon-category">
                                <i class="fa-solid fa-code"></i>
                            </div>
                            <h2 class="title-category">' . htmlspecialchars($row["Nome_cat"]) . '</h2>
                            <p class="p-category">' . $row["Quantidade_cursos"] . ' Curso' . ($row["Quantidade_cursos"] > 1 ? 's' : '') . '</p>
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
            <h1>Seis cursos mais recentes</h1>
            <hr>
        </section>

        <section class="course-card">
            <?php

            $stmt = $conn->prepare("SELECT * FROM curso ORDER BY Data_criacao DESC LIMIT 6 ");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Card de Curso
                    echo '
                
        <form id="formCurso' . $row['Id_curso'] . '" action="../public/curso/curso_capa.php" method="POST" style="margin: 0;">
        <input type="hidden" name="idCurso" value="' . $row['Id_curso'] . '">

            <div class="card" >
                <div class="card-image" onclick="document.getElementById(\'formCurso' . $row['Id_curso'] . '\').submit();" style="cursor: pointer;">
                ';
                    $sitioImagem = $row['URL_foto_perfil_curso'];
                    $caminhoImagem = "../assets/image/curso/" . $sitioImagem;

                    if (!empty($sitioImagem) && file_exists($caminhoImagem)) {
                        echo ' <img src=../assets/image/curso/' . $row['URL_foto_perfil_curso'] . ' alt=" erro ao carregar imagem">';
                    } else {
                        echo '<img src="../assets/image/curso.png" alt="Erro">';
                    }
                    echo '
                   
                </div>
                <div class="card-content">
                    <span class="badge">' . $row["Dificuldade"] . '</span>
                    <h3>' . $row["Nome_curso"] . '</h3>
                    <p class="reviews">(0 Avaliações)</p>
                    <div class="progress">
                        <div class="stars">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
        </form>
                        ';
                    if (!isset($_SESSION['utilizadorOn']) || !$_SESSION['utilizadorOn']) {
                        echo "";
                    } else {
                        echo '
                                <form action="curso/curso_capa.php" method="POST">
                                    <button class="btn-buy" type="submit" name="idCurso" value="' . $row['Id_curso'] . '">Ver mais</button>
                                </form>';
                    }
                    echo '
                    </div>
                    <div class="details">
                        <span>' . $row["Tempo_estimado"] . '</span>
                    </div>
                </div>
                
            </div>
            
        
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
            <h1>Instrutor em destaque</h1>
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