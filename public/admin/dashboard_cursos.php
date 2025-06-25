<?php

include("segurançaAdmin.php");
include("../../database/basedados.php");



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
    <link rel="stylesheet" href="../../assets/css/admin/style_curso_dashboard.css" />
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
                        <i style="font-size: 18px; margin-right: 10px;" class="fas fa-book"></i> Dashboard Cursos
                    </h1>
                    <form action="adicionar_cursos.php">
                        <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            Adicionar Novo Curso
                        </button>
                    </form>
                </section>

                <section class="card-container">

                    <?php
                    $stmt = $conn->prepare("SELECT curso.*, idioma.Nome_idioma, categoria.Nome_cat
                        FROM curso
                        INNER JOIN idioma ON curso.Id_idioma = idioma.Id_idioma
                        LEFT JOIN categoria ON curso.Id_categoria = categoria.Id_categoria
                        ORDER BY FIELD(curso.Estado_curso, 'ativo', 'pendente', 'inativo', 'Incompleto', 'Eliminado')");
                    $stmt->execute();
                    $result = $stmt->get_result();


                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id_curso = $row['Id_curso'];

                            // Contar as fases do curso
                            $queryFases = "SELECT COUNT(*) AS Total FROM fase WHERE Id_curso = $id_curso";
                            $resultFases = $conn->query($queryFases);
                            $totalFases = 0;

                            if ($resultFases && $dadosFase = $resultFases->fetch_assoc()) {
                                $totalFases = $dadosFase['Total'];
                            }

                            // Buscar até 4 nomes de fases (seções)
                            $querySecoes = "SELECT Titulo_fase FROM fase WHERE Id_curso = $id_curso LIMIT 2";
                            $resultSecoes = $conn->query($querySecoes);


                            echo '
                            <div class="card">
                                <div class="card-image">
                                ';
                            $sitioImagem = $row['URL_foto_perfil_curso'];
                            $caminhoImagem = "../../assets/image/curso/" . $sitioImagem;

                            if (!empty($sitioImagem) && file_exists($caminhoImagem)) {
                                echo '<img src="../../assets/image/curso/' . $sitioImagem . '" alt="Erro">';
                            } else {
                                echo '<img src="../../assets/image/curso/capa_curso.png" alt="Erro">';
                            }

                            echo '
                                </div>
                                <div class="card-content">
                                    <div class="card-header">
                                        <h3><i class="fas fa-book"></i> ' . $row['Nome_curso'] . '</h3>
                                        <p>Total de fases: ' . $totalFases . '</p>
                                    </div>
                                    <hr>
                                    <div class="card-sections">
                                        <p>Estado curso: ' . $row['Estado_curso'] . '</p>
                                    </div>
                                    <hr>
                                </div>
                                <div class="card-footer">
                                ';
                            if ($row['Estado_curso'] !== "Eliminado") {
                                echo '   
                                    <button class="btn edit-btn" onclick="openModal(\'editModal_' . $row["Id_curso"] . '\')">Editar</button>
                                    
                                    <button class="btn delete-btn" onclick="openModal(\'deleteModal_' . $row["Id_curso"] . '\')">Apagar</button>';
                            }

                            echo '
                                </div>
                            </div>
                                    ';
                            if ($row['Estado_curso'] !== "Eliminado") {
                                echo '
                                <!-- Modal para Confirmar Exclusão -->
                                    <div id="deleteModal_' . $row["Id_curso"] . '" class="modal" style="display: none;">
                                        <form action="acoes/eliminarCurso.php" method="POST">
                                            <input type="hidden" name="Id_curso" value="' . $row['Id_curso'] . '">
                                            <div class="modal-content">
                                                <h2>Confirmar Exclusão</h2>
                                                <p>Tem certeza de que deseja apagar este curso, Nome: ' . $row['Nome_curso'] . '?</p>
                                                <button type="submit" class="btn delete-btn">Sim, Apagar</button>
                                                <button type="button" class="btn cancel-btn" onclick="closeModal(\'deleteModal_' . $row["Id_curso"] . '\')">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                    

                             <!-- Modal para Editar -->
                                <div id="editModal_' . $row["Id_curso"] . '" class="modal" style="display: none;">
                                    <div class="modal-content" style="max-height: 80vh; overflow-y: auto;">
                                    <span class="close-modal">&times;</span>
                                        <h2>Editar Curso</h2>
                                        <form id="editForm" action="acoes/editarCurso.php" method="POST">
                                            <label for="editTitle">Título do Curso: ' . $row['Nome_curso'] . '</label>
                                            
                                            <input type="hidden" name="Id_curso" value="' . $row['Id_curso'] . '" >
                                            <p style="margin-top:20px;">
                                            <label>Título:</label>
                                            <input type="text" name="titulo" value="' . $row['Nome_curso'] . '" ><br>

                                            <select name="categoria" id="categoria">
                                            
                                            ';
                                $resultcategoria = $conn->query("SELECT * FROM categoria");

                                if ($resultcategoria->num_rows > 0) {
                                    while ($categoria = $resultcategoria->fetch_assoc()) {
                                        echo '<option value="' . $categoria['Id_categoria'] . '" ' . ($row['Id_categoria'] == $categoria['Id_categoria'] ? 'selected' : '') . '>' . $categoria['Nome_cat'] . '</option>';
                                    }
                                }
                                echo '</select><br>

                                            <label>Descrição:</label>
                                            <textarea name="descricao">' . $row['Descricao'] . '</textarea><br>

                                            <label>Estado:</label>
                                            <select name="estadoCurso" id="estadoCurso">
                                                <option value="ativo" ' . ($row['Estado_curso'] == 'ativo' ? 'selected' : '') . '>Ativo</option>
                                                <option value="inativo" ' . ($row['Estado_curso'] == 'inativo' ? 'selected' : '') . '>Inativo</option>
                                                <option value="pendente" ' . ($row['Estado_curso'] == 'pendente' ? 'selected' : '') . '>Pendente</option>
                                                <option value="Incompleto" ' . ($row['Estado_curso'] == 'Incompleto' ? 'selected' : '') . '>Incompleto</option>
                                                <option value="Eliminado" ' . ($row['Estado_curso'] == 'Eliminado' ? 'selected' : '') . '>Eliminado</option>
                                            </select><br>

                                            <label>Preço atual:</label>
                                            <input type="number" name="preco" step="0.01" min="0" value="' . (empty($row['Preco']) || $row['Preco'] == 0 ? '' : $row['Preco']) . '"><br>


                                            <label>Idioma:</label>
                                            <select name="IdiomaCurso" id="IdiomaCurso">
                                            ';
                                $resultIdiomas = $conn->query("SELECT * FROM idioma");

                                if ($resultIdiomas->num_rows > 0) {
                                    while ($idioma = $resultIdiomas->fetch_assoc()) {
                                        echo '<option value="' . $idioma['Id_idioma'] . '" ' . ($row['Id_idioma'] == $idioma['Id_idioma'] ? 'selected' : '') . '>' . $idioma['Nome_idioma'] . '</option>';
                                    }
                                }
                                echo '</select><br>';
                                echo '

                                            <label>Dificuldade:</label>
                                            <select name="dificuldade" id="dificuldade">
                                                <option value="Iniciante" ' . ($row['Dificuldade'] == 'Iniciante' ? 'selected' : '') . '>Iniciante</option>
                                                <option value="intermedio" ' . ($row['Dificuldade'] == 'intermedio' ? 'selected' : '') . '>Intermédio</option>
                                                <option value="avançado" ' . ($row['Dificuldade'] == 'avançado' ? 'selected' : '') . '>Avançado</option>
                                            </select><br>

                                            <label>Requisitos:</label>
                                            <textarea name="requisitos">' . htmlspecialchars($row['Requisitos']) . '</textarea><br>


                                            <label>Provedor de curso:</label>
                                            <select name="Provedor" id="provedor">
                                                <option value="youtube" ' . ($row['Provedor_geral_curso'] == 'youtube' ? 'selected' : '') . '>youtube</option>
                                                <option value="tiktok" ' . ($row['Provedor_geral_curso'] == 'tiktok' ? 'selected' : '') . '>tiktok</option>
                                                <option value="instagram" ' . ($row['Provedor_geral_curso'] == 'instagram' ? 'selected' : '') . '>instagram</option>
                                                <option value="linkedin" ' . ($row['Provedor_geral_curso'] == 'linkedin' ? 'selected' : '') . '>linkedin</option>
                                                <option value="conta_proria" ' . ($row['Provedor_geral_curso'] == 'conta_proria' ? 'selected' : '') . '>conta proria</option>
                                                <option value="outro" ' . ($row['Provedor_geral_curso'] == 'outro' ? 'selected' : '') . '>outro</option>
                                            </select><br>

                                            <label>Url provedor geral:</label>
                                            <input type="text" name="LinkProvedor" value="' . $row['URL_geral_curso'] . '" ><br>

                                            <label>Tempo estimado:</label>
                                            <input type="text" name="tempo" value="' . $row['Tempo_estimado'] . '" ><br>

                                            <button type="submit" class="btn">Salvar</button>
                                            <button type="button" class="btn cancel-btn" onclick="closeModal(\'editModal_' . $row["Id_curso"] . '\')">Cancelar</button>
                                        </form>
                                    </div>
                                </div>

                            ';
                            }
                        }
                    }
                    ?>




                </section>




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
        let currentCard = null; // Variável para armazenar o card atual

        // Função para abrir um modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        // Função para fechar um modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }



        // Função para apagar o card
        document.querySelectorAll('.delete-btn').forEach((button) => {
            button.addEventListener('click', (event) => {
                currentCard = event.target.closest('.card'); // Encontra o card correspondente
                openModal('deleteModal'); // Abre o modal de confirmação de exclusão
            });
        });

        // Confirmar exclusão
        document.getElementById('confirmDelete').addEventListener('click', () => {
            if (currentCard) {
                currentCard.remove(); // Remove o card
                closeModal('deleteModal'); // Fecha o modal
            }
        });
    </script>
    <script>
            document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.modal').forEach(modal => modal.style.display = 'none');
        });
    });
    </script>

</body>

</html>