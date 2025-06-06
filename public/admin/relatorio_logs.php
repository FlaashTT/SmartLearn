<?php
include("../../database/basedados.php");
include("segurançaAdmin.php");


$quantidadePesquisa = 0;
$limite = isset($_GET['limite']) ? intval($_GET['limite']) : 10;
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$textoPesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
$offset = ($pagina - 1) * $limite;
$totalEntradas = 0;
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
    <link rel="stylesheet" href="../../assets/css/admin/style_relatorio_logs.css" />
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
                        <i style="font-size: 18px; margin-right: 10px;" class="fa-solid fa-font-awesome"></i> Logs de Acesso
                    </h1>
                </section>

                <section class="course-list">
                    <h2>Logs</h2>
                    <div class="filters">
                        <form method="GET" action="relatorio_logs.php">
                            <div class="search-container">
                                <input type="text" name="pesquisa" id="searchInput" placeholder="Pesquisar...">
                                <button type="submit">Filtrar</button>
                            </div>
                        </form>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div>
                            <form method="GET" style="display: inline;">
                                Mostrar
                                <select name="limite" onchange="this.form.submit()" style="padding: 5px 10px; margin: 0 5px;">
                                    <option value="10" <?= $limite == 10 ? 'selected' : '' ?>>10</option>
                                    <option value="25" <?= $limite == 25 ? 'selected' : '' ?>>25</option>
                                    <option value="50" <?= $limite == 50 ? 'selected' : '' ?>>50</option>
                                    <option value="100" <?= $limite == 100 ? 'selected' : '' ?>>100</option>
                                </select>
                                entradas
                                <!-- opcional: resetar a página para 1 ao mudar o limite -->
                                <input type="hidden" name="pagina" value="1">
                            </form>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome | Email</th>
                                <th>Descrição</th>
                                <th>Data de Acesso</th>
                                <th>Tipo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($textoPesquisa != '') {
                                $query = "SELECT * FROM logs_sistema
                                            INNER JOIN user ON logs_sistema.Id_user = user.Id_user
                                            WHERE user.Pnome_user LIKE ? 
                                            OR user.Email LIKE ? 
                                            OR logs_sistema.Tipo_log LIKE ?
                                            LIMIT ?, ?";
                                $stmt = $conn->prepare($query);
                                $pesquisaParam = "%" . $textoPesquisa . "%";
                                $stmt->bind_param("sssii", $pesquisaParam, $pesquisaParam, $pesquisaParam, $offset, $limite);
                            } else {


                                $query = "SELECT * FROM logs_sistema
                                            INNER JOIN user ON logs_sistema.Id_user = user.Id_user
                                            LIMIT ?, ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("ii", $offset, $limite);
                            }

                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                $quantidadePesquisa = $result->num_rows;

                                while ($row = $result->fetch_assoc()) {
                                    $totalEntradas++;
                                    echo '
                                    <tr>
                                        <td>' . $row['Id_user'] . '</td>
                                        <td>' . $row['PNome_user'] . ' ' . $row['SNome_user'] . ' <br><small>' . $row['Email'] . '</small></td>
                                        <td>
                                            Responsável pela gestão dos cursos...
                                            <a href="#" class="ver-mais-link" onclick="abrirDescricaoModal("Joana Silva", "Responsável pela gestão dos cursos e conteúdos da plataforma, incluindo organização, monitorização de progresso, e suporte a formadores e alunos.")"
                                                style="color: #007bff; text-decoration: none;">Ver mais</a>
                                        </td>
                                        <td>2025-04-14 15:23</td>
                                        <td>' . $row['Tipo_log'] . '</td>
                                        <td style="text-align: center;">
                                            <a href="#" style="color: #e74c3c; font-size: 14px; text-decoration: none;">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>


                                ';
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php

                    $totalPaginas = ceil($totalEntradas / $limite);
                    $de = $offset + 1;
                    $ate = min($offset + $limite, $totalEntradas);
                    echo '
                    <div style="margin-top: 10px; font-size: 14px; color: #666;">
                        
                        A mostrar ' . $de . ' a ' . $ate . ' de ' . $totalEntradas . ' entradas
                    </div>
                    ';
                    ?>


                    <div class="pagination">
                        <?php if ($pagina > 1): ?>
                            <a href="?pagina=<?php echo $pagina - 1; ?>&limite=<?php echo $limite; ?>">
                                <button>Anterior</button>
                            </a>
                        <?php endif; ?>

                        <?php if ($pagina < $totalPaginas): ?>
                            <a href="?pagina=<?php echo $pagina + 1; ?>&limite=<?php echo $limite; ?>">
                                <button>Próximo</button>
                            </a>
                        <?php endif; ?>
                    </div>
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
        function abrirDescricaoModal(nome, descricao) {
            // Define o título e a descrição no modal
            document.getElementById("modalTitle").innerText = `Descrição de ${nome}`;
            document.getElementById("modalDescricao").innerText = descricao;

            // Mostra o modal
            document.getElementById("descricaoModal").style.display = "block";
        }

        function fecharModal() {
            // Fecha o modal
            document.getElementById("descricaoModal").style.display = "none";
        }

        // Fecha o modal quando clica fora da janela do modal
        window.onclick = function(event) {
            if (event.target == document.getElementById("descricaoModal")) {
                fecharModal();
            }
        }
    </script>



</body>

</html>