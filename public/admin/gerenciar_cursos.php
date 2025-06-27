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
                        <i style="font-size: 18px; margin-right: 10px;" class="fas fa-tachometer-alt"></i> Gerir Cursos
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
                                $idCurso = $row['Id_curso'];

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
                                    <td class="coluna-id"> <span>' . $row['Id_curso'] . '</span></td>
                                    <td>' . $row['Nome_curso'] . '</td>
                                    <td>' . $Categoria . '</td>
                                    <td>' . $total . '</td>
                                    <td>' . $row['Estado_curso'] . '</td>
                                    <td>' . (empty($row['Preco']) || $row['Preco'] == 0 ? 'Gratuito' : $row['Preco'] . '€') . '</td>
                                    <td onclick="mostrarInfo(' . $idCurso . ')" style="cursor: pointer;">Ver detalhes curso</td>

                                    </tr>
                                ';


                                $idCriador = (int)$row['Criador_curso'];
                                $sqlCriador = "SELECT PNome_user,SNome_user FROM user WHERE Id_user = $idCriador";
                                $resultCriador = $conn->query($sqlCriador);

                                if ($resultCriador && $resultCriador->num_rows > 0) {
                                    $rowCriador = $resultCriador->fetch_assoc();
                                    $nomeCriador = $rowCriador['PNome_user'] . ' ' . $rowCriador['SNome_user'] . ' (' . $idCriador . ')';
                                } else {
                                    $nomeCriador = "Utilizador não encontrado";
                                }


                                echo '
                                        <div id="eliminarModal_' . $idCurso . '" class="modal" style="overflow-y: auto;">
                                            <div class="modal-box">
                                                <span class="close" onclick="fecharModal(\'eliminarModal_' . $idCurso . '\'); resetarQuantidadeMaxima(); resetarQuantidadeMaximaUtilizadores()">&times;</span>
                                                <h3 class="modal-title">' . $row['Nome_curso'] . '</h3>
                                                
                                                <div class="criacao_curso">
                                                <p class="modal-text">Criação do curso</p>

                                                <p>
                                                    Criado em: <span class="azul-texto">' . $row['Data_criacao'] . '</span><br>
                                                    ';
                                                    if($nomeCriador === "Utilizador não encontrado") {
                                                        echo 'Criado por: <span class="vermelho-texto">Criador não encontrado</span><br>';
                                                    } else {
                                                        echo 'Criado por: <span class="azul-texto">' . $nomeCriador  . '</span><br>';
                                                    }
                                                    echo '
                                                </p>
                                            </div>

                                                                                           
                                    ';

                                echo '<div class="section-modal">
                                <div class="updates" >                                             
                                        <p class="modal-text">Últimos updates <br><span id="aMostrar"> A mostrar 5  resultados</span></p>
                                        <div class="logs_model" id="logsContainer">';

                                $selectUpdates = "
                                        SELECT logs_sistema.*, user.PNome_user AS Nome, user.SNome_user AS SNome
                                        FROM logs_sistema 
                                        INNER JOIN user ON logs_sistema.Id_user = user.Id_user 
                                        WHERE logs_sistema.Id_curso = $idCurso AND (logs_sistema.Tipo_log = 'Alteração de curso' OR logs_sistema.Tipo_log = 'Curso eliminado') 
                                        ORDER BY logs_sistema.Data_log DESC 
                                    ";
                                $resultUpdates = $conn->query($selectUpdates);
                                if ($resultUpdates && $resultUpdates->num_rows > 0) {
                                    $quantidadeExibida = 1;
                                    $totalUpdates = $resultUpdates->num_rows;
                                    echo '<input type="hidden" id="totalUpdates" value="' . $totalUpdates . '">';
                                    while ($rowUpdate = $resultUpdates->fetch_assoc()) {
                                        echo '<div class="lastUpdates" data-quantidade="' . $quantidadeExibida . '" data-total="' . $totalUpdates . '" style="margin-bottom: 10px;">' . $rowUpdate['Descricao_log'] . ' - ' . $rowUpdate['Data_log'] . '<br>
                                            Realizado por: ' . $rowUpdate['Nome'] . ' ' . $rowUpdate['SNome'] . ' <span style="background-color: #007bff; color: white; padding: 2px 6px; border-radius: 4px;">ID: ' . $rowUpdate['Id_user'] . '</span>
                                            <hr style="margin-bottom: 10px; margin-top: 10px;">
                                            </div>';
                                        $quantidadeExibida++;
                                    }
                                    echo '<button id="verMaisUpdates" type="button" onclick="vermais()" style="display: none; margin-top: 10px; padding: 5px 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;"> Ver + </button> ';
                                } else {
                                    echo '<p class="modal-text" style="font-weight: bold;">Nenhum update encontrado</p>';
                                }
                                echo '</div>';
                                echo '</div>';

                                $result = $conn->query("SELECT COUNT(*) AS total FROM cursos_adquiridos WHERE Id_curso = $idCurso");
                                $totalInscritos = 0;
                                if ($result && $row = $result->fetch_assoc()) {
                                    $totalInscritos = $row['total'];
                                }

                                echo '
                                <div class="inscritos" >
                                        <p class="modal-text">Listagem dos utilizadores<br> <span>A mostrar <span id="quantidadeInscritosMostar">5</span> de ' . $totalInscritos . ' utilizadores </span></p>
                                        <div class="logs_model" id="listagemUtilizadores">';

                                if ($totalInscritos > 0) {
                                    $stmtUtilizadores = $conn->prepare("SELECT user.PNome_user, user.SNome_user, cursos_adquiridos.Data_compra, cursos_adquiridos.Progresso, cursos_adquiridos.Id_user 
                                                                            FROM cursos_adquiridos 
                                                                            INNER JOIN user ON cursos_adquiridos.Id_user = user.Id_user
                                                                            WHERE cursos_adquiridos.Id_curso = ?
                                                                            ORDER BY cursos_adquiridos.Data_compra DESC");
                                    $stmtUtilizadores->bind_param("i", $idCurso);
                                    $stmtUtilizadores->execute();
                                    $resultUtilizadores = $stmtUtilizadores->get_result();

                                    if ($resultUtilizadores && $resultUtilizadores->num_rows > 0) {
                                        echo '<input type="hidden" id="totalUtilizadores" data-total="' . $totalInscritos . '">';
                                        $count = 0;
                                        while ($rowUtilizador = $resultUtilizadores->fetch_assoc()) {
                                            $count++;
                                            echo '<div data-contagem="' . $count . '" class="MostrarUtilizadores" style="margin-bottom: 10px;"> 
                                                            #' . $count . ' - Nome: ' . htmlspecialchars($rowUtilizador['PNome_user']) . ' ' . htmlspecialchars($rowUtilizador['SNome_user']) . ' 
                                                            ID:<span style="background-color: #007bff; color: white; padding: 2px 6px; border-radius: 4px;">' . htmlspecialchars($rowUtilizador['Id_user']) . '</span><br>
                                                            <strong>Data de compra:</strong> ' . htmlspecialchars($rowUtilizador['Data_compra']) . '<br>
                                                            <strong>Progresso :</strong> ' . htmlspecialchars($rowUtilizador['Progresso']) . '
                                                            <hr style="margin-bottom: 10px; margin-top: 10px;">
                                                        </div>';
                                        }
                                        echo '<button 
                                                        id="verMaisUtilizadores" 
                                                        type="button" 
                                                        onclick="vermaisUtilizadores()" 
                                                        style="display:none; margin-top: 10px; padding: 5px 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                        Ver +
                                                    </button>';
                                    } else {
                                        echo '<p class="modal-text">Nenhum utilizador inscrito encontrado</p>';
                                    }
                                    echo '</div>';
                                } else {
                                    echo '<p class="modal-text">Nenhum utilizador inscrito encontrado</p>';
                                }

                                $selectInfoCurso = "
                                    SELECT 
                                        curso.*,
                                        idioma.Nome_idioma as idioma
                                    FROM curso
                                    INNER JOIN idioma ON curso.Id_idioma = idioma.Id_idioma
                                    WHERE curso.Id_curso = ?
                                ";
                                $stmtInfoCurso = $conn->prepare($selectInfoCurso);
                                $stmtInfoCurso->bind_param("i", $idCurso);
                                $stmtInfoCurso->execute();
                                $resultInfoCurso = $stmtInfoCurso->get_result();
                                $rowInfoCurso = $resultInfoCurso->fetch_assoc();

                                echo '</div>
                                </div>
    
                                    <div class="info-curso">
                                        <p class="modal-text">Informações do curso</p>

                                        <label>Título:</label>
                                        <input type="text" value="' . $rowInfoCurso['Nome_curso'] . '" disabled><br>

                                        <label>Descrição:</label>
                                        <textarea disabled>' . $rowInfoCurso['Descricao'] . '</textarea><br>

                                        <label>Estado:</label>
                                        <input type="text" value="' . $rowInfoCurso['Estado_curso'] . '" disabled><br>

                                        <label>Preço atual:</label>
                                        <input type="text" value="' . (empty($rowInfoCurso['Preco']) || $rowInfoCurso['Preco'] == 0 ? 'Gratuito' : $rowInfoCurso['Preco'] . '€') . '" disabled><br>

                                        <label>Preço antigo:</label>
                                        <input type="text" value="' . (empty($rowInfoCurso['Preco_antigo']) || $rowInfoCurso['Preco_antigo'] == 0 ? 'Sem preço anterior' : $rowInfoCurso['Preco_antigo'] . '€') . '" disabled><br>

                                        <label>Idioma:</label>
                                        <input type="text" value="' . $rowInfoCurso['idioma'] . '" disabled><br>

                                        <label>Estado do curso:</label>
                                        <input type="text" value="' . $rowInfoCurso['Estado_curso'] . '" disabled><br>

                                        <label>Número de visitas:</label>
                                        <input type="text" value="' . $rowInfoCurso['Num_visitascurso'] . '" disabled><br>

                                        <label>Classificação:</label>
                                        <input type="text" value="' . $rowInfoCurso['Classificacao'] . '" disabled><br>

                                        <label>Dificuldade:</label>
                                        <input type="text" value="' . $rowInfoCurso['Dificuldade'] . '" disabled><br>

                                        <label>Requisitos:</label>
                                        <textarea disabled>' . $rowInfoCurso['Requisitos'] . '</textarea><br>

                                        <label>Provedor de curso:</label>
                                        <input type="text" value="' . $rowInfoCurso['Provedor_geral_curso'] . '" disabled><br>

                                        <label>Tempo estimado:</label>
                                        <input type="text" value="' . $rowInfoCurso['Tempo_estimado'] . '" disabled><br>
                                    </div>
                                        </div>
                                    </div>';
                            }
                        } else {

                            echo '
                                    <tr>
                                    <td colspan="7">Nenhum dado inserido</td>
                                    </tr>';
                        }



                        $totalPaginas = ceil($totalPesquisa / $limite);
                        ?>
                    </tbody>
                </table>

                <div class="pagination" style="margin-top: 20px;">
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
            const modal = document.getElementById('eliminarModal_' + idCurso);
            modal.style.display = 'block';

        }


        function fecharModal(idModal) {
            document.getElementById(idModal).style.display = 'none';
        }
    </script>


    <script>
        let quantidadeMaxima = 5; // controla quantos mostrar inicialmente

        document.addEventListener('DOMContentLoaded', () => {
            const totalElement = document.getElementById('totalUpdates');
            const total = totalElement ? Number(totalElement.value || totalElement.getAttribute('data-total')) : 0;
            const BtnVerMaisUpdates = document.getElementById('verMaisUpdates');
            const paragrafos = document.querySelectorAll('div.lastUpdates[data-quantidade]');

            mostrarParagrafos(paragrafos, quantidadeMaxima);

            if (total > quantidadeMaxima) {
                BtnVerMaisUpdates.style.display = 'inline-block';
            } else {
                BtnVerMaisUpdates.style.display = 'none';
            }

            document.getElementById('aMostrar').innerText = 'A mostrar ' + Math.min(quantidadeMaxima, total) + ' de ' + total + ' resultados';
        });

        function mostrarParagrafos(paragrafos, limite) {
            paragrafos.forEach(p => {
                const quantidade = Number(p.getAttribute('data-quantidade'));
                p.style.display = (quantidade <= limite) ? 'block' : 'none';
            });
        }

        function vermais() {
            const totalElement = document.getElementById('totalUpdates');
            const total = totalElement ? Number(totalElement.value || totalElement.getAttribute('data-total')) : 0;
            const BtnVerMaisUpdates = document.getElementById('verMaisUpdates');
            const paragrafos = document.querySelectorAll('div.lastUpdates[data-quantidade]');

            quantidadeMaxima += 5;

            mostrarParagrafos(paragrafos, quantidadeMaxima);
            document.getElementById('aMostrar').innerText = 'A mostrar ' + Math.min(quantidadeMaxima, total) + ' de ' + total + ' resultados';

            if (quantidadeMaxima >= total) {
                BtnVerMaisUpdates.style.display = 'none';
            }
        }

        function resetarQuantidadeMaxima() {
            quantidadeMaxima = 5;

            const totalElement = document.getElementById('totalUpdates');
            const total = totalElement ? Number(totalElement.value || totalElement.getAttribute('data-total')) : 0;
            const BtnVerMaisUpdates = document.getElementById('verMaisUpdates');
            const paragrafos = document.querySelectorAll('div.lastUpdates[data-quantidade]');

            mostrarParagrafos(paragrafos, quantidadeMaxima);

            if (total > quantidadeMaxima) {
                BtnVerMaisUpdates.style.display = 'inline-block';
            } else {
                BtnVerMaisUpdates.style.display = 'none';
            }

            document.getElementById('aMostrar').innerText = 'A mostrar ' + Math.min(quantidadeMaxima, total) + ' de ' + total + ' resultados';
        }
    </script>

    <script>
        let quantidadeMaximaUtilizadores = 5;

        function mostrarUtilizadores(paragrafos, limite) {
            paragrafos.forEach(p => {
                const contagem = Number(p.getAttribute('data-contagem'));
                p.style.display = (contagem <= limite) ? 'block' : 'none';
            });
            document.getElementById('quantidadeInscritosMostar').innerText = Math.min(limite, paragrafos.length);
        }

        function vermaisUtilizadores() {
            const totalElement = document.getElementById('totalUtilizadores');
            const total = totalElement ? Number(totalElement.getAttribute('data-total')) : 0;
            const btn = document.getElementById('verMaisUtilizadores');
            const paragrafos = document.querySelectorAll('#listagemUtilizadores div.MostrarUtilizadores');

            quantidadeMaximaUtilizadores += 5;

            mostrarUtilizadores(paragrafos, quantidadeMaximaUtilizadores);

            if (quantidadeMaximaUtilizadores >= total) {
                btn.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const totalElement = document.getElementById('totalUtilizadores');
            const total = totalElement ? Number(totalElement.getAttribute('data-total')) : 0;
            const btn = document.getElementById('verMaisUtilizadores');
            const paragrafos = document.querySelectorAll('#listagemUtilizadores div.MostrarUtilizadores');

            mostrarUtilizadores(paragrafos, quantidadeMaximaUtilizadores);

            if (total > quantidadeMaximaUtilizadores) {
                btn.style.display = 'inline-block';
            } else {
                btn.style.display = 'none';
            }
        });

        function resetarQuantidadeMaximaUtilizadores() {
            quantidadeMaximaUtilizadores = 5;

            const totalElement = document.getElementById('totalUtilizadores');
            const total = totalElement ? Number(totalElement.getAttribute('data-total')) : 0;
            const btn = document.getElementById('verMaisUtilizadores');
            const paragrafos = document.querySelectorAll('#listagemUtilizadores div.MostrarUtilizadores');

            mostrarUtilizadores(paragrafos, quantidadeMaximaUtilizadores);

            if (total > quantidadeMaximaUtilizadores) {
                btn.style.display = 'inline-block';
            } else {
                btn.style.display = 'none';
            }

            document.getElementById('quantidadeInscritosMostar').innerText = quantidadeMaximaUtilizadores;
        }
    </script>


    </script>
</body>

</html>