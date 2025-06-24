<?php
include("segurançaAdmin.php");
include("../../database/basedados.php");
$idCategoriaGlobal = "";

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
    <link rel="stylesheet" href="../../assets/css/admin/style_admin.css" />
    <link rel="stylesheet" href="../../assets/css/admin/style_curso_categoria.css" />
</head>

<body>
    <!-- Cabeçalho -->
        <?php
        include("../../src/views/utils/cabecalhoAdmin.html");
        ?>

        <!-- Secção Principal (Hero) -->
        <div class="container-admin">
            <main class="container">
                <?php
                include("../../src/views/utils/sidebarAdmin.html");
                ?>

                <main class="container-page">
                    <section class="main-content" style="display: flex; align-items: center; justify-content: space-between;">
                        <h1 style="display: flex; align-items: center;">
                            <i style="font-size: 18px; margin-right: 10px;" class="fas fa-book"></i> Categorias
                        </h1>
                        <button id="btnAdicionarCategoria" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-plus"></i> Adicionar nova categoria
                        </button>
                    </section>

                    <section class="page">
                        <div id="formCategoria" style="display: none;">
                            <h2>Formulário de Adição de uma categorias</h2>
                            <form class="form-content" method="POST" action="acoes/adicionarCategoria.php" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="titulo">Título da Categoria</label>
                                    <input type="text" name="nome_categoria" id="titulo" placeholder="Digite o título do curso" required />
                                </div>
                                <div class="form-group">
                                    <label for="miniatura">Miniatura da categoria <span>(O tamanho da imagem deve ser 400 x 255)</span></label>
                                    <input type="file" name="url_imagem" id="miniatura" accept=".jpg, .jpeg, .png">
                                </div>
                                <div class="form-buttons">
                                    <button type="submit" class="btn-enviar">Enviar</button>
                                    <button type="button" class="btn-voltar">Voltar</button>
                                </div>
                            </form>

                        </div>

                        <section class="card-container">

                            <?php
                            $query = "SELECT * FROM categoria";
                            $stmt = $conn->prepare($query);


                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {

                                    $id_categoria = $row['Id_categoria'];
                                    $idCategoriaGlobal = $id_categoria;
                                    $queryFases = "SELECT COUNT(*) AS Total FROM curso WHERE Id_categoria = $id_categoria";
                                    $resultFases = $conn->query($queryFases);
                                    $totalCursos = 0;

                                    if ($resultFases && $dadosFase = $resultFases->fetch_assoc()) {
                                        $totalCursos = $dadosFase['Total'];
                                    }

                                    echo '
                                        <div class="card">
                                            <div class="card-image">
                                    ';

                                    $sitioImagem = $row['Miniatura_cat'];
                                    $caminhoImagem = "../../assets/image/miniatura_cat/" . $sitioImagem;

                                    if (!empty($sitioImagem) && file_exists($caminhoImagem)) {
                                        echo '<img src="' . $caminhoImagem . '" alt="Imagem da categoria">';
                                    } else {
                                        echo '<img src="../../assets/image/miniatura_cat/miniatura_default.png" alt="Imagem padrão">';
                                    }


                                    echo '

                                            </div>
                                            <div class="card-content">
                                                <div class="card-header">
                                                    <h3><i class="fas fa-book"></i> ' . $row['Nome_cat'] . ' (' . $row['Id_categoria'] . ')</h3>
                                                    ';
                                    switch ($totalCursos) {
                                        case 0:
                                            echo '<p style="color: red;">Nenhum curso associado</p>';
                                            break;
                                        case 1:
                                            echo '<p style="color: green;">1 Curso encontrado</p>';
                                            break;
                                        default:
                                            echo '<p style="color: blue;">' . $totalCursos . ' Cursos encontrados</p>';
                                            break;
                                    }
                                    echo '
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn edit-btn" 
                                            type="button" 
                                            onclick="abrirModalEditar(' . $row['Id_categoria'] . ', \'' . addslashes($row['Nome_cat']) . '\', \'' . $row['Miniatura_cat'] . '\')">Editar</button>

                                        <button class="btn delete-btn" type="submit">Apagar</button>
                                    </div>
                                    </div>

                                    <!-- Modal de edição -->
                                    <div id="editModal" class="modal" style="display:none;">
                                        <div class="modal-content">
                                            <h2>Editar Categoria</h2>
                                            <form method="POST" action="acoes/alterarCategoria.php" enctype="multipart/form-data">
                                                <input type="hidden" name="Id_catEditar" id="Id_catEditar" value="">
                                                <label for="novoNomeCat">Título da categoria:</label>
                                                <input type="text" id="novoNomeCat" name="novoNomeCat" value="" required>
                                                <label for="miniatura">Miniatura da categoria <span>(400x255)</span></label>
                                                <img id="miniaturaPreview" src="" alt="Miniatura atual" style="max-width:200px; display:block; margin-bottom:10px;">
                                                <input type="file" name="url_imagem" id="miniatura" accept=".jpg, .jpeg, .png">
                                                <div style="margin-top: 10px;">
                                                    <button type="submit" class="btn">Salvar</button>
                                                    <button type="button" class="btn cancel-btn" onclick="fecharModal(\'editModal\')">Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    ';
                                    ;
                                }
                            } else {
                                echo "<p>Nenhuma categoria encontrada.</p>";
                            }
                            ?>




                        </section>
                    </section>

                    <div id="editModal" class="modal" style="display:none;">
                    <div class="modal-content">
                        <h2>Editar Categoria</h2>
                        <form method="POST" action="acoes/alterarCategoria.php" enctype="multipart/form-data">
                            <input type="hidden" name="Id_catEditar" id="Id_catEditar" value="">
                            <label for="novoNomeCat">Título da categoria:</label>
                            <input type="text" id="novoNomeCat" name="novoNomeCat" value="" required>
                            <label for="miniatura">Miniatura da categoria <span>(400x255)</span></label>
                            <img id="miniaturaPreview" src="" alt="Miniatura atual" style="max-width:200px; display:block; margin-bottom:10px;">
                            <input type="file" name="url_imagem" id="miniatura" accept=".jpg, .jpeg, .png">
                            <div style="margin-top: 10px;">
                                <button type="submit" class="btn">Salvar</button>
                                <button type="button" class="btn cancel-btn" onclick="fecharModal('editModal')">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>


                    <!-- Modal para Confirmar Exclusão -->
                    <div id="deleteModal" class="modal" style="display: none;">
                        <div class="modal-content">

                            <form action="acoes/apagarCategoria.php" method="POST">
                                <input type="hidden" name="idCategoria" value="<?php echo $idCategoriaGlobal ?>">
                                <h2>Confirmar Exclusão</h2>
                                <p>Tem certeza de que deseja apagar este curso?</p>
                                <button type="submit" id="confirmDelete" class="btn delete-btn">Sim, Apagar</button>

                                <button type="button" class="btn cancel-btn" onclick="closeModal('deleteModal')">Cancelar</button>
                            </form>



                        </div>
                    </div>

                </main>
            </main>
        </div>

        <script>
            document.querySelectorAll('.has-submenu').forEach(item => {
                item.addEventListener('click', () => {
                    // Alterna a classe "open" no item clicado
                    item.classList.toggle('open');
                });
            });
            document.querySelectorAll('.has-submenu-a').forEach(item => {
                item.addEventListener('click', e => {
                    e.stopPropagation(); // Impede que o clique propague para outros menus
                    item.classList.toggle('open');
                });
            });
        </script>

        <script>
            // Mostrar o formulário ao clicar no botão de adicionar
            document.getElementById('btnAdicionarCategoria').addEventListener('click', () => {
                document.getElementById('formCategoria').style.display = 'block';
                document.querySelector('.card-container').style.display = 'none';
            });

            // Esconder o formulário e mostrar os cartões ao clicar em "Voltar"
            document.querySelector('.btn-voltar').addEventListener('click', () => {
                document.getElementById('formCategoria').style.display = 'none';
                document.querySelector('.card-container').style.display = 'grid'; // ou 'block', dependendo do teu layout
            });
        </script>

        <script>
            let currentCard = null; // Já está no teu script
            let currentCourseId = null; // Adiciona esta variável para guardar o ID real do curso

            // Lidar com botão de apagar
            document.querySelectorAll('.delete-btn').forEach((button) => {
                button.addEventListener('click', (event) => {
                    currentCard = event.target.closest('.card'); // Guarda o card atual
                    currentCourseId = currentCard.dataset.id; // Assumindo que colocas data-id no card com o ID do curso
                    openModal('deleteModal'); // Abre o modal de confirmação
                });
            });

            // Lidar com confirmação de apagar
            document.getElementById('confirmDelete').addEventListener('click', () => {
                if (currentCard) {
                    // Remover o card da página (podes também fazer um pedido ao servidor para remover da base de dados)
                    currentCard.remove();

                    // Exemplo: redirecionar para script PHP para apagar
                    // window.location.href = `apagar_curso.php?id=${currentCourseId}`;

                    closeModal('deleteModal');
                    currentCard = null;
                    currentCourseId = null;
                }
            });

            // Função para abrir um modal
            function openModal(modalId) {
                document.getElementById(modalId).style.display = 'flex';
            }

            // Função para fechar um modal
            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }
        </script>


        <script>
            const editModal = document.getElementById('editModal');

document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', () => {
        // Pega os dados do botão
        const id = button.getAttribute('data-id');
        const nome = button.getAttribute('data-nome');
        const miniatura = button.getAttribute('data-miniatura');

        // Preenche o formulário no modal
        document.getElementById('Id_catEditar').value = id;
        document.getElementById('novoNomeCat').value = nome;

        const imgSrc = miniatura ? `../../assets/image/miniatura_cat/${miniatura}` : '../../assets/image/miniatura_cat/miniatura_default.png';
        document.getElementById('miniaturaPreview').src = imgSrc;

        // Mostra o modal
        editModal.style.display = 'flex';
    });
});

function fecharModal(idModal) {
    document.getElementById(idModal).style.display = 'none';
}

        </script>

</body>

</html>