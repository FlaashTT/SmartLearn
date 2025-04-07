<?php
include('../public/segurança.php');
include('../database/basedados.sql');



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
    <link rel="stylesheet" href="../assets/css/style_user.css" />
    <link rel="stylesheet" href="../assets/css/style_perfil_curso.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <header>
        <div class="container">
            <nav>
                <div class="nav-left">
                    <div class="logo">
                        <a href="inicio.php"><img src="../assets/image/Logo.png" alt="Logo" /></a>
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
                        <li>
                            <a href="#" class="nav-item">
                                Tutorial
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                Meus Cursos
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                        </li>
                        <li>
                            <a href="/src/registo.php" class="nav-item">
                                <i class="fa-regular fa-circle-user"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Secção Principal (Hero) -->
    <div class="banner"></div>
    <main class="container-perfil">
        <aside class="sidebar">
            <div class="user-info">
                <div class="avatar">
                    <img src="../assets/image/User.png" alt="Erro">
                </div>
                <div class="user-details">
                    <?php
                    echo '
                        <p>' . $_SESSION['utilizadorOn']['PNome_user'] . ' ' . $_SESSION['utilizadorOn']['SNome_user'] . '</p>
                        <p>T' . $_SESSION['utilizadorOn']['Email'] . '</p>
                    ';
                    ?>
                </div>
            </div>

            <ul class="menu">
                <li onclick="window.location.href='#'"><i class="fa-solid fa-book"></i> Meus Cursos</li>
                <li onclick="window.location.href='#'"><i class="fa-solid fa-heart"></i> Minha Lista de Desejos</li>
                <li onclick="window.location.href='#'"><i class="fa-solid fa-clock"></i> Histórico de Compras</li>
                <li onclick="window.location.href='#'"><i class="fa-solid fa-user"></i> Perfil de utilizador</li>
                <li onclick="window.location.href='#'"><i class="fa-solid fa-gear"></i> Conta</li>
                <li onclick="window.location.href='#'"><i class="fa-solid fa-wallet"></i> Carteira</li>
            </ul>

            <button onclick="window.location.href='logout.php'" class="logout">Sair</button>
        </aside>

        <section class="content">
            <div class="filters">
                <button class="category-btn">
                    Categorias <i class="fa-solid fa-chevron-down"></i>
                </button>
                <button class="reset-btn">Reiniciar</button>
                <div class="search-container">
                    <input type="text" placeholder="Pesquisar meus cursos" class="search-my-courses" />
                    <button class="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>

            </div>
            <div class="content-card">

                <?php

                $stmt = $conn->prepare(" SELECT * 
                    FROM cursos_adquiridos ca
                    INNER JOIN curso c ON ca.Id_curso = c.Id_curso
                    WHERE ca.Id_user = ?; ");
                $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                       <div class="course-card">
                            <div class="course-image">
                                <img src=' . $row['URL_foto_perfil_curso'] . ' alt=" erro">
                            </div>
                            <div class="course-info">
                                <h3>' . $row['Nome_curso'] . '</h3>
                                <hr>
                                <div class="progress-bar">
                                    <div class="progress"></div>
                                </div>
                                <p>' . $row['Percentagem_progresso'] . '% Concluído</p>
                                <div class="stars">
                                ';

                                if ($row['Classificacao'] == 0) {
                                    echo "Sem clasificação";
                                } else {
                                    for ($i = 0; $i < $row['Classificacao']; $i++) {
                                        echo ' <i class="fa-regular fa-star"></i>';
                                    }
                                }
                                echo '
                                    
                                </div>
                                <form action="../public/curso.php" method="POST">
                                ';
                                if($row['Percentagem_progresso'] == 0){
                                    echo'
                                    <button class="start-button" type="submit" name = "idCurso" value=' . $row['Id_curso'] . '>Iniciar aula</button>
                                    ';
                                }else if($row['Percentagem_progresso'] > 0 && $row['Percentagem_progresso'] < 100 ){
                                    echo'
                                    <button class="start-button" type="submit" name = "idCurso" value=' . $row['Id_curso'] . '>Continuar aula</button>
                                    ';
                                }else if($row['Percentagem_progresso'] == 100 ){
                                    echo'
                                    <button class="start-button" type="submit" name = "idCurso" value=' . $row['Id_curso'] . '>Rever aula</button>
                                    ';
                                }
                                echo'
                                </form>

                            </div>
                        </div> 
                    ';
                    }
                }


                ?>



            </div>
        </section>
    </main>

    <div id="category-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h3>Selecione uma Categoria</h3>
            <ul>
                <li>Categoria 1</li>
                <li>Categoria 2</li>
                <li>Categoria 3</li>
            </ul>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="footer-map">
            <!-- Aqui podes adicionar um iframe com o Google Maps -->
            <iframe src=""
                width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="container footer-content">
            <p>2025 Copyright by Leando Pinto e Ruben Pinheiro</p>
            <p>Castelo Branco – Rua Esperança – 6200-000</p>
            <p>Email: teste@gmail.com | Telefone: 255 777 222 | Fax: 966 662 222</p>
            <p>Privacy Policy | Terms & Conditions</p>
        </div>
    </footer>

    <script>
        // Seleciona o botão e o modal
        const categoryBtn = document.querySelector('.category-btn');
        const modal = document.getElementById('category-modal');
        const closeBtn = document.querySelector('.close-btn');

        // Abre o modal ao clicar no botão
        categoryBtn.addEventListener('click', () => {
            modal.style.display = 'flex'; // Mostra o modal
        });

        // Fecha o modal ao clicar no botão de fechar
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none'; // Oculta o modal
        });

        // Fecha o modal ao clicar fora do conteúdo
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>

</html>