<?php
include("../../database/basedados.php");
include("segurançaAdmin.php");
include("../popup.php");


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
                                $query = "SELECT * 
                                FROM logs_sistema
                                INNER JOIN user ON logs_sistema.Id_user = user.Id_user
                                LEFT JOIN curso ON logs_sistema.Id_curso = curso.Id_curso
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
                                        <td class="coluna-id"> <span>'  . $row['Id_user'] . '</span></td>
                                        <td>' . $row['PNome_user'] . ' ' . $row['SNome_user'] . ' <br><small>' . $row['Email'] . '</small></td>
                                        <td>';
                                    $descricao = $row['Descricao_log'];
                                    $limite = 40;
                                    $proximoLimite = $limite + 20;
                                    $descricao_curta = '';
                                    $descricao_completa = '';

                                    if (strlen($descricao) <= $limite) {
                                        $descricao_curta = $descricao;
                                        $mostrarBotaoVerMais = false;
                                    } else {
                                        $descricaoParte = substr($descricao, $limite, 20);
                                        $posPontoDepois = strpos($descricaoParte, '.');

                                        if ($posPontoDepois !== false) {
                                            $posPontoDepois += $limite;
                                            $descricao_curta = substr($descricao, 0, $posPontoDepois + 1);
                                        } else {
                                            $descricao_curta = substr($descricao, 0, $proximoLimite);
                                        }

                                        $descricao_completa = substr($descricao, strlen($descricao_curta));
                                        $mostrarBotaoVerMais = true;
                                    }
                                    echo '
                                    <span class="descricao-curta">' . htmlspecialchars($descricao_curta) . ' </span>';

                                    if ($mostrarBotaoVerMais) {
                                        echo '
                                        <span class="descricao-completa" style="display: none;">' . htmlspecialchars($descricao_completa) . '</span>
                                       <a style="color: #007bff; text-decoration: none; cursor: pointer;" class="ver-mais-btn" onclick="toggleDescription(this)">Ver mais</a>
                                        ';
                                    }
                                    echo '
                                    </td>

                                        <td>' . $row['Data_log'] . '</td>
                                        <td>' . $row['Tipo_log'] . '</td>
                                        <td style="text-align: center;">
                                            <a onclick="mostrarInfo(' . $row['Id_log'] . ')" style="color: #e74c3c; font-size: 14px; text-decoration: none;">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>


                                    
                                    <div id="verLog_' . $row['Id_log'] . '" class="modal" style="overflow-y: auto;">
                                        <div class="modal-box">
                                            <span class="close" onclick="fecharverLog_(\'verLog_' . $row['Id_log'] . '\');">&times;</span>
                                            <h3 class="modal-title">Informações de log</h3>
                                            
                                            <div class="criacao_curso">
                                                <p class="modal-text">' . $row['Tipo_log'] . '</p>

                                                <div>
                                                    Id log: <span style="
                                                    display: inline-block;
                                                    background-color: #007bff;
                                                    color: white;
                                                    padding: 2px 8px;
                                                    border-radius: 4px;
                                                ">' . $row['Id_log'] . '</span><br>
                                                    Log registada pelo utilizador ' .
                                        (isset($row['PNome_user']) ? $row['PNome_user'] : '') . ' ' .
                                        (isset($row['SNome_user']) ? $row['SNome_user'] : '') .
                                        ' (' . (isset($row['Id_user']) ? $row['Id_user'] : '') . ')<br>
                                                    Data log: ' . $row['Data_log'] . '<br>
                                                    <hr>
                                                    Tipo de log: ' . $row['Tipo_log'] . '<br>
                                                    <label>Descrição log:</label><br>
                                                    <textarea disabled>' . $row['Descricao_log'] . '</textarea>
                                                    <br>
                                                    <hr>
                                                    <h3>Informação detalhada</h3>';

                                    if (isset($row['saldo']) && trim($row['saldo']) !== "") {
                                        echo '<div>';
                                        if ($row['Tipo_log'] == "Levantamento de saldo") {
                                            echo 'Valor de saldo levantado: ' . $row['saldo'];
                                        } else {
                                            echo 'Valor de saldo depositado: ' . $row['saldo'];
                                        }
                                        echo '</div><hr>';
                                    }

                                    if (isset($row['Id_curso']) && trim($row['Id_curso']) !== "") {
                                        echo '<div>
                                                            Curso alterado<br>
                                                            Nome: ' . (isset($row['Nome_curso']) ? $row['Nome_curso'] : '') . ' ,Id:' . $row['Id_curso'] . '
                                                        </div><hr>';
                                    }
                                    if (isset($row['idUserAlterado']) && trim($row['idUserAlterado']) !== "") {

                                        $idUserAlterado = $row['idUserAlterado'];
                                        $stmt = $conn->prepare("SELECT PNome_user, SNome_user FROM user WHERE Id_user = ?");
                                        $stmt->bind_param("i", $idUserAlterado);
                                        $stmt->execute();
                                        $resultUser = $stmt->get_result();

                                        if ($resultUser && $userRow = $resultUser->fetch_assoc()) {
                                            $pNome = $userRow['PNome_user'];
                                            $sNome = $userRow['SNome_user'];
                                            echo '<div>
                                                    Utilizador alterado<br> 
                                                    Nome: ' . $pNome . ' ' . $sNome .
                                            ' ,Id: ' . $idUserAlterado . '
                                                </div><hr>';
                                        } else {
                                            echo '<div>
                                                   Erro ao econtrar os dados do utilizador
                                                </div><hr>';
                                        }
                                        $stmt->close();

                                        
                                    }
                                    if (isset($row['Ficheiro']) && trim($row['Ficheiro']) !== "") {
                                        echo '<div>
                                                            Pagina originaria da log<br>
                                                            Nome: ' . $row['Ficheiro'] . '
                                                        </div>';
                                    }

                                    echo '</div>
                                        </div>
                                    </div>';
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
        function mostrarInfo(idLog) {
            const modal = document.getElementById('verLog_' + idLog);
            modal.style.display = 'block';

        }


        function fecharverLog_(idModal) {
            document.getElementById(idModal).style.display = 'none';
        }


        function toggleDescription(btn) {
            const td = btn.closest('td');
            const curta = td.querySelector('.descricao-curta');
            const completa = td.querySelector('.descricao-completa');

            if (completa.style.display === "none" || completa.style.display === "") {
                completa.style.display = "inline";
                btn.textContent = "Ver menos";
            } else {
                completa.style.display = "none";
                btn.textContent = "Ver mais";
            }
        }
    </script>



</body>

</html>