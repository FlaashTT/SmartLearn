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
    <link rel="stylesheet" href="../../assets/css/admin/style_base_admin.css" />
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
                <section class="main-content">
                    <h1 style="display: flex; align-items: center; justify-content: left;">
                        <i style="font-size: 18px; margin-right: 10px;" class="fas fa-tachometer-alt"></i> Painel
                    </h1>
                </section>

                <section class="page">
                    <h1>Histórico Administrativo Este Ano</h1>
                    <div class="page-grafic">
                        <canvas class="grafic" id="monthlyChart"></canvas>
                    </div>
                    <div class="stats">
                        <div class="stat">
                            <i class="fas fa-book"></i>
                            <span id="numCursos">
                                <?php
                                $query = "SELECT COUNT(*) AS total FROM curso";
                                $result = $conn->query($query);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total = $row['total'];
                                    echo '<span class="coluna-id"><span>' . $total . '</span></span>';
                                } else {
                                    echo '<span class="coluna-id"><span>Erro</span></span>';
                                }
                                ?>
                            </span>
                            <p>Número de cursos</p>
                        </div>

                        <div class="stat">
                            <i class="fas fa-file-alt"></i>
                            <span id="numCapitulos">

                                <?php
                                $query = "SELECT COUNT(*) AS total FROM fase";
                                $result = $conn->query($query);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total = $row['total'];
                                    echo '<span class="coluna-id"><span>' . $total . '</span></span>';
                                } else {
                                    echo '<span class="coluna-id"><span>Erro</span></span>';
                                }
                                ?>

                            </span>
                            <p>Número de capítulos</p>
                        </div>
                        <div class="stat">
                            <i class="fas fa-user-check"></i>
                            <span id="numInscricoes">

                                <?php
                                $query = "SELECT COUNT(*) AS total FROM cursos_adquiridos";
                                $result = $conn->query($query);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total = $row['total'];
                                    echo '<span class="coluna-id"><span>' . $total . '</span></span>';
                                } else {
                                    echo '<span class="coluna-id"><span>Erro</span></span>';
                                }
                                ?>

                            </span>
                            <p>Número de inscrições</p>
                        </div>
                        <div class="stat">
                            <i class="fas fa-users"></i>
                            <span id="numUtilizadores">

                                <?php
                                $query = "SELECT COUNT(*) AS total FROM user";
                                $result = $conn->query($query);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $total = $row['total'];
                                    echo '<span class="coluna-id"><span>' . $total . '</span></span>';
                                } else {
                                    echo '<span class="coluna-id"><span>Erro</span></span>';
                                }
                                ?>

                            </span>
                            <p>Número de utilizadores</p>
                        </div>
                    </div>
                </section>
            </main>
        </main>
    </div>

    <?php
    //select da quantidade utilizadores registados 
    $sql = "SELECT count FROM user WHERE Id_user = ?";

    //qunatidade de cursos


    //quantidade de cursos comprados 


    ?>

    <script
        src="https://cdn.jsdelivr.net/npm/chart.js">
    </script>
    <script>
        document.querySelectorAll('.has-submenu').forEach(item => {
            item.addEventListener('click', () => {
                item.classList.toggle('open');
            });
        });

        document.querySelectorAll('.has-submenu-a').forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation(); // Impede o clique de subir
                item.classList.toggle('open');
            });
        });


        // Dados do gráfico
        // Dados fictícios por agora — podes substituí-los por dados reais vindos do PHP se quiseres
        const data = {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            datasets: [{
                    label: 'Cursos',
                    data: [3, 5, 6, 8, 10, 9, 7, 6, 9, 11, 12, 14],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Capítulos',
                    data: [10, 12, 14, 18, 20, 22, 24, 26, 28, 30, 32, 35],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Inscrições',
                    data: [8, 12, 15, 17, 20, 23, 26, 30, 34, 37, 40, 45],
                    borderColor: 'rgba(255, 206, 86, 1)',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Utilizadores',
                    data: [5, 7, 10, 13, 15, 18, 22, 25, 28, 30, 32, 35],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    tension: 0.4
                }
            ]
        };

        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Atividade Mensal por Categoria'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total por mês'
                        }
                    }
                }
            }
        });

        /*
               // Atualizar os números nos spans
               document.getElementById('numCursos').textContent = data.datasets[0].data.reduce((a, b) => a + b, 0); // Soma total dos dados
               document.getElementById('numCapitulos').textContent = 50; // Exemplo de valor fixo
               document.getElementById('numInscricoes').textContent = 120; // Exemplo de valor fixo
               document.getElementById('numUtilizadores').textContent = 300; // Exemplo de valor fixo*/
    </script>
</body>

</html>