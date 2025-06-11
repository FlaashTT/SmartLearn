<?php
include("../../database/basedados.php");
include("segurançaAdmin.php");


$cursos = [];
if (!$conn->connect_error) {

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
    <link rel="stylesheet" href="../../assets/css/admin/style_curso_conteudo.css" />
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
                        <i style="font-size: 18px; margin-right: 10px;" class="fas fa-book"></i> Adicionar Curso (Conteudo)
                    </h1>
                    <button style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </section>

                <section class="page">
                    <h2>Formulário de Adição de um Curso</h2>
                    <!-- Formulário de Administração -->
                    <form class="form-group" action="acoes/adicionar_alterar_conteudo.php" method="POST" enctype="multipart/form-data">
                        <label for="titulo">Título do Curso:</label>
                        <input type="text" id="input-curso" name="titulo" required onkeyup="mostrarSugestoes('input-curso', 'sugestoes-curso', listaCursos)" />
                        <ul id="sugestoes-curso" style="display:none; border:1px solid #ccc; max-width:300px; padding:0; margin:0; list-style:none;"></ul>
                        <input type="hidden" id="input-curso-id" class="sugestoes" name="input-curso-id" />

                        <label for="video">Vídeo do Curso:</label>
                        <input type="file" id="video" name="video" accept="video/mp4" />

                        <label for="imagem">Imagem do Curso:</label>
                        <input type="file" id="imagem" name="imagem" accept="image/*" />

                        <label for="conteudo">Conteúdo do Curso (Texto ou Imagem):</label>
                        <textarea id="conteudo" name="conteudo"></textarea>

                        <label for="fase">Fase do Curso:</label>
                        <select id="fase" name="fase">
                            <option value="1">Fase 1</option>
                            <option value="2">Fase 2</option>
                            <option value="3">Fase 3</option>
                            <!-- Adicionar mais opções conforme necessário -->
                        </select>
                        <p id="TextoErro" display="none" style="color: red;">Erro: Por favor, volte a inserir o curso pretendido.</p>
                        <button id="confirmButton" class="btn-button" type="submit">Adicionar Conteúdo</button>
                    </form>
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

    <script>
        const listaCursos = <?php echo json_encode($cursos, JSON_UNESCAPED_UNICODE); ?>;

        function mostrarSugestoes(inputId, listaId, dados) {
            const input = document.getElementById(inputId);
            const lista = document.getElementById(listaId);
            const termo = input.value.toLowerCase().trim();

            lista.innerHTML = "";

            if (termo === "") {
                lista.style.display = "none";
                document.getElementById('input-curso-id').value = "";
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
                            document.getElementById('input-curso-id').value = item.id;
                            lista.style.display = "none";
                        };
                    }

                    lista.appendChild(li);
                });
                lista.style.display = "block";
            } else {
                lista.style.display = "none";
                document.getElementById('input-curso-id').value = "";
            }
        }
    </script>

    <script>
        const confirmButton = document.getElementById('confirmButton');
        const inputCursoId = document.getElementById('input-curso-id');
        const textoErro = document.getElementById('TextoErro');

        function validar() {
            if (inputCursoId.value.trim() === "") {
                confirmButton.disabled = true;
                textoErro.style.display = 'block';
                confirmButton.style.opacity = '0.5';
                confirmButton.style.cursor = 'not-allowed';
            } else {
                confirmButton.disabled = false;
                textoErro.style.display = 'none';
                confirmButton.style.opacity = '1';
                confirmButton.style.cursor = 'pointer';
            }
        }

        // Verifica ao carregar a página
        window.addEventListener('DOMContentLoaded', validar);

        // Verifica a cada 300ms
        setInterval(validar, 300);
    </script>


</body>

</html>