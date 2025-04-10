<?php

include('../segurança.php');
include("../../database/basedados.sql");
echo"Saldo disponivel ".$_SESSION['utilizadorOn']['Carteira'];
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


                        $stmt = $conn->prepare("
                            SELECT * 
                            FROM historico_compras hc
                            INNER JOIN curso c ON hc.Id_curso = c.Id_curso
                            WHERE hc.Id_user = ?
                            ORDER BY hc.Data_compra DESC;
                            ");
                        $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $preçoTotal = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo'
                                <tr>
                                    <td>'.$row['Nome_curso'].'</td>
                                    <td>'.$row['Data_compra'].'</td>
                                    <td>'.$row['Preco'].'</td>
                                    <td>'.$row['Tipo_pagamento'].'</td>
                                    <form action="Processo_reembolso.php" method="POST">
                                        <td>
                                            <button class="category-btn" type="submit" name="idCurso" value="' . $row['Id_curso'] . '">Reembolso</button>
                                        </td>
                                    </form>
                                </tr>
                                ';
                            }
                        }

                        ?>
                        

                        <tr>
                            <td colspan="5" class="no-records">No records found</td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination">

                </div>
            </div>

        </section>
    </main>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="footer-map">
            <iframe src="" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="container footer-content">
            <p>2025 Copyright by Leando Pinto e Ruben Pinheiro</p>
            <p>Castelo Branco – Rua Esperança – 6200-000</p>
            <p>Email: teste@gmail.com | Telefone: 255 777 222 | Fax: 966 662 222</p>
            <p>Privacy Policy | Terms & Conditions</p>
        </div>
    </footer>

</body>

</html>