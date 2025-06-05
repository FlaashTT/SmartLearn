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
    <link rel="stylesheet" href="../../assets/css/admin/style_utilizadores_admin_adicionar.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <?php
    include("../../src/views/utils/cabecalhoAdmin.html");
    ?>



    <!-- Secção Principal (Hero) -->
    <div class="container-admin">
        <main class="container">
            <?php include("../../src/views/utils/sidebarAdmin.html"); ?>

            <main class="container-page">
                <section class="main-content" style="display: flex; align-items: center; justify-content: space-between;">
                    <h1 style="display: flex; align-items: center;">
                        <i style="font-size: 18px; margin-right: 10px;" class="fa-solid fa-users-gear"></i> Adicionar novos clientes
                    </h1>
                </section>

                <section class="page">
                    <h2>Adicionar cliente</h2>
                    <div class="form-tabs">
                        <button class="tab active" data-tab="basico">Básico info</button>
                        <button class="tab" data-tab="info">Login</button>
                        <button class="tab" data-tab="precos">Social</button>
                        <button class="tab" data-tab="finalizar">Finalizar</button>
                    </div>

                    <form method="POST" action="acoes/AdminAdicionaNovoUser.php" enctype="multipart/form-data">
                        <input type="hidden" name="TipoAdd" value="Cliente">

                        <!-- Aba BÁSICO -->
                        <div class="form-content tab-content active" data-content="basico">
                            <div class="form-group">
                                <label for="Nome">Primeiro Nome</label>
                                <input type="text" name="PnomeUser" id="PNome" placeholder="Digite o nome do cliente" required />
                            </div>
                            <div class="form-group">
                                <label for="SNome">Sobrenome</label>
                                <input type="text" name="Snomeuser" id="SNome" placeholder="Digite um sobrenome do cliente" required />
                            </div>
                            <div class="form-group">
                                <label for="descricao">Biografia</label>
                                <textarea id="descricao" name="Biografia" placeholder="Escreve a biografia (opcional)"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="categorias">Imagem</label>
                                <input type="file" id="ficheiro" name="url_imagem" accept=".jpg, .jpeg, .png" />
                            </div>
                        </div>

                        <!-- Aba LOGIN -->
                        <div class="form-content tab-content" data-content="info">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="Email" id="email" placeholder="Digite o email do cliente" required />
                            </div>
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" name="Password" id="password" placeholder="Digite a password do cliente" required />
                            </div>
                        </div>

                        <!-- Aba SOCIAL -->
                        <div class="form-content tab-content" data-content="precos">
                            <div class="form-group">
                                <label for="urlface">Facebook</label>
                                <input type="url" name="URLfacebook" id="urlface" placeholder="Digite o URL da plataforma" />
                            </div>
                            <div class="form-group">
                                <label for="URLlinkedin">Linkedin</label>
                                <input type="url" name="URLlinkedin" id="URLlinkedin" placeholder="Digite o URL da plataforma" />
                            </div>
                            <div class="form-group">
                                <label for="URLyoutube">Youtube</label>
                                <input type="url" name="URLyoutube" id="URLyoutube" placeholder="Digite o URL da plataforma" />
                            </div>
                        </div>

                        <!-- Aba FINALIZAR -->
                        <div class="form-content tab-content" data-content="finalizar">
                            <div class="icone-container">
                                <i class="fa-solid fa-check-double"></i>
                                <h2 class="titulo">Obrigado !</h2>
                                <p class="paragrafo">Tu estás a apenas um clique de distância</p>
                                <p id="paragrafo_erro" style="color: red;">teste</p>
                                <button type="submit" id="butonSubmit" class="btn-enviar">Enviar</button>
                            </div>
                        </div>
                        <script>
                            const camposObrigatorios = ["PNome", "SNome", "email", "password"];
                            const paragrafo = document.getElementById("paragrafo_erro");

                            function validaEmail(email) {
                                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                return re.test(email);
                            }

                            function validaURL(url) {
                                try {
                                    new URL(url);
                                    return true;
                                } catch (_) {
                                    return false;
                                }
                            }

                            function verificaCampos() {
                                let mensagensErro = [];

                                // Verificar campos obrigatórios
                                let camposNaoPreenchidos = [];
                                camposObrigatorios.forEach(id => {
                                    const elemento = document.getElementById(id);
                                    if (elemento && elemento.value.trim() === '') {
                                        let nomeCampo;
                                        switch (id) {
                                            case "PNome":
                                                nomeCampo = "Primeiro Nome";
                                                break;
                                            case "SNome":
                                                nomeCampo = "Sobrenome";
                                                break;
                                            case "email":
                                                nomeCampo = "Email";
                                                break;
                                            case "password":
                                                nomeCampo = "Senha";
                                                break;
                                        }
                                        camposNaoPreenchidos.push(nomeCampo);
                                    }
                                });
                                if (camposNaoPreenchidos.length > 0) {
                                    mensagensErro.push("Campos obrigatórios não preenchidos: " + camposNaoPreenchidos.join(", "));
                                }

                                // Verificar email
                                const emailInput = document.getElementById("email");
                                if (emailInput && emailInput.value.trim() !== '' && !validaEmail(emailInput.value.trim())) {
                                    mensagensErro.push("Email inválido");
                                }

                                // Verificar URLs (caso estejam preenchidas)
                                const urls = [{
                                        id: "urlface",
                                        nome: "Facebook"
                                    },
                                    {
                                        id: "URLlinkedin",
                                        nome: "LinkedIn"
                                    },
                                    {
                                        id: "URLyoutube",
                                        nome: "YouTube"
                                    }
                                ];

                                let urlsInvalidas = [];
                                urls.forEach(({
                                    id,
                                    nome
                                }) => {
                                    const input = document.getElementById(id);
                                    if (input && input.value.trim() !== '' && !validaURL(input.value.trim())) {
                                        urlsInvalidas.push(nome);
                                    }
                                });
                                if (urlsInvalidas.length > 0) {
                                    mensagensErro.push("URLs inválidas: " + urlsInvalidas.join(", ") + " (ex:https://www.site.com)");
                                }

                                // Exibir mensagens de erro
                                if (mensagensErro.length > 0) {
                                    paragrafo.style.display = "block";
                                    paragrafo.innerHTML = mensagensErro.join("<br>");
                                } else {
                                    paragrafo.style.display = "none";
                                    paragrafo.innerHTML = "";
                                }
                            }

                            // Adiciona os listeners para os campos obrigatórios
                            camposObrigatorios.forEach(id => {
                                const elemento = document.getElementById(id);
                                if (elemento) {
                                    elemento.addEventListener("change", verificaCampos);
                                }
                            });

                            // Adiciona os listeners para os campos de URL
                            ["urlface", "URLlinkedin", "URLyoutube"].forEach(id => {
                                const elemento = document.getElementById(id);
                                if (elemento) {
                                    elemento.addEventListener("change", verificaCampos);
                                }
                            });

                            // Verifica inicialmente ao carregar
                            verificaCampos();
                        </script>


                        <div class="form-navigation">
                            <button type="button" class="btn-button" id="prev-tab">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <button type="button" class="btn-button" id="next-tab">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
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
            document.getElementById('inputCargo').value = cargo;
        }


        function abrirModalEliminar(nome) {
            document.getElementById('eliminarModal').style.display = 'block';
            document.querySelector('#eliminarModal p').innerHTML = `Tens a certeza que queres eliminar <strong>${nome}</strong>?`;
        }
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