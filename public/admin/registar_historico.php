<?php
include("../../database/basedados.sql");
include("segurançaAdmin.php");


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
    <link rel="stylesheet" href="../../assets/css/admin/style_inscricao_historico.css" />
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
                        <i style="font-size: 18px; margin-right: 10px;" class="fa-solid fa-user-plus"></i> Registro do historico
                    </h1>
                </section>

                <section class="course-list">
                    <h2>Historico</h2>
                    <div class="filters">
                        <div class="search-container">
                            <input type="text" id="searchInput" placeholder="Pesquisar...">
                            <button>Filtrar</button>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div>
                            Mostrar
                            <select style="padding: 5px 10px; margin: 0 5px;">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            entradas
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nome | Email</th>
                                <th>Curso</th>
                                <th>Data de Acesso</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="">
                                        <img class="avatar" src="/assets/image/Admin.png" alt="Avatar Joana">
                                    </div>
                                </td>
                                <td>Joana Silva<br><small>joana@email.com</small></td>
                                <td>Desenvolvimento Web</td>
                                <td>2025-04-14 15:23</td>
                                <td>
                                    <a href="#" style="color: #e74c3c; font-size: 14px; text-decoration: none;">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="">
                                        <img class="avatar" src="/assets/image/Admin.png" alt="Avatar Joana">
                                    </div>
                                </td>
                                <td>Joana Silva<br><small>joana@email.com</small></td>
                                <td>Desenvolvimento Web</td>
                                <td>2025-04-14 15:23</td>
                                <td>
                                    <a href="#" style="color: #e74c3c; font-size: 14px; text-decoration: none;">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="margin-top: 10px; font-size: 14px; color: #666;">
                        A mostrar 0 a 0 de 0 entradas
                    </div>

                    <div class="pagination">
                        <button>Anterior</button>
                        <button>Próximo</button>
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

</body>

</html>