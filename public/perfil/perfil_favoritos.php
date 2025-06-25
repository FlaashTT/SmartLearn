<?php
include('../segurança.php');
include("../../database/basedados.php");
include('pesquisa.php');

// Verifica se existe algum filtro
$category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
$textoPesquisa = isset($_POST['search']) ? '%' . $_POST['search'] . '%' : null;

// Número de cursos por página
$por_pagina = 9;

// Calcular a página atual
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $por_pagina;

// Consultar o número total de cursos
$sql_total = "SELECT COUNT(*) as total FROM cursos_adquiridos WHERE Id_user = ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total_cursos = $result_total->fetch_assoc()['total'];

// Calcular o número total de páginas
$total_paginas = $total_cursos > 0 ? ceil($total_cursos / $por_pagina) : 1;

$sql = pesquisaFiltro("cursos_favoritos", $_SESSION['utilizadorOn']['Id_user'], $category_id, $textoPesquisa);
$sql .= " LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

// Para usar o bind correto conforme os filtros
if ($category_id && $textoPesquisa) {
    $stmt->bind_param("iisii", $_SESSION['utilizadorOn']['Id_user'], $category_id, $textoPesquisa, $por_pagina, $offset);
} else if ($category_id) {
    $stmt->bind_param("iiii", $_SESSION['utilizadorOn']['Id_user'], $category_id, $por_pagina, $offset);
} else if ($textoPesquisa) {
    $stmt->bind_param("isii", $_SESSION['utilizadorOn']['Id_user'], $textoPesquisa, $por_pagina, $offset);
} else {
    $stmt->bind_param("iii", $_SESSION['utilizadorOn']['Id_user'], $por_pagina, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartLearn</title>
    <link rel="stylesheet" href="../../assets/fontawesome/fontawesome/css/all.min.css" />
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
                <form method="POST">
                    <input type="hidden" name="reset" value="1" />
                    <button class="reset-btn" type="submit">Reiniciar</button>
                </form>
                <form method="POST" id="filterForm">
                    <div class="search-container">

                        <?php if ($category_id !== null) echo '<input type="hidden" name="category_id" value="' . $category_id . '">'; ?>
                        <input type="text" name="search" placeholder="Pesquisar meus cursos" class="search-my-courses" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>" />
                        <button class="search-button" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>

                    </div>
                </form>
            </div>

            <div class="content-card">

                <?php

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                            <div class="course-card">
                                <div class="course-image">';
                        $sitioImagem = $row['URL_foto_perfil_curso'];
                        $caminhoImagem = "../assets/image/curso/" . $sitioImagem;

                        if (!empty($sitioImagem) && file_exists($caminhoImagem)) {
                            echo '<img src="../../assets/image/curso/' . $row['URL_foto_perfil_curso'] . '" alt=" erro ao carregar imagem">';
                        } else {
                            echo '<img src="../../assets/image/curso.png" alt="Erro">';
                        }
                        echo '
                                   
                                </div>
                                <div class="course-info">
                                    <h3>' . $row['Nome_curso'] . '</h3>
                                    <div class="stars">
';
                        if ($row['Classificacao'] === 0) {
                            echo ("Sem classificação");
                        } else {
                            for ($i = 0; $i < $row['Classificacao']; $i++) {
                                echo '  <i class="fas fa-star" style="color: gold;"></i>';
                            }
                        }
                        echo '

                                    
                                        
                                    </div>
                                    <form method="POST" action="removerFav.php">
                                        <button class="start-button" name="idFav" value="' . $row['Id_curso'] . '">Remover dos favoritos</button>
                                    </form>
                                </div>
                            </div>
                        ';
                    }
                } else {
                    echo "<p>Sem cursos disponíveis nesta categoria ou com esse termo.</p>";
                }

                ?>
            </div>

            <div class="pagination">
                <?php if ($pagina_atual > 1) : ?>
                    <a href="?pagina=<?= $pagina_atual - 1 ?>&category_id=<?= $category_id ?>&search=<?= urlencode($textoPesquisa) ?>">Anterior</a>
                <?php endif; ?>

                <span>Página <?= $pagina_atual ?> de <?= $total_paginas ?></span>

                <?php if ($pagina_atual < $total_paginas) : ?>
                    <a href="?pagina=<?= $pagina_atual + 1 ?>&category_id=<?= $category_id ?>&search=<?= urlencode($textoPesquisa) ?>">Próxima</a>
                <?php endif; ?>
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
                        echo '<li class="category-item" data-category-id="' . $row['Id_categoria'] . '">' . $row['Nome_cat'] . '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- Rodapé -->
    <?php
    include("../../src/views/utils/rodape.html");
    ?>


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