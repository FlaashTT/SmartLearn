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
                    $query = "SELECT * FROM curso";
                    $stmt = $conn->prepare($query);


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
                                        <p>'..'</p>
                                        <div class="card-actions">
                                            <button class="edit-icon"><i class="fas fa-edit"></i></button>
                                            <button class="delete-icon"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="card-footer">
                                    <button class="btn edit-btn">Editar</button>
                                    <button class="btn delete-btn">Apagar</button>
                                </div>
                            </div>
                            ';
                        }
                    }
                    ?>




                </section>

                <!-- Modal para Editar -->
                <div id="editModal" class="modal" style="display: none;">
                    <div class="modal-content">
                        <h2>Editar Curso</h2>
                        <form id="editForm">
                            <label for="editTitle">Título do Curso:</label>
                            <input type="text" id="editTitle" name="editTitle" required>
                            <label for="editSubcategories">Subcategorias:</label>
                            <input type="text" id="editSubcategories" name="editSubcategories" required>
                            <button type="submit" class="btn">Salvar</button>
                            <button type="button" class="btn cancel-btn" onclick="closeModal('editModal')">Cancelar</button>
                        </form>
                    </div>
                </div>

                <!-- Modal para Confirmar Exclusão -->
                <div id="deleteModal" class="modal" style="display: none;">
                    <div class="modal-content">
                        <h2>Confirmar Exclusão</h2>
                        <p>Tem certeza de que deseja apagar este curso?</p>
                        <button id="confirmDelete" class="btn delete-btn">Sim, Apagar</button>
                        <button type="button" class="btn cancel-btn" onclick="closeModal('deleteModal')">Cancelar</button>
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
        let currentCard = null; // Variável para armazenar o card atual

        // Função para abrir um modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        // Função para fechar um modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Função para editar o card
        document.querySelectorAll('.edit-btn').forEach((button) => {
            button.addEventListener('click', (event) => {
                currentCard = event.target.closest('.card'); // Encontra o card correspondente
                const title = currentCard.querySelector('.card-header h3').textContent;
                const subcategories = currentCard.querySelector('.card-header p').textContent;

                // Preenche os campos do modal com os valores atuais
                document.getElementById('editTitle').value = title;
                document.getElementById('editSubcategories').value = subcategories;

                openModal('editModal'); // Abre o modal de edição
            });
        });

        // Salvar alterações no modal de edição
        document.getElementById('editForm').addEventListener('submit', (event) => {
            event.preventDefault(); // Evita o envio do formulário
            const newTitle = document.getElementById('editTitle').value;
            const newSubcategories = document.getElementById('editSubcategories').value;

            // Atualiza os valores no card
            currentCard.querySelector('.card-header h3').textContent = newTitle;
            currentCard.querySelector('.card-header p').textContent = newSubcategories;

            closeModal('editModal'); // Fecha o modal
        });

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

</body>

</html>