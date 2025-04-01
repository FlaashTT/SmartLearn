<?php
session_start();
include("../database/basedados.sql");



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
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/style_base.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <header>
        <div class="container">
            <nav>
                <div class="nav-left">
                    <div class="logo">
                        <a href="layout_base.html"><img src="../assets/image/Logo.png" alt="Logo" /></a>
                        <span class="brand-name">SmartLearn</span>
                    </div>
                    <ul class="nav-links">
                        <li>
                            <a href="#" class="nav-item">
                                <i class="fas fa-bars"></i> Categorias
                            </a>
                        </li>
                        <li>
                            <input
                                type="text"
                                placeholder="Pesquisar cursos..."
                                class="search-input" />
                        </li>
                    </ul>
                </div>
                <div class="nav-right">
                    <ul class="nav-links">
                        <li><a href="#" class="nav-item">Conecte-se</a></li>
                        <li><a href="../src/registo.php" class="btn">Inscrever-se</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

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
                    <a href="/"><img src="../assets/image/Logo.png" alt="Logo" /></a>
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
                    echo "<h3>" . $result->num_rows . " Cursos online</h3>";
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
            <h1>10 Últimos cursos</h1>
            <hr>
        </section>


        <?php

        $stmt = $conn->prepare("SELECT * FROM curso ORDER BY Data_criacao DESC LIMIT 10 ");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               // Card de Curso
                echo '
                
        <section class="course-card">
            <div class="card">
                <div class="card-image">
                    <img src='.$row['URL_foto_perfil_curso'].' alt=" erro">
                </div>
                <div class="card-content">
                    <span class="badge">'.$row["Dificuldade"].'</span>
                    <h3>'.$row["Nome_curso"].'</h3>
                    <p class="reviews">(0 Avaliações)</p>
                    <div class="progress">
                        <div class="stars">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <button class="btn-buy" name="comprarCurso" value='.$row['Id_curso'].'>Comprar</button>
                    </div>
                    <div class="details">
                        <span>'.$row["Tempo_estimado"].'</span>
                    </div>
                </div>
            </div>
        </section>
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
        

        <section class="section-title">
            <h1>Instrutor em destaque</h1>
        </section>

        <section class="high">
            <div class="highlight">
                <div class="image-container-highlights">
                    <img src="../assets/image/Logo.png" alt="Imagem do instrutor" class="image-highlights">
                </div>
            </div>

        </section>

    </main>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="footer-map">
            <!-- Aqui podes adicionar um iframe com o Google Maps -->
            <iframe src="https://g.co/kgs/bK5fDXa"
                width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
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