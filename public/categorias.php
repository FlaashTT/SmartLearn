<?php
session_start();
include("../database/basedados.sql");

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

    <?php
    if (isset($_SESSION['utilizadorOn'])) {
        echo '<link rel="stylesheet" href="../assets/css/style_user.css" />';
    } else {
        echo '<link rel="stylesheet" href="../assets/css/style.css" />';
    }
    ?>

    <link rel="stylesheet" href="../assets/css/style_categorias.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <?php
    include("../src/views/utils/cabacalhoNaoLogado.html");
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
                <?php
                $ordenar = isset($_GET['ordenar']) ? $_GET['ordenar'] : 'a-z';
                ?>

                <form method="GET" id="ordenarForm" class="ordenar-por">
                    <select name="ordenar" onchange="document.getElementById('ordenarForm').submit()">
                        <option value="a-z" <?php echo ($ordenar == 'a-z') ? 'selected' : ''; ?>>A-Z</option>
                        <option value="recentes" <?php echo ($ordenar == 'recentes') ? 'selected' : ''; ?>>Mais Recentes</option>
                        <option value="avaliados" <?php echo ($ordenar == 'avaliados') ? 'selected' : ''; ?>>Mais Avaliados</option>
                        <option value="preco_baixo" <?php echo ($ordenar == 'preco_baixo') ? 'selected' : ''; ?>>Preço (mais baixo)</option>
                        <option value="preco_alto" <?php echo ($ordenar == 'preco_alto') ? 'selected' : ''; ?>>Preço (mais alto)</option>
                    </select>
                </form>



            </div>

        </section>

        <main class="container-categorias">

            <aside class="sidebar-filtros">

                <?php
                $ordenar = $_GET['ordenar'] ?? 'a-z';
                $idiomaSelecionado = isset($_GET['idioma']) ? $_GET['idioma'] : [];
                $descontoSelecionado = isset($_GET['desconto']) ? $_GET['desconto'] : [];
                $dificuldadeSelecionada = isset($_GET['dificuldade']) ? $_GET['dificuldade'] : [];
                $duracaoSelecionada = isset($_GET['duracao']) ? $_GET['duracao'] : [];
                $avaliacaoSelecionada = isset($_GET['avaliacao']) ? $_GET['avaliacao'] : [];
                $categoriaSelecionada = isset($_GET['categoria']) ? $_GET['categoria'] : [];
                $precoSelecionado = isset($_GET['preco']) ? $_GET['preco'] : [];
                ?>



                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Idioma do Curso <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <form method="GET" id="filtroForm">
                            <label>
                                <?php

                                $total = contarValores($conn, "curso", "Idioma_principal = 'Português'");
                                ?>
                                <input type="checkbox" name="idioma[]" value="pt" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('pt', $idiomaSelecionado) ? 'checked' : ''; ?> />
                                Português
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>
                                <?php
                                $total = contarValores($conn, "curso", "Idioma_principal = 'ingles'");
                                ?>
                                <input type="checkbox" name="idioma[]" value="en" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('en', $idiomaSelecionado) ? 'checked' : ''; ?> />
                                Inglês <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                        </form>
                    </div>

                </div>

                <hr />




                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Filtro de Desconto <i class="fas fa-chevron-up"></i>
                    </button>

                    <div class="filtro-conteudo">
                        <form method="GET" id="filtroForm">
                            <label>
                                <?php

                                $total = contarValores($conn, "curso", "Preco_antigo IS NOT NULL AND Preco_antigo <> 0 AND Preco_antigo > Preco");
                                ?>
                                <input type="checkbox" name="desconto[]" value="comDesconto" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('comDesconto', $descontoSelecionado) ? 'checked' : ''; ?> />
                                Com desconto <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>
                                <?php
                                $total = contarValores($conn, 'curso', 'Preco_antigo IS NULL OR Preco_antigo = 0 OR Preco_antigo < Preco');
                                ?>
                                <input type="checkbox" name="desconto[]" value="semDesconto" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('semDesconto', $descontoSelecionado) ? 'checked' : ''; ?> />
                                Sem desconto <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>
                                <?php
                                $total = contarValores($conn, 'curso');
                                ?>
                                <input type="checkbox" name="desconto[]" value="ambos" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('ambos', $descontoSelecionado) ? 'checked' : ''; ?> />
                                Mostrar tudo <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                        </form>
                    </div>
                </div>



                <hr />



                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Nível de Dificuldade <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <form method="GET" id="filtroForm">
                            <?php
                            $total = "por fazer";
                            ?>
                            <label>
                                <input type="checkbox" name="dificuldade[]" value="Iniciante" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('Iniciante', $dificuldadeSelecionada) ? 'checked' : ''; ?> />
                                Iniciante <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                            <label>
                                <input type="checkbox" name="dificuldade[]" value="intermedio" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('intermedio', $dificuldadeSelecionada) ? 'checked' : ''; ?> />
                                Intermédio <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                            <label>
                                <input type="checkbox" name="dificuldade[]" value="avançado" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('avançado', $dificuldadeSelecionada) ? 'checked' : ''; ?> />
                                Avançado <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                        </form>
                    </div>
                </div>




                <hr />

                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Duração de Curso <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <form method="GET" id="filtroForm">
                            <label>
                                <input type="checkbox" name="duracao[]" value="menos1h" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('menos1h', $duracaoSelecionada) ? 'checked' : ''; ?> />
                                Menos de 1 hora <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                            <label>
                                <input type="checkbox" name="duracao[]" value="1ha3h" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('1ha3h', $duracaoSelecionada) ? 'checked' : ''; ?> />
                                De 1 a 3 horas <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                            <label>
                                <input type="checkbox" name="duracao[]" value="3ha5h" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('3ha5h', $duracaoSelecionada) ? 'checked' : ''; ?> />
                                De 3 a 5 horas <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                            <label>
                                <input type="checkbox" name="duracao[]" value="mais5" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('mais5', $duracaoSelecionada) ? 'checked' : ''; ?> />
                                Mais de 5 horas<span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                        </form>
                    </div>
                </div>


                <hr />

                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Avaliações <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo" style="display: none;">
                        <form method="GET" id="filtroForm">
                            <label>

                                <input type="checkbox" name="avaliacao[]" value="classificacao5" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('classificacao5', $avaliacaoSelecionada) ? 'checked' : ''; ?> />
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>

                                <input type="checkbox" name="avaliacao[]" value="classificacao4" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('classificacao4', $avaliacaoSelecionada) ? 'checked' : ''; ?> />
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>

                                <input type="checkbox" name="avaliacao[]" value="classificacao3" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('classificacao3', $avaliacaoSelecionada) ? 'checked' : ''; ?> />
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>

                                <input type="checkbox" name="avaliacao[]" value="classificacao2" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('classificacao2', $avaliacaoSelecionada) ? 'checked' : ''; ?> />
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>

                                <input type="checkbox" name="avaliacao[]" value="classificacao1" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('classificacao1', $avaliacaoSelecionada) ? 'checked' : ''; ?> />
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>
                                <input type="checkbox" name="avaliacao[]" value="semClassificacao" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('semClassificacao', $avaliacaoSelecionada) ? 'checked' : ''; ?> />
                                <span style="color: gold;">Sem classificação</span>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                        </form>
                    </div>
                </div>



                <hr />

                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Categorias <i class="fas fa-chevron-up"></i>
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
                                echo '<form method="GET" id="filtroForm">';
                                while ($row = $result->fetch_assoc()) {
                                    // $total = contarValores($conn, 'curso', 'Id_categoria', $row['Id_categoria']);

                                    echo '<label>
                                            <input type="checkbox" name="categoria[]" value="' . $row['Nome_cat'] . '" onchange="document.getElementById(\'filtroForm\').submit()" ' .
                                        (in_array($row['Nome_cat'], $categoriaSelecionada) ? 'checked' : '') . ' />
                                            ' . htmlspecialchars($row['Nome_cat']) . '
                                            <span>(' . $total . ')</span>
                                        </label>';
                                }
                                echo '</form>';
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
                        Preço <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <div class="filtro-preco">
                            <input type="number" placeholder="Min" />
                            <span>-</span>
                            <input type="number" placeholder="Max" />
                            <button class="btn-ok">OK</button>
                        </div>
                        <div class="filtro-conteudo">
                            <form method="GET" id="filtroForm">
                                <label>
                                    <input type="checkbox" name="preco[]" value="ate30" onchange="document.getElementById('filtroForm').submit()"
                                        <?php echo in_array('ate30', $precoSelecionado) ? 'checked' : ''; ?> />
                                    0-30
                                </label>
                                <label>
                                    <input type="checkbox" name="preco[]" value="de30a60" onchange="document.getElementById('filtroForm').submit()"
                                        <?php echo in_array('de30a60', $precoSelecionado) ? 'checked' : ''; ?> />
                                    30-60
                                </label>
                                <label>
                                    <input type="checkbox" name="preco[]" value="de60a100" onchange="document.getElementById('filtroForm').submit()"
                                        <?php echo in_array('de60a100', $precoSelecionado) ? 'checked' : ''; ?> />
                                    60-100
                                </label>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="categoria">
                <section class="lista-cursos">

                    <?php


                    $orderBy = "nome ASC"; // valor padrão

                    switch ($ordenar) {
                        case 'recentes':
                            $orderBy = "Data_criacao DESC";
                            break;
                        case 'avaliados':
                            $orderBy = "Classificacao DESC";
                            break;
                        case 'preco_baixo':
                            $orderBy = "Preco ASC";
                            break;
                        case 'preco_alto':
                            $orderBy = "Preco DESC";
                            break;
                        case 'a-z':
                        default:
                            $orderBy = "Nome_curso ASC";
                            break;
                    }

                    $query = "SELECT * FROM curso ORDER BY $orderBy";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '
                                <div class="course-card">
                                    <div class="course-image">
                                        <img src="../assets/image/curso/' . $row['URL_foto_perfil_curso'] . '" alt="Erro" >
                                    </div>
                                    <div class="course-info">
                                        <h3>' . $row['Nome_curso'] . '</h3>
                                        <hr>
                                        <div class="stars">
                                        ';
                            if ($row['Classificacao'] === 0) {
                                echo ("Sem classificação");
                            } else {
                                for ($i = 0; $i < $row['Classificacao']; $i++) {
                                    echo '<i class="fa-solid fa-star"></i>';
                                }
                            }

                            $descricao = $row['Descricao'];
                            $limite = 80;
                            $proximoLimite = $limite + 20;  // Considerar os próximos 20 caracteres após o limite inicial

                            // Procurar o primeiro ponto dentro dos próximos 20 caracteres após o limite
                            $descricaoParte = substr($descricao, $limite, 20);
                            $posPontoDepois = strpos($descricaoParte, '.');

                            // Ajustar a posição para o índice real no texto original
                            if ($posPontoDepois !== false) {
                                $posPontoDepois += $limite;  // Ajusta a posição para o índice real no texto original
                            }

                            // Se houver um ponto nos próximos 20 caracteres o tamanho estende ate ao ponto
                            if ($posPontoDepois !== false) {
                                $descricao_curta = substr($descricao, 0, $posPontoDepois + 1);  // Inclui o ponto
                            } else {
                                // Caso não haja ponto dentro dos próximos 20 caracteres fica com o limete de 80
                                $descricao_curta = substr($descricao, 0, $proximoLimite);
                            }

                            $descricao_completa = substr($descricao, strlen($descricao_curta));



                            echo '
                                        </div>
                                        <p class="course-description">
                                            ' . htmlspecialchars($descricao_curta) . '
                                            <span class="more-text" style="display: none;">
                                                ' . htmlspecialchars($descricao_completa) . '
                                            </span>
                                        </p>
                                        <button class="ver-mais-btn" onclick="toggleDescription(this)">Ver mais</button>

                                        <!-- Novas secções para Dificuldade e Idioma -->
                                        <div class="course-difficulty-language">
                                            <span class="difficulty">Dificuldade: <strong>' . $row['Dificuldade'] . '</strong></span>
                                        </div>
                                        <div class="course-difficulty-language">
                                            <span class="language">Idioma: <strong>' . $row['Idioma_principal'] . '</strong></span>
                                        </div>
                                        
                                        <div class="course-price">
                                            <span class="price">' . $row['Preco'] . '€</span>
                                            ';
                            if ($row['Preco_antigo'] !== null && $row['Preco_antigo'] != 0.00) {
                                echo '<span class="original-price">' . $row['Preco_antigo'] . '€</span> <!-- Preço original sem desconto -->';
                            }

                            echo '
                                        </div>
                                            ';

                            echo '
                                    <form action="carrinho/adicionarAocarrinho.php" method="POST">
                                        <button name="IdCurso" value="' . $row['Id_curso'] . '" class="start-button">
                                            Comprar
                                        </button>
                                    </form>
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
    include("../src/views/utils/rodape.html");

    function contarValores($conn, $tabela, $condicao = null)
    {
        if ($condicao === null) {
            $query = "SELECT COUNT(*) AS total FROM $tabela";
        } else {
            $query = "SELECT COUNT(*) AS total FROM $tabela WHERE $condicao";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $dados = $result->fetch_assoc();

        return $dados['total'];
    }


    ?>



    <script>
        function toggleFiltro(btn) {
            btn.classList.toggle('ativo');
            const conteudo = btn.nextElementSibling;
            const icon = btn.querySelector('i');

            const isHidden = conteudo.style.display === 'none' || conteudo.style.display === '';

            if (isHidden) {
                conteudo.style.display = 'block';
                conteudo.style.pointerEvents = 'auto'; // Permite interação
            } else {
                conteudo.style.display = 'none';
                conteudo.style.pointerEvents = 'none'; // Impede interação
            }

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