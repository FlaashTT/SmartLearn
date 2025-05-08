<?php
include("segurançaAdmin.php");
include("../../database/basedados.sql");

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
                                $query = "SELECT COUNT(*) AS total FROM curso WHERE Estado_curso != 'pendente'";
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

                <section class="course-list">
                    <h2>Lista de cursos</h2>
                    <div class="filters">
                        <label for="categories">Categorias</label>
                        <div>
                            <select id="categories">
                                <option>Todos</option>
                            </select>
                        </div>
                        <div>
                            <select id="categories">
                                <option>Todos</option>
                            </select>
                        </div>
                        <div>
                            <select id="categories">
                                <option>Todos</option>
                            </select>
                        </div>
                        <button>Filtrar</button>
                    </div>
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
                                $query = "SELECT * FROM curso";
                                $stmt = $conn->prepare($query);


                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    $total = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        echo '
                                        <tr>
                                    <td>'.$row['Id_curso'].'</td>
                                    <td>'.$row['Nome_curso'].'</td>
                                    <td>fazer o selct da cat e por o nome</td>
                                    <td>'.$total.'</td>
                                    <td>'.$row['Estado_curso'].'</td>
                                    <td>'.$row['Preco'].'€</td>
                                    <td onclick="mostrarInfo(' . $row['Id_curso'] . ')" style="cursor: pointer;" >Ver detalhes curso</td>
                                    </tr>
                                ';
                                    }
                                } else {
                                    
                                    echo '
                                    <tr>
                                    <td colspan="7">Nenhum dado inserido</td>
                                    </tr>';
                                }
                                ?>





                            
                        </tbody>
                    </table>
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
    </script>
    </script>
</body>

</html>