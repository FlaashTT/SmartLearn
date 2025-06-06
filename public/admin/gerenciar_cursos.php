<?php
include("segurançaAdmin.php");
include("../../database/basedados.php");

$limite = 10; // cursos por página
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $limite;
$totalPesquisa = '';


$sqlCursos = "SELECT * FROM curso WHERE 1=1";
$params = []; // para parâmetros da query preparada, se usar

if (isset($_POST['FiltroCategoria'])) {
    $filtroCategoria = $_POST['FiltroCategoria'];
    if ($filtroCategoria != 'Todos') {
        $sqlCursos .= " AND Id_categoria = " . $filtroCategoria;
    }
}

if (isset($_POST['FiltroEstado'])) {
    $filtroEstado = $_POST['FiltroEstado'];
    if ($filtroEstado != 'Todos') {
        $sqlCursos .= " AND Estado_curso = '" . $filtroEstado . "'";
    }
}

if (isset($_POST['FiltroPreco'])) {
    $filtroPreco = $_POST['FiltroPreco'];
    if ($filtroPreco != 'Todos') {
        if ($filtroPreco === 'gratuito') {
            $sqlCursos .= " AND Preco = 0 OR Preco is null";
        } else if ($filtroPreco === 'pago') {
            $sqlCursos .= " AND Preco > 0";
        }
    }
}

$resultTotal = $conn->query($sqlCursos);
if ($resultTotal) {
    $totalPesquisa = $resultTotal->num_rows;
} else {
    $totalPesquisa = 0;
}

