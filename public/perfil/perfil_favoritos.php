<?php
include("../../database/basedados.sql");
include("../segurança.php");
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
    <link rel="stylesheet" href="../../assets/css/style_perfil_favoritos.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <?php
    include("../../src/views/utils/cabecalho.html");
    ?>

    <!-- Secção Principal (Hero) -->
    <div class="banner"></div>
    <main class="container-perfil">

        <?php
        include("../../src/views/utils/sidebar.html");
        ?>
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

                    

                ?>






                <div class="course-card">
                    <div class="course-image">
                        <img src="" alt="Erro">
                    </div>
                    <div class="course-info">
                        <h3>Curso de Tecnologia</h3>
                        <div class="stars">
                            <i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>
                        </div>
                        <button class="start-button">Remover dos favoritos</button>
                    </div>
                </div>
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