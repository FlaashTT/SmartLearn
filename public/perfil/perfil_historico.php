<?php
include('../segurança.php');
include("../../database/basedados.sql");


// Definir número de resultados por página
$quantidadePorPagina = 10;

$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $quantidadePorPagina;

// Total de registos para o utilizador
$stmtTotal = $conn->prepare("SELECT COUNT(*) as total FROM historico_compras WHERE Id_user = ?");
$stmtTotal->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
$stmtTotal->execute();
$resultTotal = $stmtTotal->get_result();
$total_registos = $resultTotal->fetch_assoc()['total'];
$total_paginas = ceil($total_registos / $quantidadePorPagina);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartLearn</title>
    <link rel="stylesheet" href="../../assets/fontawesome/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/style_user.css" />
    <link rel="stylesheet" href="../../assets/css/style_perfil_historico.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <?php include("../../src/views/utils/cabecalho.html"); ?>

    <!-- Secção Principal -->
    <div class="banner"></div>
    <main class="container-perfil">

        <?php include("../../src/views/utils/sidebar.html"); ?>

        <section class="content">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Compras de Curso</th>
                            <th>Data</th>
                            <th>Preço</th>
                            <th>Tipo de Pagamento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta com LIMIT para paginação
                        $stmt = $conn->prepare("
                            SELECT * 
                            FROM historico_compras hc
                            INNER JOIN curso c ON hc.Id_curso = c.Id_curso
                            WHERE hc.Id_user = ?
                            ORDER BY hc.Data_compra DESC
                            LIMIT ? OFFSET ?
                        ");
                        $stmt->bind_param("iii", $_SESSION['utilizadorOn']['Id_user'], $quantidadePorPagina, $offset);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '
                                <tr>
                                    <td>' . $row['Nome_curso'] . '</td>
                                    <td>' . $row['Data_compra'] . '</td>
                                    <td>' . $row['Preco'] . '€</td>
                                    <td>' . $row['Tipo_pagamento'] . '</td>';
                                if ($row['Tipo_pagamento'] !== "reembolsado") {
                                    echo '
                                    <td>
                                        <form action="Processo_reembolso.php" method="POST">
                                            <button class="category-btn" type="submit" name="idCurso" value="' . $row['Id_curso'] . '">Reembolso</button>
                                        </form>
                                    </td>
                                </tr>';
                                }
                            }
                        } else {
                            echo '<tr><td colspan="5" class="no-records">Sem registos encontrados.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Paginação -->
                <div class="pagination">
                    <?php if ($pagina_atual > 1) : ?>
                        <a href="?pagina=<?= $pagina_atual - 1 ?>">Anterior</a>
                    <?php endif; ?>

                    <span>Página <?= $pagina_atual ?> de <?= $total_paginas ?></span>

                    <?php if ($pagina_atual < $total_paginas) : ?>
                        <a href="?pagina=<?= $pagina_atual + 1 ?>">Próxima</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Rodapé -->
    <?php
    include("../../src/views/utils/rodape.html");
    ?>
</body>

</html>