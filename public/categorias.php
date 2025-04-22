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
                $idiomaSelecionado = isset($_GET['idioma']) ? $_GET['idioma'] : [];
                ?>
                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Idioma do Curso <i class="fas fa-chevron-up"></i>
                    </button>


                    <div class="filtro-conteudo">
                        <form method="GET" id="filtroForm">
                            <label>
                                <input type="checkbox" name="idioma[]" value="pt" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('pt', $idiomaSelecionado) ? 'checked' : ''; ?> />
                                Português <span>(122)</span>
                            </label>

                            <label>
                                <input type="checkbox" name="idioma[]" value="en" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo in_array('en', $idiomaSelecionado) ? 'checked' : ''; ?> />
                                Inglês <span>(55)</span>
                            </label>
                        </form>
                    </div>

                </div>

                <hr />


                
                <?php
                //com erro
                $descontoSelecionado = isset($_GET['desconto']) ? $_GET['desconto'] : '';
                ?>
                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Filtro de Desconto <i class="fas fa-chevron-up"></i>
                    </button>

                    <div class="filtro-conteudo">
                        <form method="GET" id="filtroForm">
                            <label>
                                <input type="checkbox" name="desconto" value="sim" onchange="document.getElementById('filtroForm').submit()"
                                    <?php echo $descontoSelecionado == 'sim' ? 'checked' : ''; ?> />
                                Com desconto <span>(122)</span>
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
                                while ($row = $result->fetch_assoc()) {
                                    $total = contarValores($conn, 'curso', 'Id_categoria', $row['Id_categoria']);

                                    echo '<label><input type="checkbox" /> ' . htmlspecialchars($row['Nome_cat']) .
                                        ' <span>(' . $total . ')</span></label>';
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
                    $ordenar = $_GET['ordenar'] ?? 'a-z';

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

    function contarValores($conn, $tabela, $Nomecampo, $valor)
    {
        $query = "SELECT COUNT(*) AS total FROM $tabela WHERE $Nomecampo = ?";
        $stmt = $conn->prepare($query);

        if (is_int($valor)) {
            $stmt->bind_param("i", $valor);
        } else {
            $stmt->bind_param("s", $valor);
        }

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