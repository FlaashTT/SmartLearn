<?php
include("../../database/basedados.php");
include("segurançaAdmin.php");

$quantidadePesquisa = 0;
$limite = isset($_GET['limite']) ? intval($_GET['limite']) : 10;
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$textoPesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
$offset = ($pagina - 1) * $limite;
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
                        <form method="GET" action="registar_historico.php">
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
                                <th>Foto</th>
                                <th>Nome | Email</th>
                                <th>Curso</th>
                                <th>Data de Acesso</th>
                                <th>Adicionado por</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($textoPesquisa != '') {
                                $query = "SELECT cursos_adquiridos.*, user.*, curso.*, adicionador.Pnome_user AS NomeAdicionadoPor
                                            FROM cursos_adquiridos
                                            INNER JOIN user ON cursos_adquiridos.Id_user = user.Id_user
                                            INNER JOIN curso ON cursos_adquiridos.Id_curso = curso.Id_curso
                                            LEFT JOIN user AS adicionador ON cursos_adquiridos.AdicionadoPor = adicionador.Id_user
                                            WHERE cursos_adquiridos.AdicionadoPor IS NOT NULL
                                            AND (user.Pnome_user LIKE ? OR user.Email LIKE ? OR adicionador.Pnome_user LIKE ?)
                                            LIMIT ?, ?";
                                $stmt = $conn->prepare($query);
                                $pesquisaParam = "%" . $textoPesquisa . "%";
                                $stmt->bind_param("sssii", $pesquisaParam, $pesquisaParam, $pesquisaParam, $offset, $limite);
                            } else {


                                $query = "SELECT 
                                            cursos_adquiridos.*, 
                                            user.*, 
                                            curso.*, 
                                            adicionador.Pnome_user AS NomeAdicionadoPor
                                        FROM cursos_adquiridos
                                        INNER JOIN user ON cursos_adquiridos.Id_user = user.Id_user
                                        INNER JOIN curso ON cursos_adquiridos.Id_curso = curso.Id_curso
                                        LEFT JOIN user AS adicionador ON cursos_adquiridos.AdicionadoPor = adicionador.Id_user
                                        WHERE cursos_adquiridos.AdicionadoPor IS NOT NULL
                                        LIMIT ?, ?
                                        ";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("ii", $offset, $limite);
                            }

                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                $quantidadePesquisa = $result->num_rows;

                                while ($row = $result->fetch_assoc()) {



                                    $caminhoImagem = "../../assets/image/fotosPerfil/" . $row['URL_foto_perfilUser'];




                                    echo '
                                    <tr>
                                        <td>
                                            <div class="">
                                                ';
                                    if (!empty($row['URL_foto_perfilUser']) && file_exists($caminhoImagem)) {
                                        echo '<img  class="avatar" src="../../assets/image/fotosPerfil/' . $row['URL_foto_perfilUser'] . '" alt="Erro">';
                                    } else {
                                        echo '<img  class="avatar" src="../../assets/image/User.png" alt="Erro">';
                                    }
                                    echo '
                                            </div>
                                        </td>
                                        <td>' . $row['PNome_user'] . ' ' . $row['SNome_user'] . '<br><small>' . $row['Email'] . '</small></td>
                                        <td>' . $row['Nome_curso'] . '</td>
                                        <td>' . $row['Data_compra'] . '</td>
                                        <td>' . $row['NomeAdicionadoPor'] . '</td>
                                        <td>
                                            <form action="../admin/acoes/removerUtilizadorDeCurso.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="IdRemover" value="' . $row['Id_adquirido'] . '">
                                                <button type="submit" title="Desmatricular utilizador" style="background:none; border:none; color:#e74c3c; font-size:14px; cursor:pointer; padding:0;">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>


                                    ';
                                }
                            } else {
                                echo "<tr><td colspan='5'>Nenhum resultado encontrado.</td></tr>";
                            }
                            ?>





                        </tbody>
                    </table>

                    <?php
                    $totalQuery = "SELECT COUNT(*) as total FROM cursos_adquiridos WHERE AdicionadoPor IS NOT NULL";
                    $totalResult = $conn->query($totalQuery);
                    $totalRow = $totalResult->fetch_assoc();
                    $totalEntradas = $totalRow['total'];
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

</body>

</html>