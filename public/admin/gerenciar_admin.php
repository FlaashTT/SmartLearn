<?php
include("../../database/basedados.sql");
include("segurançaAdmin.php");

$quantidadePesquisa = 0;
$limite = isset($_GET['limite']) ? intval($_GET['limite']) : 10;
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$textoPesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
$offset = ($pagina - 1) * $limite;
$idEditar = isset($_POST['idEditar']) ? $_POST['idEditar'] : null;
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
    <link rel="stylesheet" href="../../assets/css/admin/style_utilizadores_admin_gerenciar.css" />
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
                        <i style="font-size: 18px; margin-right: 10px;" class="fa-solid fa-users-gear"></i> Gerenciar admins
                    </h1>
                </section>

                <section class="course-list">
                    <h2>Histórico</h2>
                    <div class="filters">
                        <form method="GET" action="gerenciar_admin.php">
                            <div class="search-container">
                                <input type="text" name="pesquisa" id="searchInput" placeholder="Pesquisar...  (necessario clicar no botão filtrar)">
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
                                <th>Avatar</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Cargo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($textoPesquisa != '') {
                                $query = "SELECT * FROM user
                                            WHERE (Tipo_user = 'admin' OR Tipo_user = 'Main-admin')
                                            AND (
                                                PNome_user LIKE ? OR
                                                SNome_user LIKE ? OR
                                                Email LIKE ?
                                            )
                                            LIMIT ?, ?";
                                $stmt = $conn->prepare($query);
                                $pesquisaParam = "%" . $textoPesquisa . "%";
                                $stmt->bind_param("sssii", $pesquisaParam, $pesquisaParam, $pesquisaParam, $offset, $limite);
                            } else {


                                $query = "SELECT * from user
                                        WHERE Tipo_user = 'admin' OR Tipo_user = 'Main-admin'
                                            
                                        
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

                                    echo '
                                        <tr data-id="' . $row['Id_user'] . '">
                                            <td>' . $row['Id_user'] . '</td>
                                            ';
                                    if (!empty($row['URL_foto_perfilUser']) && file_exists($caminhoImagem)) {
                                        echo '<td><img  class="avatar" src="../../assets/image/fotosPerfil/' . $row['URL_foto_perfilUser'] . '" alt="Erro"></td>';
                                    } else {
                                        echo '<td><img  class="avatar" src="../../assets/image/User.png" alt="Erro"></td>';
                                    }
                                    echo '
                                            <td>' . $row['PNome_user'] . ' ' . $row['SNome_user'] . '</td>
                                            <td>' . $row['Email'] . '</td>
                                            ';
                                    if ($row['Tipo_user'] === 'Main-admin') {
                                        echo '<td><span class="tag-cargo root-admin">Main Admin</span></td>';
                                    } else {
                                        echo '<td><span class="tag-cargo admin">Admin</span></td>';
                                    }
                                    echo '

                                            <td class="actions">
                                                <div style="display: flex; gap: 8px;">
                                                        
                                                        <button type="button" class="btn-editar" onclick="abrirModalEditar(this)">
                                                            Editar
                                                        </button>
                                                    

                                                    
                                                        <input type="hidden" name="idEliminiar" value="' . $row['Id_user'] . '">
                                                        <button type="button" class="btn-eliminar" onclick="abrirModalEliminar(\'' . $row['Email'] . ' \')">
                                                            Eliminar
                                                        </button>
                                                    
                                                </div>
                                            </td>
                                            


                                        </tr>
                                        ';
                                    echo '
                                            <form method="POST" action="acoes/alterarUtilizador.php" style="margin: 0;">
                                                <input type="hidden" name="idEditar" id=IdEditar value="">
                                                <div id="editarModal" class="modal">
                                                    <div class="modal-content">
                                                        <span class="close"  onclick="fecharModal(\'editarModal\')">&times;</span>
                                                        <h3>Editar Utilizador</h3>
                                                        
                                                        <label>Nome:</label>
                                                        <input type="text" id="inputNome" name="NovoNome" id="inputNome" style="width: 100%; padding: 8px;">
                                                        
                                                        <label>Email:</label>
                                                        <input type="email" id="inputEmail"   name="NovoEmail" style="width: 100%; padding: 8px;">
                                                        
                                                        <label>Cargo:</label>
                                                        <select name="novoCargo"  style="width: 100%; padding: 8px;">
                                                         <option value="" disabled selected>Selecione um cargo</option>
                                    ';
                                    if ($row['Tipo_user'] === 'Main-admin') {
                                        echo ' <option value="Main-admin">Passar a dono</option>';
                                    }
                                    echo '
                                                        <option value="Admin">Editor</option>
                                                        <option value="Cliente">Cliente</option>
                                                        </select>
                                                        <div class="modal-buttons">
                                                            <button type="button" onclick="fecharModal(\'editarModal\')">Cancelar</button>
                                                            <button type="submit">Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>


                                            <!-- Modal Eliminar -->
                                            <form method="POST" action="eliminarUserAdmin.php.php" style="margin: 0;">
                                                <input type="hidden" name="idEliminiar" value="' . $row['Id_user'] . '">
                                                <div id="eliminarModal" class="modal">
                                                    <div class="modal-content">
                                                        <span class="close" onclick="fecharModal(\'eliminarModal\')">&times;</span>
                                                        <h3>Confirmar Eliminação</h3>
                                                        <p>Tens a certeza que queres eliminar <strong>Joana Silva</strong>?</p>
                                                        <div class="modal-buttons">
                                                            <button  type="button" onclick="fecharModal(\'eliminarModal\')">Cancelar</button>
                                                            <button  type="submit" style="background-color: #dc3545; color: white;">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        ';
                                }
                            } else {
                                echo '
                                    <tr>
                                        <td colspan="6" style="text-align: center;">Nenhum resultado encontrado</td>
                                    </tr>
                                ';
                            }
                            ?>




                        </tbody>
                    </table>

                    <?php
                    if ($textoPesquisa != '') {
                        $totalQuery = "SELECT COUNT(*) as total FROM user 
                   WHERE (Tipo_user = 'admin' OR Tipo_user = 'Main-admin') 
                   AND (PNome_user LIKE ? OR SNome_user LIKE ? OR Email LIKE ?)";
                        $stmtTotal = $conn->prepare($totalQuery);
                        $stmtTotal->bind_param("sss", $pesquisaParam, $pesquisaParam, $pesquisaParam);
                    } else {
                        $totalQuery = "SELECT COUNT(*) as total FROM user 
                   WHERE Tipo_user = 'admin' OR Tipo_user = 'Main-admin'";
                        $stmtTotal = $conn->prepare($totalQuery);
                    }

                    // Executar o statement
                    $stmtTotal->execute();

                    // Obter resultado
                    $resultTotal = $stmtTotal->get_result();
                    $totalRow = $resultTotal->fetch_assoc();

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


                    <!-- Modal Editar -->



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
        function fecharModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        function abrirModalEditar(button) {
            // Obtém a linha da tabela (tr) onde o botão foi clicado
            var row = button.closest('tr');

            // Obtém os dados da linha
            var id = row.getAttribute('data-id');
            var nome = row.cells[2].innerText; // Coluna do nome
            var email = row.cells[3].innerText; // Coluna do email
            var cargo = row.cells[4].innerText; // Coluna do cargo

            // Abre o modal e preenche os campos com os dados da linha
            document.getElementById('editarModal').style.display = 'block';
            document.getElementById('inputNome').value = nome;
            document.getElementById('inputEmail').value = email;
            document.getElementById('IdEditar').value = id;
        }


        function abrirModalEliminar(Email) {
            document.getElementById('eliminarModal').style.display = 'block';
            document.querySelector('#eliminarModal p').innerHTML = `Tens a certeza que queres eliminar <strong>${Email}</strong>?`;
        }
    </script>



</body>

</html>