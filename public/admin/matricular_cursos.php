<?php
include("../../database/basedados.sql");
include("segurançaAdmin.php");



if (!$conn->connect_error) {
    $sql = "SELECT PNome_user FROM user";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $nomes[] = $row['PNome_user'];
        }
    }

    $sql = "SELECT Nome_curso FROM curso";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $cursos[] = $row['Nome_curso'];
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
                    <form class="form-content">
                        <div class="form-group">
                            <label for="input-utilizador">Utilizador <span>*</span></label>
                            <input type="text" id="input-utilizador" placeholder="Digite o nome do utilizador" required onkeyup="mostrarSugestoes('input-utilizador', 'sugestoes-utilizador', listaUtilizadores)">
                            <ul id="sugestoes-utilizador" class="sugestoes"></ul>
                        </div>
                        <div class="form-group">
                            <label for="input-curso">Curso <span>*</span></label>
                            <input type="text" id="input-curso" placeholder="Digite o nome do curso" required
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



        function mostrarSugestoes(inputId, listaId, dados) {
            const input = document.getElementById(inputId);
            const lista = document.getElementById(listaId);
            const termo = input.value.toLowerCase().trim();

            lista.innerHTML = "";

            if (termo === "") {
                lista.style.display = "none";
                return;
            }

            // Agora só mostra sugestões que comecem com o texto introduzido
            const resultados = dados.filter(item =>
                item.toLowerCase().startsWith(termo)
            );

            if (resultados.length > 0) {
                resultados.forEach(item => {
                    const li = document.createElement("li");
                    li.textContent = item;
                    li.onclick = () => {
                        input.value = item;
                        lista.style.display = "none";
                    };
                    lista.appendChild(li);
                });
                lista.style.display = "block";
            } else {
                lista.style.display = "none";
            }
        }
    </script>
</body>

</html>