// 2. Adicionar LIMIT e OFFSET para paginação
$sqlCursosLimit = $sqlCursos . " LIMIT $limite OFFSET $offset";
$resultLimit = $conn->query($sqlCursosLimit);
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
    <link rel="stylesheet" href="../../assets/css/admin/style_curso_gerenciar.css" />
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
                        <i style="font-size: 18px; margin-right: 10px;" class="fas fa-tachometer-alt"></i> Gerenciar Cursos
                    </h1>
                    <button style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                        Adicionar Novo Curso
                    </button>
                </section>

                <section class="page">
                    <h1>Lista de Cursos</h1>
                    <div class="stats">
                        <div class="stat">
                            <i class="fas fa-book"></i>
                            <span>

                                <?php
                                $query = "SELECT COUNT(*) AS total FROM curso WHERE Estado_curso = 'ativo'";
                                $result = $conn->query($query);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total = $row['total'];
                                    echo $total;
                                } else {
                                    echo "Erro ao contar cursos.";
                                }
                                ?>

                            </span>
                            <p>Cursos Ativos</p>
                        </div>
                        <div class="stat">
                            <i class="fas fa-file-alt"></i>
                            <span>

                                <?php
                                $query = "SELECT COUNT(*) AS total FROM curso WHERE Estado_curso != 'ativo'";
                                $result = $conn->query($query);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total = $row['total'];
                                    echo $total;
                                } else {
                                    echo "Erro ao contar cursos.";
                                }
                                ?>

                            </span>
                            <p>Cursos pendentes</p>
                        </div>
                        <div class="stat">
                            <i class="fas fa-user-check"></i>
                            <span>

                                <?php
                                $query = "SELECT COUNT(*) AS total FROM curso WHERE Preco = 0 OR Preco IS NULL";
                                $result = $conn->query($query);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total = $row['total'];
                                    echo $total;
                                } else {
                                    echo "Erro ao contar cursos.";
                                }
                                ?>

                            </span>
                            <p>Cursos gratuitos</p>
                        </div>
                        <div class="stat">
                            <i class="fas fa-users"></i>
                            <span>

                                <?php
                                $query = "SELECT COUNT(*) AS total FROM curso WHERE Preco > 0";
                                $result = $conn->query($query);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total = $row['total'];
                                    echo $total;
                                } else {
                                    echo "Erro ao contar cursos.";
                                }
                                ?>

                            </span>
                            <p>Cursos Pagos</p>
                        </div>
                    </div>
                </section>
                <form method="POST" action="">
                    <section class="course-list">
                        <h2>Lista de cursos</h2>
                        <div class="filters">

                            <label for="categories">Categorias</label>
                            <div>

                                <select id="categories" name="FiltroCategoria">
                                    <option value="Todos" <?= (isset($_POST['FiltroCategoria']) && $_POST['FiltroCategoria'] == 'Todos') ? 'selected' : '' ?>>Todos</option>
                                    <?php
                                    $query = "SELECT * FROM categoria";
                                    $stmt = $conn->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $selected = (isset($_POST['FiltroCategoria']) && $_POST['FiltroCategoria'] == $row['Id_categoria']) ? 'selected' : '';
                                            echo '<option value="' . $row['Id_categoria'] . '" ' . $selected . '>' . $row['Nome_cat'] . '</option>';
                                        }
                                    } else {
                                        echo '<option disabled>Nenhuma categoria encontrada</option>';
                                    }
                                    ?>
                                </select>

                            </div>

                            <label for="estado">Estado</label>
                            <div>
                                <select id="estado" name="FiltroEstado">
                                    <?php
                                    $estados = ['Todos', 'ativo', 'pendente', 'inativo', 'Incompleto'];
                                    foreach ($estados as $estado) {
                                        $selected = (isset($_POST['FiltroEstado']) && $_POST['FiltroEstado'] == $estado) ? 'selected' : '';
                                        echo "<option value=\"$estado\" $selected>" . ucfirst($estado) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <label for="preco">Preço</label>
                            <div>
                                <select id="preco" name="FiltroPreco">
                                    <?php
                                    $precos = ['Todos', 'gratuito', 'pago'];
                                    foreach ($precos as $preco) {
                                        $selected = (isset($_POST['FiltroPreco']) && $_POST['FiltroPreco'] == $preco) ? 'selected' : '';
                                        echo "<option value=\"$preco\" $selected>" . ucfirst($preco) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit">Filtrar</button>

                        </div>
                </form>


                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Categoria</th>
                            <th>Utilizadores inscrito</th>
                            <th>Status</th>
                            <th>Preço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php


                        if ($resultLimit && $resultLimit->num_rows > 0) {
                            while ($row = $resultLimit->fetch_assoc()) {

                                //select da categoria
                                if (isset($row['Id_categoria']) && !empty($row['Id_categoria'])) {
                                    $stmtCategoria = $conn->prepare("SELECT Nome_cat FROM categoria WHERE Id_categoria = ?");
                                    $stmtCategoria->bind_param("i", $row['Id_categoria']);
                                    $stmtCategoria->execute();
                                    $resultCategoria = $stmtCategoria->get_result();

                                    if ($resultCategoria->num_rows > 0) {
                                        $rowCategoria = $resultCategoria->fetch_assoc();
                                        $Categoria = $rowCategoria['Nome_cat'];
                                    } else {
                                        $Categoria = "Categoria não encontrada";
                                    }
                                } else {
                                    $Categoria = "Sem categoria";
                                }



                                //para contagem o numero de utilizadores com curso comprado 
                                $stmtContagem = $conn->prepare("SELECT COUNT(*) AS total FROM cursos_adquiridos WHERE Id_curso = ?");
                                $stmtContagem->bind_param("i", $row['Id_curso']);
                                $stmtContagem->execute();
                                $resultContagem = $stmtContagem->get_result();
                                $rowContagem = $resultContagem->fetch_assoc();

                                $total = $rowContagem['total'];




                                echo '
                                        <tr>
                                    <td>' . $row['Id_curso'] . '</td>
                                    <td>' . $row['Nome_curso'] . '</td>
                                    <td>' . $Categoria . '</td>
                                    <td>' . $total . '</td>
                                    <td>' . $row['Estado_curso'] . '</td>
                                    <td>' . (empty($row['Preco']) || $row['Preco'] == 0 ? 'Gratuito' : $row['Preco'] . '€') . '</td>
                                    <td onclick="mostrarInfo(' . $row['Id_curso'] . ')" style="cursor: pointer;">Ver detalhes curso</td>

                                    </tr>
                                ';
                            }
                        } else {

                            echo '
                                    <tr>
                                    <td colspan="7">Nenhum dado inserido</td>
                                    </tr>';
                        }


                        echo '
                                <form method="POST" action="acoes/eliminarUser.php" style="margin: 0;">
                                <input type="hidden" name="idEliminar" id="idEliminar" value="">
                                
                                <div id="eliminarModal" class="modal">
                                    <div class="modal-box">
                                    <span class="close" onclick="fecharModal(\'eliminarModal\')">&times;</span>
                                    <h3 class="modal-title">Tens a certeza?</h3>
                                    <p class="modal-text">Queres mesmo eliminar <strong>Joana Silva</strong>?</p>
                                    
                                    <div class="modal-buttons">
                                        <button type="button" onclick="fecharModal(\'eliminarModal\')">Cancelar</button>
                                        <button type="submit" class="red">Eliminar</button>
                                    </div>
                                    </div>
                                </div>
                                </form>


                                            ';





                        $totalPaginas = ceil($totalPesquisa / $limite);
                        ?>
                    </tbody>
                </table>

                <div class="pagination">
                    <?php if ($paginaAtual > 1): ?>
                        <a href="?pagina=<?= $paginaAtual - 1 ?>">Anterior</a>
                    <?php endif; ?>

                    <span>Página <?= $paginaAtual ?> de <?= $totalPaginas ?></span>

                    <?php if ($paginaAtual < $totalPaginas): ?>
                        <a href="?pagina=<?= $paginaAtual + 1 ?>">Próximo</a>
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
        function mostrarInfo(idCurso) {
            const modal = document.getElementById('eliminarModal');
            modal.style.display = 'block';

            // Coloca o idCurso no input hidden
            document.getElementById('idEliminar').value = idCurso;

            // Se quiser mostrar o idCurso no texto do modal, por exemplo:
            modal.querySelector('p.modal-text').innerHTML = `Tens a certeza que queres eliminar o curso com ID <strong>${idCurso}</strong>?`;
        }

        function fecharModal(idModal) {
            document.getElementById(idModal).style.display = 'none';
        }
    </script>
</body>

</html>