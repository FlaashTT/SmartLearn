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
    <link rel="stylesheet" href="../../assets/css/admin/style_curso_adicionar.css" />
    <script src="../../assets/js/adicionar_curso.js"></script>
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
                        <i style="font-size: 18px; margin-right: 10px;" class="fas fa-book"></i> Adicionar Curso
                    </h1>
                    <button style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </section>

                <section class="page">
                    <h2>Formulário de Adição de um Curso</h2>
                    <div class="form-tabs">
                        <button class="tab active" data-tab="basico">Básico</button>
                        <button class="tab" data-tab="info">Informações</button>
                        <button class="tab" data-tab="precos">Preços</button>
                        <button class="tab" data-tab="media">Mídia</button>
                        <button class="tab" data-tab="hashtag">Hashtag</button>
                        <button class="tab" data-tab="finalizar">Finalizar</button>
                    </div>

                    <form class="form-content" method="POST" action="acoes/adicionarCurso.php" enctype="multipart/form-data">
                        <!-- CONTEÚDO DA ABA BÁSICO -->
                        <div class="form-content tab-content active" data-content="basico">
                            <div class="form-group">
                                <label for="titulo">Título do Curso</label>
                                <input type="text" name="titulo" id="titulo" placeholder="Digite o título do curso" required />
                            </div>
                            <div class="form-group">
                                <label for="descricao-curta">Pequena-descrição</label>
                                <input type="text" name="peq_descricao" id="descricao-curta" placeholder="Digite uma pequena descrição" />
                            </div>
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <input type="text" name="descricao" id="descricao" placeholder="Digite a descrição" />
                            </div>
                            <div class="form-group">
                                <label for="categorias">Categorias</label>
                                <select name="categoria" id="categorias">
                                    <option disabled selected>Selecione</option>
                                    <?php
                                    $query = "SELECT * FROM categoria";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['Id_categoria'] . "'>" . $row['Nome_cat'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nivel">Nível</label>
                                <select name="dificuldade" id="nivel">
                                    <option disabled selected>Selecione</option>
                                    <option value="iniciante">Iniciante</option>
                                    <option value="intermedio">Intermediário</option>
                                    <option value="avancado">Avançado</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="linguagem">Linguagem feita em</label>
                                <select name="idioma" id="linguagem">
                                    <option disabled selected>Selecione</option>
                                    <?php
                                    $query = "SELECT * FROM idioma";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['Id_idioma'] . "'>" . $row['Nome_idioma'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- CONTEÚDO DA ABA INFORMAÇÕES -->
                        <div class="form-content tab-content" data-content="info">
                            <div class="form-group">
                                <label for="modulo">Módulo do Curso</label>
                                <div class="modulo-input-container">
                                    <input type="text" id="moduloInput" class="modulo-input" placeholder="Digite o nome do módulo" />
                                    <button type="button" id="addModulo" class="modulo-btn-adicionar">+</button>
                                </div>
                                <ul id="modulosLista" class="modulos-lista"></ul>
                            </div>
                            <div class="form-group">
                                <label for="requisitos">Requisitos</label>
                                <div class="modulo-input-container">
                                    <input type="text" id="requisitosInput" class="modulo-input" placeholder="Digite o nome do requisito" />
                                    <button type="button" id="addRequisito" class="modulo-btn-adicionar">+</button>
                                </div>
                                <ul id="requisitosLista" class="modulos-lista"></ul>
                            </div>
                            <div class="form-group">
                                <label for="resultados">Resultados</label>
                                <div class="modulo-input-container">
                                    <input type="text" id="resultadosInput" class="modulo-input" placeholder="Digite o nome do resultado" />
                                    <button type="button" id="addResultado" class="modulo-btn-adicionar">+</button>
                                </div>
                                <ul id="resultadosLista" class="modulos-lista"></ul>
                            </div>
                        </div>

                        <!-- CONTEÚDO DA ABA PREÇOS -->
                        <div class="form-content tab-content" data-content="precos">
                            <div class="form-group">
                                <label for="preco">Preço do curso (€)</label>
                                <input type="text" name="preco" id="preco" placeholder="Digite o preço do curso" />
                                <div class="checkbox-curso">
                                    <input type="checkbox" name="gratuito" id="verificarGratuito" />
                                    <label class="label-btn" for="verificarGratuito">Verifique que este é um curso gratuito</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="desconto">Preço com desconto (€)</label>
                                <input type="text" disabled name="desconto" id="desconto" placeholder="Digite o preço com desconto"  />
                                <div class="checkbox-curso">
                                    <input type="checkbox" name="tem_desconto" id="verificarDesconto" />
                                    <label class="label-btn" for="verificarDesconto">Verifique que este curso tem desconto</label>
                                </div>
                            </div>
                        </div>

                        <!-- CONTEÚDO DA ABA MÍDIA -->
                        <div class="form-content tab-content" data-content="media">
                            <div class="form-group">
                                <label for="provedor">Provedor de visão geral do curso</label>
                                <select name="provedor" id="provedor">
                                    <option disabled selected>Selecione</option>
                                    <!-- Opções devem ser preenchidas aqui -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ficheiro">Carregar imagem do curso</label>
                                <input type="file" name="imagem_curso" id="ficheiro" accept="image/*" />
                                <div id="cardPreview" class="card-preview">
                                    <div class="card-content">
                                        <img id="cardImage" src="" alt="Imagem de pré-visualização" />
                                        <p id="cardText">Aqui será mostrado o conteúdo da URL.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CONTEÚDO DA ABA HASHTAG -->
                        <div class="form-content tab-content" data-content="hashtag">
                            <div class="form-group">
                                <label for="hashtag">Hashtag do Curso</label>
                                <div class="hashtag-input-container">
                                    <input type="text" id="hashtagInput" class="hashtag-input" placeholder="Digite o nome da hashtag" />
                                    <button type="button" id="addHashtag" class="hashtag-btn-adicionar">+</button>
                                </div>
                                <ul id="hashtagsLista" class="hashtags-lista"></ul>
                            </div>
                            <div class="form-group">
                                <label for="descricao_hashtag">Descrição</label>
                                <input type="text" id="descricao_hashtag" name="descricao_hashtag" placeholder="Digite a descrição" />
                            </div>
                        </div>

                        <!-- CONTEÚDO DA ABA FINALIZAR -->
                        <div class="form-content tab-content" data-content="finalizar">
                            <div class="icone-container">
                                <i class="fa-solid fa-check-double"></i>
                                <h2 class="titulo">Obrigado!</h2>
                                <p class="paragrafo">Tu estás a apenas um clique de distância</p>
                                <p style="display: block; color: red;" id="paragrafoErro">Erro</p>
                                <button type="submit" id="buttonSubmit" class="btn-enviar">Enviar</button>
                            </div>
                        </div>
                    </form>

                    <div class="form-navigation">
                        <button type="button" class="btn-button" id="prev-tab">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <button type="button" class="btn-button" id="next-tab">
                            <i class="fas fa-arrow-right"></i>
                        </button>
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


        // Executa depois que o DOM estiver pronto
        window.addEventListener("DOMContentLoaded", function() {
            const checkGratis = document.getElementById("verificarGratuito");
            const inputPreco = document.getElementById("preco");
            const inputDesconto = document.getElementById("desconto");
            const verificarDesconto = document.getElementById("verificarDesconto");

            function atualizarCampos() {
                if (checkGratis.checked) {
                    inputPreco.disabled = true;
                    inputPreco.value = ""; // limpa valor
                    inputDesconto.disabled = true;
                    inputDesconto.value = ""; // limpa valor
                    verificarDesconto.disabled = true;
                } else {
                    inputPreco.disabled = false;
                    inputDesconto.disabled = false;
                    verificarDesconto.disabled = false;
                }
            }

            // Chama uma vez ao carregar
            atualizarCampos();

            // Chama sempre que mudar o checkbox
            checkGratis.addEventListener("change", atualizarCampos);
        });
    </script>

    <script>
        var desconto = document.getElementById("desconto");
        desconto.disabled = true;

        document.addEventListener('DOMContentLoaded', function() {
            var verificarDesconto = document.getElementById("verificarDesconto");

            verificarDesconto.addEventListener('change', function() {
                if (!verificarDesconto.checked) {
                    desconto.disabled = true;
                } else {
                    desconto.disabled = false;
                }
            });

            if (!verificarDesconto.checked) {
                desconto.disabled = true;
            }
        });


        const buttonSubmit = document.getElementById("buttonSubmit");
        const titulo = document.getElementById("titulo");
        const linguagem = document.getElementById("linguagem");
        const paragrafoErro = document.getElementById("paragrafoErro");

        // Escutadores para verificar os campos ao digitar
        titulo.addEventListener("input", verificarCampos);
        linguagem.addEventListener("input", verificarCampos);

        function verificarCampos() {
            let mensagensErro = [];

            // Verifica título
            if (titulo.value.trim() === "") {
                mensagensErro.push("Título é obrigatório!");
                titulo.style.borderColor = "red";
            } else {
                titulo.style.borderColor = "";
            }

            // Verifica linguagem
            if (linguagem.value.trim() === "" || linguagem.value === "Selecione") {
                mensagensErro.push("Linguagem é obrigatória!");
                linguagem.style.borderColor = "red";
            } else {
                linguagem.style.borderColor = "";
            }

            if (mensagensErro.length > 0) {
                paragrafoErro.style.display = "block";
                paragrafoErro.textContent = mensagensErro.join(" ");
                buttonSubmit.disabled = true;
                buttonSubmit.style.cursor = "not-allowed";
                buttonSubmit.style.opacity = "0.5";
            } else {
                paragrafoErro.style.display = "none";
                paragrafoErro.textContent = "";
                buttonSubmit.disabled = false;
                buttonSubmit.style.cursor = "pointer";
                buttonSubmit.style.opacity = "1";
            }
        }

        // Chama a função para validar ao carregar a página
        verificarCampos();
    </script>



</body>

</html>