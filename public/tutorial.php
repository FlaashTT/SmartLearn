<?php
session_start();
include("../database/basedados.php");
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartLearn</title>
    <link
        rel="stylesheet"
        href="../assets/fontawesome/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/style_user.css" />
    <link rel="stylesheet" href="../assets/css/style_tutorial.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <?php
    include("../src/views/utils/cabacalhoNaoLogado.html");
    ?>

    <section class="capitulos-tutorial">
        <h2>Capítulos do Tutorial</h2>
        <div class="capitulos-grid">
            <a href="#" class="capitulo-btn" data-target="capitulo1">1. Criar Conta</a>
            <a href="#" class="capitulo-btn" data-target="capitulo2">2. Navegar nos Cursos</a>
            <a href="#" class="capitulo-btn" data-target="capitulo3">3. Aulas e Progresso</a>
            <a href="#" class="capitulo-btn" data-target="capitulo5">4. Suporte</a>
        </div>
    </section>

    <div class="accordion">
        <div class="accordion-item" id="capitulo1">
            <button class="accordion-header">
                1. Criar Conta <i class="fas fa-chevron-right arrow"></i>
            </button>
            <div class="accordion-content">
                <img
                    src="../assets/image/tutorial/Pagina-Inicial_N_logado.png"
                    alt="Criar Conta"
                    style="
              max-width: 100%;
              border-radius: 8px;
              margin-bottom: 15px;
              margin-top: 15px;
            " />
                <ul>
                    <li>Clica em "inscrever-se" no topo da página.</li>
                </ul>
                <img
                    src="../assets/image/tutorial/Incrisao.png"
                    alt="Criar Conta"
                    style="max-width: 100%; border-radius: 8px; margin-bottom: 15px" />
                <ul>
                    <li>Preenche os dados com nome, email e password.</li>
                </ul>
                <img
                    src="../assets/image/tutorial/Conectar-se.png"
                    alt="Criar Conta"
                    style="max-width: 100%; border-radius: 8px; margin-bottom: 15px" />
                <ul>
                    <li>Inicia sessão e começa a aprender!</li>
                </ul>
            </div>
        </div>
        <div class="accordion-item" id="capitulo2">
            <button class="accordion-header">
                2. Navegar nos Cursos <i class="fas fa-chevron-right arrow"></i>
            </button>
            <div class="accordion-content">
                <img
                    src="../assets/image/tutorial/Selecao-Categorias.png"
                    alt="Criar Conta"
                    style="max-width: 100%; border-radius: 8px; margin-bottom: 15px" />
                <ul>
                    <li>Filtra por categoria usando o menu de "Categorias".</li>
                </ul>
                <img
                    src="../assets/image/tutorial/Categorias.png"
                    alt="Criar Conta"
                    style="max-width: 100%; border-radius: 8px; margin-bottom: 15px" />
                <ul>
                    <li>Procura com a filtros de pesquisa.</li>
                    <li>
                        Lê a descrição e avaliações antes de inscreveres-te/comprar.
                    </li>
                </ul>
            </div>
        </div>
        <div class="accordion-item" id="capitulo3">
            <button class="accordion-header">
                3. Aulas e Progresso <i class="fas fa-chevron-right arrow"></i>
            </button>
            <div class="accordion-content">
                <img
                    src="../assets/image/tutorial/Icon-Perfil.png"
                    alt="Criar Conta"
                    style="max-width: 100%; border-radius: 8px; margin-bottom: 15px" />
                <ul>
                    <li>
                        Clica no ícone do perfil no topo para acederes aos teus cursos.
                    </li>
                </ul>
                <img
                    src="../assets/image/tutorial/Perfil-curso.png"
                    alt="Criar Conta"
                    style="max-width: 100%; border-radius: 8px; margin-bottom: 15px" />
                <ul>
                    <li>
                        Utiliza os filtros de pesquisa para encontrares cursos do teu
                        interesse.
                    </li>
                    <li>
                        No teu perfil, acede à secção "Os Meus Cursos" para continuares
                        onde ficaste ou explorares a capa de cada curso disponível.
                    </li>
                </ul>
                <img
                    src="../assets/image/tutorial/Capa-Curso.png"
                    alt="Criar Conta"
                    style="max-width: 100%; border-radius: 8px; margin-bottom: 15px" />
                <ul>
                    <li>
                        Analisa a capa do curso para teres uma ideia do conteúdo e do
                        estilo antes de começares.
                    </li>
                    <li>
                        Clica em "Avançar Conteúdo" para veres o conteúdo do curso e
                        começares a aprender.
                    </li>
                </ul>
                <img
                    src="../assets/image/tutorial/Curso-conteudo.png"
                    alt="Criar Conta"
                    style="max-width: 100%; border-radius: 8px; margin-bottom: 15px" />
                <ul>
                    <li>Vê aulas em vídeo e acede as fases restantes.</li>
                    <li>Vê o teu progresso em percentagem através da barra visível.</li>
                    <li>Podes parar e retomar quando quiseres.</li>
                </ul>
            </div>
        </div>
        <div class="accordion-item" id="capitulo5">
            <button class="accordion-header">
                4. Suporte <i class="fas fa-chevron-right arrow"></i>
            </button>
            <div class="accordion-content">
                <ul class="suporte-lista">
                    <li>Contacta-nos por email disponível no final da página.</li>
                    <li>Respostas rápidas para dúvidas comuns.</li>
                    <li>Estamos disponíveis em dias úteis, 9h-18h.</li>
                    <li>Entre outros</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <?php
    include("../src/views/utils/rodape.html");
    ?>
</body>

<script>
    // Scroll suave ao clicar num botão do capítulo
    document.querySelectorAll(".capitulo-btn").forEach((botao) => {
        botao.addEventListener("click", (e) => {
            e.preventDefault();
            const idCapitulo = botao.dataset.target;
            const secao = document.getElementById(idCapitulo);
            if (secao) {
                // Ativa o acordeão primeiro
                document.querySelectorAll(".accordion-item").forEach((item) => {
                    item.classList.toggle("active", item.id === idCapitulo);
                });

                // Depois espera um pouco para o layout atualizar e faz o scroll
                setTimeout(() => {
                    const offset = 80;
                    const topPos =
                        secao.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({
                        top: topPos,
                        behavior: "smooth"
                    });
                }, 100); // 100ms pode ser ajustado para mais ou menos
            }
        });
    });

    // Funcionamento do acordeão (abrir/fechar)
    document.querySelectorAll(".accordion-header").forEach((header) => {
        header.addEventListener("click", () => {
            const item = header.parentElement;
            const isActive = item.classList.contains("active");

            // Fecha todos
            document.querySelectorAll(".accordion-item").forEach((otherItem) => {
                otherItem.classList.remove("active");
            });

            // Se não estava ativo, ativa o clicado
            if (!isActive) {
                item.classList.add("active");
            }
        });
    });
</script>

</html>