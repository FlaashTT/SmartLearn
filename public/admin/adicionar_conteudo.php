<?php
include("../../database/basedados.php");
include("segurançaAdmin.php");
//adicionar_conteudo.php
$fasesCursos = [];
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

    $sql = "SELECT * FROM fase ";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $idCurso = $row['Id_curso'];

            // Agrupa as fases por ID do curso
            if (!isset($fasesCursos[$idCurso])) {
                $fasesCursos[$idCurso] = [];
            }

            $fasesCursos[$idCurso][] = [
                'id_curso' => $row['Id_curso'],
                'Numero_fase' => $row['Num_fase'],
                'titulo' => $row['Titulo_fase'],
                'video' => $row['video'],
                'imagem' => $row['Imagem'],
                'conteudo' => $row['Conteudo_fase']

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
                    <form class="form-group" action="acoes/adicionar_alterar_conteudo.php" id="uploadForm" method="POST" enctype="multipart/form-data">
                        <!-- Título e sugestões -->
                        <div class="form-group">
                            <label for="titulo">Título do Curso:</label>
                            <input type="text" id="input-curso" name="titulo" required onkeyup="mostrarSugestoes('input-curso', 'sugestoes-curso', listaCursos)" class="form-control" />
                            <ul id="sugestoes-curso" style="display:none; border:1px solid #ccc; max-width:300px; padding:0; margin:0; list-style:none;"></ul>
                            <input type="hidden" id="input-curso-id" class="sugestoes" name="input-curso-id" />
                        </div>

                        <!-- Área de fases -->
                        <div id="fases-container">
                            <div class="fase card" style="padding: 15px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">
                                <h4>Fase 1</h4>

                                <div class="form-group">
                                    <label for="titulo0">Titulo da fase:</label>
                                    <input type="text" id="titulo0" name="titulo[1]" class="form-control" />
                                </div>

                                <div class="form-group">
                                    <label for="video0">Vídeo do Curso:</label>
                                    <input type="file" id="video0" name="video[1]" accept="video/mp4" class="form-control" />

                                </div>
                                <div id="oldVideo0" style="margin-bottom: 10px;" hidden>
                                    <!-- Aqui será exibido o vídeo atual, se existir -->
                                    <p>Vídeo atual: Nenhum vídeo enviado.</p>
                                </div>

                                <div class="form-group">
                                    <label for="imagem0">Imagem do Curso:</label>
                                    <input type="file" id="imagem0" name="imagem[1]" accept="image/*" class="form-control" />
                                </div>

                                <div class="form-group">
                                    <label for="conteudo0">Conteúdo do Curso (Texto):</label>
                                    <textarea id="conteudo0" name="conteudo[1]" class="form-control"></textarea>
                                </div>

                                <input type="hidden" name="fase[]" value="1" />
                            </div>
                        </div>

                        <!-- Botão para adicionar mais fases -->
                        <div class="form-group">
                            <button type="button" onclick="adicionarFase()" class="btn-button">Adicionar nova fase</button>
                        </div>

                        <!-- Mensagem de erro -->
                        <p id="TextoErro" style="display:none; color: red;">Erro: Por favor, volte a inserir o curso pretendido.</p>

                        <!-- Botão de envio -->
                        <div class="form-group">
                            <button id="confirmButton" class="btn-button" type="submit">Adicionar/alterar Conteúdo</button>
                        </div>
                    </form>
    </div>
    </section>

    </main>
    </main>
    </div>


    </script>

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
                            document.getElementById('input-curso-id').dispatchEvent(new Event('change'));
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

        function adicionarFase() {
            const container = document.getElementById('fases-container');
            // Obtem o valor de fases atualmente criadas
            const fasesExistentes = Array.from(container.querySelectorAll('input[name="fase[]"]'))
                .map(input => parseInt(input.value, 10));
            // Procura o maior número de fase já usado
            let faseNumero = 1;
            while (fasesExistentes.includes(faseNumero)) {
                faseNumero++;
            }

            const novaFase = document.createElement('div');
            novaFase.classList.add('fase', 'card');
            novaFase.style.padding = '15px';
            novaFase.style.marginBottom = '15px';
            novaFase.style.border = '1px solid #ccc';
            novaFase.style.borderRadius = '5px';

            novaFase.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h4 style="margin: 0;">Fase ${faseNumero}</h4>
                    <button type="button" class="btn-button btn-remover" onclick="removerFase(this)">Remover Fase</button>
                </div>

                <div class="form-group">
                    <label for="titulo${faseNumero}">Titulo da fase:</label>
                    <input type="text" id="titulo${faseNumero}" name="titulo[${faseNumero}]"  class="form-control" />
                </div>

                <div class="form-group">
                    <label for="video${faseNumero}">Vídeo do Curso:</label>
                    <input type="file" id="video${faseNumero}" name="video[${faseNumero}]" accept="video/mp4" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="imagem${faseNumero}">Imagem do Curso:</label>
                    <input type="file" id="imagem${faseNumero}" name="imagem[${faseNumero}]" accept="image/*" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="conteudo${faseNumero}">Conteúdo do Curso (Texto):</label>
                    <textarea id="conteudo${faseNumero}" name="conteudo[${faseNumero}]" class="form-control"></textarea>
                </div>

                <input type="hidden" name="fase[]" value="${faseNumero}" />
                `;

            container.appendChild(novaFase);
            contadorFases = faseNumero;
        }

        function removerFase(botao) {
            const fase = botao.closest('.fase');
            fase.remove();
            atualizarFases();
        }

        function atualizarFases() {
            const fases = document.querySelectorAll('#fases-container .fase');
            contadorFases = fases.length;

            fases.forEach((faseDiv, index) => {
                const numFase = index + 1;

                // Atualiza o título da fase
                const titulo = faseDiv.querySelector('h4');
                titulo.textContent = `Fase ${numFase}`;

                // Atualiza o input hidden com a fase correta
                const inputFase = faseDiv.querySelector('input[name="fase[]"]');
                if (inputFase) inputFase.value = numFase;

                // Atualiza os ids e for dos inputs para manter a consistência (opcional, mas recomendado)
                const videoInput = faseDiv.querySelector('input[type="file"][accept="video/mp4"]');
                if (videoInput) {
                    videoInput.id = `video${index}`;
                    const videoLabel = faseDiv.querySelector(`label[for^="video"]`);
                    if (videoLabel) videoLabel.setAttribute('for', videoInput.id);
                }

                const imagemInput = faseDiv.querySelector('input[type="file"][accept^="image"]');
                if (imagemInput) {
                    imagemInput.id = `imagem${index}`;
                    const imagemLabel = faseDiv.querySelector(`label[for^="imagem"]`);
                    if (imagemLabel) imagemLabel.setAttribute('for', imagemInput.id);
                }

                const conteudoTextarea = faseDiv.querySelector('textarea');
                if (conteudoTextarea) {
                    conteudoTextarea.id = `conteudo${index}`;
                    const conteudoLabel = faseDiv.querySelector(`label[for^="conteudo"]`);
                    if (conteudoLabel) conteudoLabel.setAttribute('for', conteudoTextarea.id);
                }
            });
        }
    </script>

    <script>
        const container = document.getElementById('fases-container');
        const fasesCursos = <?php echo json_encode($fasesCursos, JSON_UNESCAPED_UNICODE); ?>;
        //console.log('fasesCursos:', fasesCursos);


        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('input-curso').addEventListener('change', () => {

                const cursoId = document.getElementById('input-curso-id').value = "";
                const container = document.getElementById('fases-container');

                // Limpa fases anteriores (se quiser)
                container.innerHTML = '';

                const novaFase = document.createElement('div');
                novaFase.classList.add('fase', 'card');
                novaFase.setAttribute('style', 'padding: 15px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;');

                novaFase.innerHTML = `
            <h4>Fase 1</h4>

            <div class="form-group">
                <label for="titulo0">Titulo da fase:</label>
                <input type="text" id="titulo0" name="titulo[1]" class="form-control" />
            </div>

            <div class="form-group">
                <label for="video0">Vídeo do Curso:</label>
                <input type="file" id="video0" name="video[1]" accept="video/mp4" class="form-control" />
            </div>

            <div id="oldVideo0" style="margin-bottom: 10px;" hidden>
                <p>Vídeo atual: Nenhum vídeo enviado.</p>
            </div>

            <div class="form-group">
                <label for="imagem0">Imagem do Curso:</label>
                <input type="file" id="imagem0" name="imagem[1]" accept="image/*" class="form-control" />
            </div>

            <div class="form-group">
                <label for="conteudo0">Conteúdo do Curso (Texto):</label>
                <textarea id="conteudo0" name="conteudo[1]" class="form-control"></textarea>
            </div>

            <input type="hidden" name="fase[]" value="1" />
        `;

                container.appendChild(novaFase);
            });


            document.getElementById('input-curso-id').addEventListener('change', () => {


                const cursoId = document.getElementById('input-curso-id').value.trim();


                if (cursoId !== '' && fasesCursos[cursoId] != null) {
                    carregarFasesExistentes(fasesCursos[cursoId]);
                }

            });
        });

        function carregarFasesExistentes(fases) {
            const cursoId = document.getElementById('input-curso-id').value.trim();


            // Limpa o container SEMPRE
            container.innerHTML = "";

            fases.forEach((fase, i) => {
                const numeroFase = fase.Numero_fase ?? (i + 1);
                const novaFase = document.createElement('div');
                novaFase.classList.add('fase', 'card');
                novaFase.setAttribute('style', 'padding: 15px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;');
                novaFase.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h4 style="margin: 0;">Fase ${numeroFase}</h4>
                <form action="acoes/remover_fase.php" method="POST" style="display:inline;">

                    <input type="hidden" name="NomeImagem" value="${fase.imagem}" />
                    <input type="hidden" name="NomeVideo" value="${fase.video}" />
                    <input type="hidden" name="Id_fase" value="${numeroFase}" />
                    <input type="hidden" name="Id_curso" value="${cursoId}" />
                    <button type="submit" class="btn-button btn-remover">Remover Fase</button>
                </form>
            </div>
            <div class="form-group">
                <label for="titulo${numeroFase}">Titulo da fase:</label>
                <input type="text" id="titulo${numeroFase}" name="titulo[${numeroFase}]" value="${fase.titulo || ''}" class="form-control" />
            </div>
            <div class="form-group">
                <label for="video${numeroFase}">Vídeo do Curso:</label>
                <input type="file" id="video${numeroFase}" name="video[${numeroFase}]" accept="video/mp4" class="form-control" />
            </div>

            <div id="oldVideo${numeroFase}" style="margin-bottom: 10px;" ${fase.video ? '' : 'hidden'}>
                <p>${fase.video ? `Vídeo atual: <a href="../../assets/conteudosCursos/videos/${fase.video}" target="_blank">Ver vídeo</a>` : 'Vídeo atual: Nenhum vídeo enviado.'}   Nome do arquivo:${fase.video}
                <form action="acoes/remover_midia.php" method="POST" style="display:inline;">
                
                    <input type="hidden" name="Nome" value="${fase.video}" />
                    <input type="hidden" name="midia" value="videos" />
                    <input type="hidden" name="fase" value="${numeroFase}" />
                    <input type="hidden" name="idCurso" value="${cursoId}" />
                    <button type="submit" class="btn-button btn-remover-video">Remover Vídeo</button>
                </form>
                </p>
            </div>
            
            <div class="form-group">
                <label for="imagem${numeroFase}">Imagem do Curso:</label>
                <input type="file" id="imagem${numeroFase}" name="imagem[${numeroFase}]" accept="image/*" class="form-control" />
            </div>
            <div id="oldImagem${numeroFase}" style="margin-bottom: 10px;" ${fase.imagem ? '' : 'hidden'}>
                <p>${fase.imagem ? `Imagem atual: <a href="../../assets/conteudosCursos/imagens/${fase.imagem}" target="_blank">Ver imagem</a>` : 'Imagem atual: Nenhuma imagem enviada.'} Nome do arquivo:${fase.imagem}
                <form action="acoes/remover_midia.php" method="POST" style="display:inline;">
                    <input type="hidden" name="Nome" value="${fase.imagem}" />
                    <input type="hidden" name="midia" value="imagens" />
                    <input type="hidden" name="fase" value="${numeroFase}" />
                    <input type="hidden" name="idCurso" value="${cursoId}" />
                    <button type="submit" class="btn-button btn-remover-imagem">Remover Imagem</button>
                </form>
                </p>
            </div>

            <div class="form-group">
                <label for="conteudo${numeroFase}">Conteúdo do Curso (Texto):</label>
                <textarea id="conteudo${numeroFase}" name="conteudo[${numeroFase}]" class="form-control">${fase.conteudo || ''}</textarea>
            </div>
            <input type="hidden" name="fase[]" value="${numeroFase}" />
        `;
                container.appendChild(novaFase);
            });

            contadorFases = fases.length;
        }
    </script>


</body>

</html>