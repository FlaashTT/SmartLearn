<?php
include("../../database/basedados.php");
include("segurançaAdmin.php");


$nomes = [];
$cursos = [];
if (!$conn->connect_error) {
    $sql = "SELECT Id_user, PNome_user, SNome_user, email FROM user";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $nomeCompleto = $row['PNome_user'] . ' ' . $row['SNome_user'];
            $email = $row['email'];

            $nomes[] = [
                'id' => $row['Id_user'],
                'nome' => $email . ' / ' . $nomeCompleto
            ];
        }
    }

    $sql = "SELECT ID_curso, Nome_curso FROM curso";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            // Mantém o nome do campo 'id' para facilitar no JS
            $cursos[] = [
                'id' => $row['ID_curso'],
                'nome' => $row['Nome_curso']
            ];
        }
    }
}

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
    <link rel="stylesheet" href="../../assets/css/admin/style_inscricao_matricula.css" />
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
                        <i style="font-size: 18px; margin-right: 10px;" class="fa-solid fa-user-plus"></i> Matricular no curso
                    </h1>
                </section>

                <section class="page">
                    <h2>Matricular</h2>
                    <form class="form-content" action="acoes/realizaMatricular.php" method="POST" id="form-matricular">
                        <div class="form-group">
                            <label for="input-utilizador">Utilizador <span>*</span></label>
                            <input type="text" id="input-utilizador" name="utilizador" placeholder="Digite o email do utilizador" required onkeyup="mostrarSugestoes('input-utilizador', 'sugestoes-utilizador', listaUtilizadores)">
                            <input type="hidden" id="input-utilizador-id" name="utilizador_id">
                            <ul id="sugestoes-utilizador" class="sugestoes"></ul>
                        </div>
                        <div class="form-group">
                            <label for="input-curso">Curso <span>*</span></label>
                            <input type="hidden" id="input-curso-id" name="curso_id">
                            <input type="text" id="input-curso" name="curso" placeholder="Digite o nome do curso" required
                                onkeyup="mostrarSugestoes('input-curso', 'sugestoes-curso', listaCursos)">
                            <ul id="sugestoes-curso" class="sugestoes"></ul>
                        </div>
                        <div class="form-buttons">
                            <button type="submit" class="btn-enviar">Matricular utilizador</button>
                        </div>
                    </form>
                </section>
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

        let utilizador = document.getElementById("titulo");
    </script>
    <script>
        const listaUtilizadores = <?php echo json_encode($nomes, JSON_UNESCAPED_UNICODE); ?>;
        const listaCursos = <?php echo json_encode($cursos, JSON_UNESCAPED_UNICODE); ?>;

        console.log(listaUtilizadores);
        console.log(listaCursos);

        function mostrarSugestoes(inputId, listaId, dados) {
            const input = document.getElementById(inputId);
            const lista = document.getElementById(listaId);
            const termo = input.value.toLowerCase().trim();

            lista.innerHTML = "";

            if (termo === "") {
                lista.style.display = "none";

                if (inputId === 'input-curso') {
                    document.getElementById('input-curso-id').value = "";
                } else if (inputId === 'input-utilizador') {
                    document.getElementById('input-utilizador-id').value = "";
                }

                return;
            }

            const resultados = dados.filter(item => {
                if (typeof item === 'string') {
                    return item.toLowerCase().startsWith(termo);
                } else if (typeof item === 'object' && item.nome) {
                    return item.nome.toLowerCase().startsWith(termo);
                }
                return false;
            });

            if (resultados.length > 0) {
                resultados.forEach(item => {
                    const li = document.createElement("li");

                    if (typeof item === 'string') {
                        li.textContent = item;
                        li.onclick = () => {
                            input.value = item;
                            lista.style.display = "none";
                        };
                    } else if (typeof item === 'object') {
                        li.textContent = item.nome;
                        li.onclick = () => {
                            input.value = item.nome;

                            if (inputId === 'input-curso') {
                                document.getElementById('input-curso-id').value = item.id;
                            } else if (inputId === 'input-utilizador') {
                                document.getElementById('input-utilizador-id').value = item.id;
                            }

                            lista.style.display = "none";
                        };
                    }

                    lista.appendChild(li);
                });
                lista.style.display = "block";
            } else {
                lista.style.display = "none";

                if (inputId === 'input-curso') {
                    document.getElementById('input-curso-id').value = "";
                } else if (inputId === 'input-utilizador') {
                    document.getElementById('input-utilizador-id').value = "";
                }
            }
        }
    </script>
</body>

</html>