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
                            <label for="titulo">Utilizador <span>*</span></label>
                            <input type="text" id="titulo" placeholder="Digite o utilizador" required />
                        </div>
                        <div class="form-group">
                            <label for="descricao-curta">Curso <span>*</span></label>
                            <input type="text" id="descricao-curta" placeholder="Digite o curso" required />
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
</body>

</html>