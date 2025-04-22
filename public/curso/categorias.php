<?php
include("../../database/basedados.sql");
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
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="stylesheet" href="../../assets/css/style_categorias.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <?php

    include("../../src/views/utils/cabecalho.html");
    ?>

    <!-- Secção Principal (Hero) -->
    <main class="container">
        <section class="banner-promocional">
            <div class="container-banner">
                <ul class="beneficios">
                    <li><i class="fas fa-check"></i> Curso atualizado com os tópicos mais relevantes</li>
                    <li><i class="fas fa-check"></i> Acesso a materiais exclusivos</li>
                    <li><i class="fas fa-check"></i> Suporte de instrutores qualificados</li>
                </ul>
                <button class="btn-ver-cursos">VER CURSOS</button>
            </div>
        </section>

        <section class="filtros-a">
            <div class="filtros-aplicados">
                <div class="filtros-cont">
                    <span>1 filtro aplicado: <a href="#">Limpar tudo</a></span>
                </div>
                <div class="ordenar-por">
                    <label for="ordenar">Ordenar por</label>
                    <select id="ordenar">
                        <option>Relevância</option>
                        <option>Mais Recentes</option>
                        <option>Melhor Avaliados</option>
                        <option>Preço Mais Baixo</option>
                        <option>Preço Mais Alto</option>
                    </select>
                </div>
            </div>

        </section>

        <main class="container-categorias">

            <aside class="sidebar-filtros">

                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Idioma do Curso <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <label><input type="checkbox" /> Português <span>(122)</span></label>
                        <label><input type="checkbox" /> Inglês <span>(55)</span></label>
                        <label><input type="checkbox" /> Espanhol <span>(52)</span></label>
                        <label><input type="checkbox" /> Francês <span>(52)</span></label>
                        <label><input type="checkbox" /> Alemão <span>(52)</span></label>
                    </div>
                </div>

                <hr />

                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Desconto Direto <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <label><input type="checkbox" /> Até 20% <span>(289)</span></label>
                        <label><input type="checkbox" /> De 20% a 30% <span>(1)</span></label>
                        <label><input type="checkbox" /> De 30% a 50% <span>(1)</span></label>
                    </div>
                </div>

                <hr />

                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Nível de Dificuldade <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <?php
                        $stmt = $conn->prepare("
                        SELECT Dificuldade FROM curso 
                        WHERE Dificuldade IS NOT NULL AND Dificuldade <> ''
                        GROUP BY Dificuldade
                    ");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Contar quantas vezes   aparece
                                $countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM curso WHERE Dificuldade = ?");
                                $countStmt->bind_param("s", $row['Dificuldade']);
                                $countStmt->execute();
                                $countResult = $countStmt->get_result();
                                $countData = $countResult->fetch_assoc();

                                // Exibir o checkbox com a dificuldade e total
                                echo '<label><input type="checkbox" /> ' . htmlspecialchars($row['Dificuldade']) .
                                    ' <span>(' . $countData['total'] . ')</span></label>';
                            }
                        } else {
                            echo '<label>Sem dificuldade disponiveis <span></span></label>';
                        }
                        ?>
                    </div>
                </div>

                <hr />

                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Duração de Curso <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <label><input type="checkbox" /> Menos de 1 hora <span>(289)</span></label>
                        <label><input type="checkbox" /> De 1 a 3 horas <span>(30)</span></label>
                        <label><input type="checkbox" /> De 3 a 5 horas <span>(10)</span></label>
                        <label><input type="checkbox" /> Mais de 5 horas <span>(1)</span></label>
                    </div>
                </div>

                <hr />

                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Avaliações <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo" style="display: none;">
                        <label>
                            <input type="checkbox" />
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <span>(120)</span>
                        </label>
                        <label>
                            <input type="checkbox" />
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="far fa-star" style="color: gold;"></i>
                            <span>(98)</span>
                        </label>
                        <label>
                            <input type="checkbox" />
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="far fa-star" style="color: gold;"></i>
                            <i class="far fa-star" style="color: gold;"></i>
                            <span>(45)</span>
                        </label>
                        <label>
                            <input type="checkbox" />
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="fas fa-star" style="color: gold;"></i>
                            <i class="far fa-star" style="color: gold;"></i>
                            <i class="far fa-star" style="color: gold;"></i>
                            <i class="far fa-star" style="color: gold;"></i>
                            <span>(12)</span>
                        </label>
                    </div>
                </div>

                <hr />

                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Categorias <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <div class="filtro-pesquisa">
                            <input type="text" placeholder="Pesquisa" />
                            <button><i class="fas fa-search"></i></button>
                        </div>
                        <div class="filtro-opcoes scroll-y">

                            <?php
                            $stmt = $conn->prepare("
                                Select * from categoria ;
                            ");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM categoria where Nome_cat = ?");
                                    $countStmt->bind_param("s", $row['Nome_cat']);
                                    $countStmt->execute();
                                    $countResult = $countStmt->get_result();
                                    $countData = $countResult->fetch_assoc();
                                    echo '<label><input type="checkbox" /> ' . htmlspecialchars($row['Nome_cat']) .
                                        ' <span>(' . $countData['total'] . ')</span></label>';
                                }
                            } else {
                                echo " <label> Sem categorias disponiveis <span></span></label>";
                            }

                            ?>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Preço <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <div class="filtro-preco">
                            <input type="number" placeholder="Min" />
                            <span>-</span>
                            <input type="number" placeholder="Max" />
                            <button class="btn-ok">OK</button>
                        </div>
                        <div class="filtro-conteudo">
                            <label><input type="checkbox" /> 0-30 </label>
                            <label><input type="checkbox" /> 30-60 </label>
                            <label><input type="checkbox" /> 60-100 </label>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="categoria">
                <section class="lista-cursos">

                    <?php
                    $stmt = $conn->prepare("
                    Select * from curso ;
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '
                                <div class="course-card">
                                    <div class="course-image">
                                        <img src="../../assets/image/'.$row['URL_foto_perfil_curso'].'" alt="Erro" style="width: 270px;">
                                    </div>
                                    <div class="course-info">
                                        <h3>'.$row['Nome_curso'].'</h3>
                                        <hr>
                                        <div class="stars">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-regular fa-star"></i> <!-- Estrela vazia para uma avaliação de 4.5 -->
                                        </div>
                                        <p class="course-description">
                                            Este curso oferece uma introdução
                                            <span class="more-text" style="display: none;">
                                                Este curso fornece uma introdução sólida ao desenvolvimento web front-end, explorando as linguagens essenciais para criar páginas modernas e responsivas...
                                            </span>
                                        </p>
                                        <button class="ver-mais-btn" onclick="toggleDescription(this)">Ver mais</button>

                                        <!-- Novas secções para Dificuldade e Idioma -->
                                        <div class="course-difficulty-language">
                                            <span class="difficulty">Dificuldade: <strong>Intermediário</strong></span>
                                        </div>
                                        <div class="course-difficulty-language">
                                            <span class="language">Idioma: <strong>Português</strong></span>
                                        </div>

                                        <div class="course-price">
                                            <span class="price">€49.99</span>
                                            <span class="original-price">€79.99</span> <!-- Preço original com desconto -->
                                        </div>
                                        <button class="start-button">
                                            <a href="/compra-curso" style="text-decoration: none; color: #fff;">Comprar</a>
                                        </button>
                                    </div>
                                </div>
                            ';
                        }
                    }
                    ?>








                </section>
            </main>
        </main>
    </main>

    <!-- Rodapé -->
    <?php
    include("../../src/views/utils/rodape.html");
    ?>

    <script>
        function toggleFiltro(btn) {
            btn.classList.toggle('ativo');
            const conteudo = btn.nextElementSibling;
            conteudo.style.display = conteudo.style.display === 'none' ? 'block' : 'none';
            const icon = btn.querySelector('i');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        }

        function toggleSecao(btn) {
            const conteudo = btn.nextElementSibling;
            const icon = btn.querySelector('i');

            if (conteudo.style.display === 'none') {
                conteudo.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                conteudo.style.display = 'none';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }

        // Mostrar todos os filtros abertos inicialmente
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".filtro-conteudo").forEach(el => el.style.display = "block");
        });
    </script>

    <script>
        function toggleFiltro(btn) {
            const conteudo = btn.nextElementSibling;
            const icon = btn.querySelector('i');

            conteudo.classList.toggle('fechado');
            btn.classList.toggle('closed');
        }

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".filtro-conteudo").forEach(el => {
                el.classList.remove('fechado');
            });
        });

        function toggleDescription(btn) {
            const card = btn.closest('.course-card'); // Só procura dentro deste card
            const moreText = card.querySelector('.more-text');
            const description = card.querySelector('.course-description');

            if (moreText.style.display === "none" || moreText.style.display === "") {
                moreText.style.display = "inline";
                btn.textContent = "Ver menos";
                description.style.maxHeight = "none";
            } else {
                moreText.style.display = "none";
                btn.textContent = "Ver mais";
                description.style.maxHeight = "80px";
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filtrosCont = document.querySelector('.filtros-cont');
            const filtroTexto = filtrosCont.querySelector('span');
            const checkboxes = document.querySelectorAll('.filtro-conteudo input[type="checkbox"]');
            const inputMin = document.querySelector('.filtro-preco input[placeholder="Min"]');
            const inputMax = document.querySelector('.filtro-preco input[placeholder="Max"]');
            const selects = document.querySelectorAll('.ordenar-por select');
            const filtroSecaoInputs = document.querySelectorAll('.filtro-secao input[type="text"]'); // Todos os campos de texto de filtros
            const limparTudo = document.querySelector('.filtros-cont a');

            function atualizarTextoFiltros() {
                // Conta quantos filtros estão aplicados
                const filtrosCheckbox = Array.from(checkboxes).filter(cb => cb.checked).length;
                const filtrosPreco = (inputMin.value.trim() !== '' || inputMax.value.trim() !== '') ? 1 : 0;
                const filtroSelect = Array.from(selects).filter(select => select.value !== 'Relevância').length; // Assumimos que "Relevância" é o valor inicial, logo não aplicado
                const totalFiltros = filtrosCheckbox + filtrosPreco + filtroSelect;

                if (totalFiltros > 0) {
                    filtrosCont.style.display = 'flex';
                    filtroTexto.innerHTML = `${totalFiltros} filtro${totalFiltros > 1 ? 's' : ''} aplicado${totalFiltros > 1 ? 's' : ''}: <a href="#">Limpar tudo</a>`;
                } else {
                    filtrosCont.style.display = 'none';
                }
            }

            // Função para limpar todos os filtros
            limparTudo.addEventListener('click', (e) => {
                e.preventDefault();

                // Limpar todos os checkboxes, desmarcar e desativá-los
                checkboxes.forEach(cb => {
                    cb.checked = false; // Desmarca todas as checkboxes
                    cb.disabled = true; // Desativa todas as checkboxes
                });

                // Limpar campos de pesquisa (texto) em cada filtro de secção
                filtroSecaoInputs.forEach(input => {
                    input.value = ''; // Limpa todos os campos de texto
                });

                // Limpar campos de preço
                inputMin.value = '';
                inputMax.value = '';

                // Limpar todos os selects e restaurá-los ao valor inicial (Relevância)
                selects.forEach(select => {
                    select.value = 'Relevância'; // Assumindo que "Relevância" é o valor inicial
                });

                // Atualizar a exibição dos filtros aplicados
                atualizarTextoFiltros();
            });

            // Adicionar event listeners para atualização
            checkboxes.forEach(cb => cb.addEventListener('change', atualizarTextoFiltros));
            filtroSecaoInputs.forEach(input => input.addEventListener('input', atualizarTextoFiltros));
            inputMin.addEventListener('input', atualizarTextoFiltros);
            inputMax.addEventListener('input', atualizarTextoFiltros);
            selects.forEach(select => select.addEventListener('change', atualizarTextoFiltros));

            // Inicializa a contagem e exibição dos filtros
            atualizarTextoFiltros();
        });
    </script>







</body>

</html>