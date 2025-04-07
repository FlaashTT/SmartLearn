<?php
include('../segurança.php');
include('../../database/basedados.sql');

// Verifica se o parâmetro category_id está na URL
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartLearn</title>
    <link rel="stylesheet" href="../../assets/fontawesome/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/style_user.css" />
    <link rel="stylesheet" href="../../assets/css/style_perfil_curso.css" />
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
                // Prepara a consulta com base na categoria selecionada
                $sql = "SELECT * 
                        FROM cursos_adquiridos ca
                        INNER JOIN curso c ON ca.Id_curso = c.Id_curso
                        WHERE ca.Id_user = ?";

                if ($category_id) {
                    // Se uma categoria for selecionada, filtra pelos cursos dessa categoria
                    $sql .= " AND c.Id_categoria = ?";
                }

                // Prepara a consulta
                $stmt = $conn->prepare($sql);

                // Faz a ligação dos parâmetros
                if ($category_id) {
                    $stmt->bind_param("ii", $_SESSION['utilizadorOn']['Id_user'], $category_id);
                } else {
                    $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
                }

                // Executa a consulta
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <div class="course-card">
                            <div class="course-image">
                                <img src="../' . $row['URL_foto_perfil_curso'] . '" alt="erro" style="width: 210px; height: 150px;">
                            </div>
                            <div class="course-info">
                                <h3>' . $row['Nome_curso'] . '</h3>
                                <hr>
                                <div class="progress-bar">
                                    <div class="progress" style="width: '. $row['Percentagem_progresso'] .'%;"></div>
                                </div>
                                <p>' . $row['Percentagem_progresso'] . '% Concluído</p>
                                <div class="stars">
                        ';
                        if ($row['Classificacao'] == 0) {
                            echo "Sem classificação";
                        } else {
                            for ($i = 0; $i < $row['Classificacao']; $i++) {
                                echo ' <i class="fa-regular fa-star"></i>';
                            }
                        }
                        echo '
                                </div>
                                <form action="../curso.php" method="POST">
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
                } else {
                    echo "<p>Sem cursos disponíveis nesta categoria.</p>";
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
                <?php
                    $stmt = $conn->prepare("SELECT * FROM categoria ORDER BY Nome_cat");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<li class="category-item" data-category-id="'.$row['Id_categoria'].'">'.$row['Nome_cat'].'</li>';
                        }
                    }
                ?>
            </ul>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-map">
            <!-- Aqui podes adicionar um iframe com o Google Maps -->
            <iframe src="" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="container footer-content">
            <p>2025 Copyright by Leando Pinto e Ruben Pinheiro</p>
            <p>Castelo Branco – Rua Esperança – 6200-000</p>
            <p>Email: teste@gmail.com | Telefone: 255 777 222 | Fax: 966 662 222</p>
            <p>Privacy Policy | Terms & Conditions</p>
        </div>
    </footer>

    <script>
        const categoryItems = document.querySelectorAll('.category-item');
        const categoryBtn = document.querySelector('.category-btn');
        const modal = document.getElementById('category-modal');
        const closeBtn = document.querySelector('.close-btn');

        // Abre o modal
        categoryBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        // Fecha o modal
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Fecha o modal se clicar fora
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Lida com a seleção da categoria
        categoryItems.forEach(item => {
            item.addEventListener('click', () => {
                const categoryId = item.getAttribute('data-category-id');
                window.location.href = `?category_id=${categoryId}`; // Redireciona com a categoria selecionada
            });
        });
    </script>
</body>

</html>
