<?php

include("../../database/basedados.php");
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
    <link rel="stylesheet" href="../../assets/css/admin/style_configuracoes.css" />
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
                        <i style="font-size: 18px; margin-right: 10px;" class="fas fa-book"></i> Configurações do site
                    </h1>
                </section>

                <section class="page">
                    <h2>Configuração</h2>

                    <?php
                    $sql = "
                        SELECT cs.*, u.Pnome_user, u.Snome_user
                        FROM configuracoes_site cs
                        INNER JOIN user u ON cs.Id_utilizador_Ultimo_update = u.Id_user
                        WHERE cs.Id_configuracao = 1
                        ";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo '
                            <!-- Formulário de Administração -->
                            <form class="form-group" action="acoes/alterar_configuracoes.php" method="POST" enctype="multipart/form-data">
                                <label for="titulo">Título do Banner:</label>
                                <input type="text" id="titulo_banner" name="titulo_banner" value="' . $row['Titulo_banner'] . '" placeholder="Introduzir um nome do banner" required />

                                <label for="titulo">Sub-título do Banner:</label>
                                <input type="text" id="subtitulo_banner" name="subtitulo_banner" value="' . $row['Subtitulo_banner'] . '" placeholder="Introduzir um nome do sub-banner" required />

                                <label for="titulo">Cookie status:</label>
                                <input type="text" id="cookie_status" name="cookie_status" value="' . $row['Cookies_status'] . '" placeholder="Introduzir vários status" required />

                                <label for="titulo">Cookie note:</label>
                                <input type="text" id="cookie_note" name="cookie_note" value="' . $row['cookie_note'] . '" placeholder="Introduzir notas" required />

                                <label for="titulo">Facebook:</label>
                                <input type="url" id="facebook_link" name="facebook_link" value="' . $row['Facebook'] . '" placeholder="Introduzir o URL da plataforma" />

                                <label for="titulo">Linkedin:</label>
                                <input type="url" id="linkedin_link" name="linkedin_link" value="' . $row['Linkedin'] . '" placeholder="Introduzir o URL da plataforma" />

                                <label for="politicaCookies">Política de cookies:</label>
                                <textarea id="politicaCookies" name="politicaCookies" placeholder="Escreve a política de cookies..." maxlength="1000">' . $row['politica_cookies']. '</textarea>

                                <p>Ultima atualização:</p>
                                <p  style="margin-bottom: 20px;">Feita por:' . $row['Pnome_user'] . ' ' . $row['Snome_user'] . ' id(' . $row['Id_utilizador_Ultimo_update'] . ') em ' . $row['data_update'] . ' </p>


                                <button class="btn-button" type="submit">Enviar</button>
                            </form>
                    ';
                    } else {
                        //faz um popup a dizer que nao existe 
                        echo "<script>console.log('erro');</script>";
                    }

                    ?>
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


    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                activateTab(tab);
            });
        });

        function activateTab(tab) {
            const target = tab.getAttribute('data-tab');

            // Remove active de todas as tabs e conteúdos
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            // Ativa tab e conteúdo correspondente
            tab.classList.add('active');
            document.querySelector(`.tab-content[data-content="${target}"]`).classList.add('active');
        }

        // Navegação com setas
        const tabs = Array.from(document.querySelectorAll('.tab'));
        let currentIndex = tabs.findIndex(t => t.classList.contains('active'));

        document.getElementById('next-tab').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % tabs.length;
            activateTab(tabs[currentIndex]);
        });

        document.getElementById('prev-tab').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + tabs.length) % tabs.length;
            activateTab(tabs[currentIndex]);
        });

        // Atualiza o índice actual sempre que clicas numa tab manualmente
        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                currentIndex = index;
            });
        });
    </script>
    <script>
        // Para Módulo do Curso
        const botaoAdicionarModulo = document.getElementById("addModulo");
        const inputModulo = document.getElementById("moduloInput");
        const listaModulos = document.getElementById("modulosLista");

        botaoAdicionarModulo.addEventListener("click", () => {
            const textoModulo = inputModulo.value.trim();
            if (textoModulo !== "") {
                const itemModulo = document.createElement("li");

                const spanTextoModulo = document.createElement("span");
                spanTextoModulo.textContent = textoModulo;

                const botaoRemoverModulo = document.createElement("button");
                botaoRemoverModulo.textContent = "−";
                botaoRemoverModulo.className = "modulo-btn-remover";
                botaoRemoverModulo.addEventListener("click", () => {
                    itemModulo.remove();
                });

                itemModulo.appendChild(spanTextoModulo);
                itemModulo.appendChild(botaoRemoverModulo);
                listaModulos.appendChild(itemModulo);

                inputModulo.value = ""; // Limpa o campo de input
            }
        });

        // Para Hashtag do Curso
        const botaoAdicionarHashtag = document.getElementById("addHashtag");
        const inputHashtag = document.getElementById("hashtagInput");
        const listaHashtags = document.getElementById("hashtagsLista");

        botaoAdicionarHashtag.addEventListener("click", () => {
            const textoHashtag = inputHashtag.value.trim();
            if (textoHashtag !== "") {
                const itemHashtag = document.createElement("li");

                const spanTextoHashtag = document.createElement("span");
                spanTextoHashtag.textContent = textoHashtag;

                const botaoRemoverHashtag = document.createElement("button");
                botaoRemoverHashtag.textContent = "−";
                botaoRemoverHashtag.className = "hashtag-btn-remover";
                botaoRemoverHashtag.addEventListener("click", () => {
                    itemHashtag.remove();
                });

                itemHashtag.appendChild(spanTextoHashtag);
                itemHashtag.appendChild(botaoRemoverHashtag);
                listaHashtags.appendChild(itemHashtag);

                inputHashtag.value = ""; // Limpa o campo de input
            }
        });
    </script>
    <script>
        document.getElementById('ficheiro').addEventListener('change', function(event) {
            var file = event.target.files[0];
            var cardPreview = document.getElementById('cardPreview');
            var cardImage = document.getElementById('cardImage');
            var cardText = document.getElementById('cardText');

            // Reset do conteúdo anterior
            cardImage.src = '';
            cardImage.style.display = 'none';
            cardText.textContent = '';
            cardText.style.display = 'none';
            cardText.classList.remove('error');

            // Exibe o card
            cardPreview.style.display = 'block';
            cardPreview.style.opacity = 1;

            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    cardImage.src = e.target.result;
                    cardImage.style.display = 'block';
                    cardText.style.display = 'none';
                };

                reader.onerror = function() {
                    cardText.textContent = "Erro: Não foi possível carregar o ficheiro.";
                    cardText.style.display = 'block';
                    cardImage.style.display = 'none';
                };

                reader.readAsDataURL(file);
            } else {
                cardImage.style.display = 'none';
                cardText.textContent = "Inválido: Por favor, selecione uma imagem válida.";
                cardText.style.display = 'block';
                cardText.classList.add('error');

                // Esconde o card após erro
                setTimeout(function() {
                    cardPreview.style.opacity = 0;
                    setTimeout(function() {
                        cardPreview.style.display = 'none';
                    }, 1000);
                }, 1000);
            }
        });
    </script>


</body>

</html>