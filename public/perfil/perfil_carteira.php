<?php
include("../segurança.php");
include("../../database/basedados.sql");
include("pesquisa.php");

$textoPesquisa = isset($_POST['search']) ? '%' . $_POST['search'] . '%' : null;

// Número de cursos por página
$por_pagina = 9;

// Calcular a página atual
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $por_pagina;

// Consultar o número total de cursos
$sql_total = "SELECT COUNT(*) as total FROM logs_sistema WHERE Id_user = ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total_cursos = $result_total->fetch_assoc()['total'];

// Calcular o número total de páginas
$total_paginas = ceil($total_cursos / $por_pagina);


$sql = pesquisaFiltro("logs_sistema", $_SESSION['utilizadorOn']['Id_user'], null, $textoPesquisa);
$sql .= " LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

if ($textoPesquisa) {
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
    <link
        rel="stylesheet"
        href="../../assets/fontawesome/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/style_user.css" />
    <link rel="stylesheet" href="../../assets/css/style_perfil_carteira.css" />
    <script src="../../assets/js/perfil_carteira.js"></script>
</head>

<body>
    <!-- Cabeçalho -->
    <?php
    include("../../src/views/utils/cabecalho.html")
    ?>

    <!-- Secção Principal (Hero) -->
    <div class="banner"></div>
    <main class="container-perfil">

        <?php
        include("../../src/views/utils/sidebar.html")
        ?>

        <section class="content">
            <div class="wallet-container">
                <div class="wallet-header">Carteira</div>
                <!-- Saldo Atual -->
                <div id="saldo" class="wallet-balance">
                    Saldo disponível: <strong><?php echo number_format($_SESSION['utilizadorOn']['Carteira'], 2, ',', ''); ?></strong>
                </div>
                <div class="wallet-actions">


                    <div class="action">
                        <form action="adicionarSaldo.php" method="post">
                            <h3>Adicionar Saldo</h3>
                            <input name="adicionarSaldo" type="number" id="adicionarSaldo" min="5" placeholder="Valor a adicionar (€)" />
                            <button id="btnAdicionarSaldo">Adicionar</button>
                        </form>
                    </div>



                    <div class="action">
                        <form action="levantarSaldo.php" method="post">
                            <h3>Levantar Saldo</h3>
                            <input type="number" name="levantarSaldo" id="levantarSaldo" min="1" placeholder="Valor a levantar (€)" />
                            <button id="btnLevantarSaldo">Levantar</button>
                        </form>
                    </div>

                </div>
                <!-- Historico -->
                <div class="wallet-history">
                    <h3>Histórico de Transações</h3>
                    <!-- Filtro -->


                    <div class="filter">
                        <input type="text" id="filter-input" placeholder="Filtrar por data, descrição..." />
                        <button id="filter-button" style="padding: 10px 16px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Filtrar</button>
                    </div>


                    <table id="transactions-table">
                        <?php
                        if ($result->num_rows > 0) {
                            $comResultado = true;
                            echo '
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Descrição</th>
                                        <th>Valor (€)</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                ';
                            while ($row = $result->fetch_assoc()) {



                                echo '
                                    <tr>
                                        <td>' . $row['Data_log'] . '</td>
                                        <td>' . $row['Tipo_log'] . '</td>
                                        ';
                                if ($row['Tipo_log'] == "Levantamento de saldo" || $row['Tipo_log'] == "Compra curso") {
                                    echo '<td class="negative">-' . number_format($row['saldo'], 2, ',', '') . '€</td>';
                                } else {
                                    echo '<td class="positive">+' . number_format($row['saldo'], 2, ',', '') . '€</td>';
                                }
                                echo '  
                                    </tr>
                                    ';
                            }
                        } else {
                            $comResultado = false;
                            echo '
                                <tr>
                                <td>
                                    Sem registo de movimentos anteriores
                                </td>
                                    </tr>
                                ';
                        }
                        ?>
                        <!--
                            <tr>
                                <td>01/01/2025</td>
                                <td>Adição de saldo</td>
                                <td class="positive">+50.00€</td>
                            </tr>
                            <tr>
                                <td>15/01/2025</td>
                                <td>Levantamento de saldo</td>
                                <td class="negative">-20.00€</td>
                            </tr>
                            <tr>
                                <td>20/01/2025</td>
                                <td>Compra de curso</td>
                                <td class="negative">-20.00€</td>
                            </tr>
                        -->
                        </tbody>
                    </table>
                    <?php

                    if ($comResultado) {
                        echo '

                        <div class="pagination">
                            <!-- Paginação (Exemplo)-->
                            <button class="prev">Anterior</button>
                            <button class="next">Próximo</button>
                        </div>
';
                    } else {
                        echo '';
                    }
                    ?>


                </div>
        </section>
    </main>

    <!-- Rodapé -->
    <?php
    include("../../src/views/utils/rodape.html")
    ?>
</body>

</html>