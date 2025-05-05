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
    <script src="../assets/js/categorias.js" defer></script>
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
                <?php
                $search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
                if (isset($_GET['search']) && $_GET['search'] != '') {
                    echo "<p>Resultado da pesquisa: <strong>" . htmlspecialchars($search) . "</strong></p>";
                }
                ?>
                <div class="filtros-cont" style="display: none;">
                    <span>0 filtros aplicados:
                        <a href="#" id="limpar-tudo">Limpar tudo</a>
                    </span>
                </div>
                <?php
                $ordenar = isset($_POST['ordenar']) ? $_POST['ordenar'] : 'a-z';
                ?>

                <form method="POST" id="ordenarForm" class="ordenar-por">
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






                <div class="filtro-secao">
                    <button class="filtro-titulo" onclick="toggleFiltro(this)">
                        Idioma do Curso <i class="fas fa-chevron-up"></i>
                    </button>
                    <div class="filtro-conteudo">
                        <form method="GET" id="filtroForm">
                            <label>
                                <?php

                                $total = contarValores($conn, "curso", "Idioma_principal = 'Português'");
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="idioma[]" value="português" onchange="efetuarPesquisa(this,'idioma_português')"
                                    <?php
                                    echo $desabilitar; ?> />
                                Português
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>
                                <?php

                                $total = contarValores($conn, "curso", "Idioma_principal = 'ingles'");
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="idioma[]" value="ingles" onchange="efetuarPesquisa(this,'idioma_ingles')"
                                    <?php echo $desabilitar; ?> />
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
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="desconto[]" value="comDesconto" onchange="efetuarPesquisa(this, 'desconto_comDesconto')"
                                    <?php echo $desabilitar; ?> />
                                Com desconto <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>
                                <?php
                                $total = contarValores($conn, 'curso', 'Preco_antigo IS NULL OR Preco_antigo = 0 OR Preco_antigo < Preco');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="desconto[]" value="semDesconto" onchange="efetuarPesquisa(this, 'desconto_semDesconto')"
                                    <?php echo $desabilitar; ?> />
                                Sem desconto <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>
                                <?php

                                $total = contarValores($conn, 'curso');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="desconto[]" value="ambos" onchange="efetuarPesquisa(this, 'desconto_semSelecao')"
                                    <?php echo $desabilitar; ?> />
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
                            $total = contarValores($conn, 'curso', 'Dificuldade = "Iniciante"');
                            $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                            ?>
                            <label>
                                <input type="checkbox" name="dificuldade[]" value="Iniciante" onchange="efetuarPesquisa(this,'dificuldade_Iniciante')"
                                    <?php echo $desabilitar; ?> />
                                Iniciante <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                            <label>
                                <?php
                                $total = contarValores($conn, 'curso', 'Dificuldade = "intermedio"');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="dificuldade[]" value="intermedio" onchange="efetuarPesquisa(this,'dificuldade_intermedio')"
                                    <?php echo $desabilitar; ?> />
                                Intermédio <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>
                            <label>
                                <?php
                                $total = contarValores($conn, 'curso', 'Dificuldade = "avançado"');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="dificuldade[]" value="avançado" onchange="efetuarPesquisa(this,'dificuldade_avançado')"
                                    <?php echo $desabilitar; ?> />
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

                            <?php
                            $total = contarValores($conn, 'curso', 'Tempo_estimado <= "01:00:00"');
                            $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                            ?>
                            <label>
                                <input type="checkbox" name="duracao[]" value="menos1h" onchange="efetuarPesquisa(this,'tempo_menos1h')"
                                    <?php echo $desabilitar; ?> />
                                Até 1 hora <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <?php
                            $total = contarValores($conn, 'curso', 'Tempo_estimado > "01:00:00" AND Tempo_estimado <= "03:00:00"');
                            $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                            ?>
                            <label>
                                <input type="checkbox" name="duracao[]" value="1ha3h" onchange="efetuarPesquisa(this,'tempo_1ha3h')"
                                    <?php echo $desabilitar; ?> />
                                De 1 a 3 horas <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <?php
                            $total = contarValores($conn, 'curso', 'Tempo_estimado > "03:00:00" AND Tempo_estimado <= "06:00:00"');
                            $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                            ?>
                            <label>
                                <input type="checkbox" name="duracao[]" value="3ha6h" onchange="efetuarPesquisa(this,'tempo_3ha6h')"
                                    <?php echo $desabilitar; ?> />
                                De 3 a 6 horas <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <?php
                            $total = contarValores($conn, 'curso', 'Tempo_estimado > "06:00:00" AND Tempo_estimado <= "17:00:00"');
                            $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                            ?>
                            <label>
                                <input type="checkbox" name="duracao[]" value="de6a17h" onchange="efetuarPesquisa(this,'tempo_6ha17h')"
                                    <?php echo $desabilitar; ?> />
                                De 6 a 17 horas<span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <?php
                            $total = contarValores($conn, 'curso', 'Tempo_estimado > "17:00:00"');
                            $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                            ?>
                            <label>
                                <input type="checkbox" name="duracao[]" value="mais17" onchange="efetuarPesquisa(this,'tempo_mais17h')"
                                    <?php echo $desabilitar; ?> />
                                Mais de 17 horas<span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
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

                                <?php
                                $total = contarValores($conn, 'curso', 'Classificacao = 5 ');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="avaliacao[]" value="5" onchange="efetuarPesquisa(this,'avaliacao_5')"
                                    <?php echo $desabilitar; ?> />
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>
                                <?php
                                $total = contarValores($conn, 'curso', 'Classificacao = 4 ');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>

                                <input type="checkbox" name="avaliacao[]" value="4" onchange="efetuarPesquisa(this,'avaliacao_4')"
                                    <?php echo $desabilitar; ?> />
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>

                                <?php
                                $total = contarValores($conn, 'curso', 'Classificacao = 3 ');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="avaliacao[]" value="3" onchange="efetuarPesquisa(this,'avaliacao_3')"
                                    <?php echo $desabilitar; ?> />
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>

                                <?php
                                $total = contarValores($conn, 'curso', 'Classificacao = 2 ');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="avaliacao[]" value="2" onchange="efetuarPesquisa(this,'avaliacao_2')"
                                    <?php echo $desabilitar; ?> />
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <label>

                                <?php
                                $total = contarValores($conn, 'curso', 'Classificacao = 1 ');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <input type="checkbox" name="avaliacao[]" value="1" onchange="efetuarPesquisa(this,'avaliacao_1')"
                                    <?php echo $desabilitar; ?> />
                                <i class="fas fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <i class="far fa-star" style="color: gold;"></i>
                                <span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                            </label>

                            <?php
                            $total = contarValores($conn, 'curso', 'Classificacao = 0 ');
                            $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                            ?>
                            <label>
                                <input type="checkbox" name="avaliacao[]" value="0" onchange="efetuarPesquisa(this,'avaliacao_0')"
                                    <?php echo $desabilitar; ?> />
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
                            <input type="text" placeholder="Pesquisa" id="pesquisaCat" />
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
                                echo '<p id="mensagemErro" style="display: none; color: red;">Nome inválido</p>';

                                while ($row = $result->fetch_assoc()) {
                                    $total = contarValores($conn, 'curso', "Id_categoria = '" . $row['Id_categoria'] . "'");
                                    $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';

                                    echo '<label class="catLabel" data-nome="' . htmlspecialchars($row['Nome_cat']) . '">
                                            <input type="checkbox" name="categoria[]" value="' . $row['Nome_cat'] . '" onchange="efetuarPesquisa(this,\'categoria_' . $row['Nome_cat'] . '\')"                                          
                                        echo $desabilitar;/>
                                            ' . htmlspecialchars($row['Nome_cat']) . '
                                            <span>(' . (($total == 0 || empty($total)) ? '0' : $total) . ')</span>
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
                            <input type="number" id="precoMin" placeholder="Min" />
                            <span>-</span>
                            <input type="number" id="precoMax" placeholder="Max" />
                            <button class="btn-ok">OK</button>
                        </div>
                        <div class="filtro-conteudo">
                            <form method="GET" id="filtroForm">
                                <?php
                                $total = contarValores($conn, 'curso', 'Preco = 0 OR Preco = null');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <label>
                                    <input type="checkbox" name="preco[]" value="gratuito" onchange="efetuarPesquisa(this,'preco_gratuito')"
                                        <?php echo $desabilitar; ?> />
                                    Gratuito<span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                                </label>

                                <label>
                                    <?php
                                    $total = contarValores($conn, 'curso', 'Preco <=30');
                                    $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                    ?>
                                    <input type="checkbox" name="preco[]" value="ate30" onchange="efetuarPesquisa(this,'preco_Ate30')"
                                        <?php echo $desabilitar; ?> />
                                    Até 30<span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                                </label>

                                <?php
                                $total = contarValores($conn, 'curso', 'Preco >30 AND Preco <= 60');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <label>
                                    <input type="checkbox" name="preco[]" value="de30a60" onchange="efetuarPesquisa(this,'preco_30a60')"
                                        <?php echo $desabilitar; ?> />
                                    30-60<span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
                                </label>
                                <?php
                                $total = contarValores($conn, 'curso', 'Preco >60');
                                $desabilitar = ($total == 0 || empty($total)) ? 'disabled' : '';
                                ?>
                                <label>
                                    <input type="checkbox" name="preco[]" value="maisde60" onchange="efetuarPesquisa(this,'preco_mais60')"
                                        <?php echo $desabilitar; ?> />
                                    Mais de 60<span>(<?php echo ($total == 0 || empty($total)) ? '0' : $total; ?>)</span>
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

                    $query = "SELECT curso.*, categoria.* 
                                    FROM curso 
                                    INNER JOIN categoria ON curso.Id_categoria = categoria.Id_categoria 
                                    ORDER BY $orderBy";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        echo '<p id="mensagemErroPreco" style="display: none; color: red;">Nenhum curso encontrado nesses valores</p>';
                        while ($row = $result->fetch_assoc()) {

                            echo '
                                    <div class="course-card produto"
                                        data-idioma="' . strtolower($row['Idioma_principal']) . '" 
                                        data-desconto="' . (
                                $row['Preco_antigo'] != null && $row['Preco_antigo'] != 0 && $row['Preco_antigo'] > $row['Preco']
                                ? 'comDesconto'
                                : 'semDesconto'
                            ) . '"
                                        data-dificuldade="' . $row['Dificuldade'] . '"
                                        data-duracao="' . $row['Tempo_estimado'] . '"
                                        data-avaliacao="' . $row['Classificacao'] . '"
                                        data-categoria="' . $row['Nome_cat'] . '" 
                                        data-preco="' . $row['Preco'] . '"
                                    >
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
                            $proximoLimite = $limite + 20;
                            $descricao_curta = '';
                            $descricao_completa = '';

                            if (strlen($descricao) < $limite) {
                                $descricao_curta = $descricao;
                                // Se a descrição for menor que o limite, não exibe o botão "Ver mais"
                                $mostrarBotaoVerMais = false;
                            } else {
                                // Procurar o primeiro ponto dentro dos próximos 20 caracteres após o limite
                                $descricaoParte = substr($descricao, $limite, 20);
                                $posPontoDepois = strpos($descricaoParte, '.');

                                // Ajustar a posição para o índice real no texto original
                                if ($posPontoDepois !== false) {
                                    $posPontoDepois += $limite;
                                }

                                // Se houver um ponto nos próximos 20 caracteres, o tamanho estende até o ponto
                                if ($posPontoDepois !== false) {
                                    $descricao_curta = substr($descricao, 0, $posPontoDepois + 1);
                                } else {
                                    $descricao_curta = substr($descricao, 0, $proximoLimite);
                                }
                                // A descrição completa é o restante
                                $descricao_completa = substr($descricao, strlen($descricao_curta));
                                $mostrarBotaoVerMais = true; // Exibe o botão "Ver mais" se a descrição for maior que o limite
                            }



                            echo '
                                        </div>
                                        <p class="course-description">
                                            ' . htmlspecialchars($descricao_curta) . '
                                            <span class="more-text" style="display: none;">
                                                ' . htmlspecialchars($descricao_completa) . '
                                            </span>
                                        </p>';

                            if ($mostrarBotaoVerMais) {
                                echo '<button class="ver-mais-btn" id="maistexto" onclick="toggleDescription(this)">Ver mais</button>';
                            }

                            echo '
                                        <!-- Novas secções para Dificuldade e Idioma -->
                                        <div class="course-difficulty-language">
                                            <span class="difficulty">Dificuldade: <strong>' . $row['Dificuldade'] . '</strong></span>
                                        </div>
                                        <div class="course-difficulty-language">
                                            <span class="language">Idioma: <strong>' . $row['Idioma_principal'] . '</strong></span>
                                        </div>
                                        
                                        <div class="course-price ">
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
            const filtroSecaoInputs = document.querySelectorAll('.filtro-secao input[type="text"]');

            // Função para limpar todos os filtros
            function limparFiltros() {
                console.log("Clicou em limpar");

                checkboxes.forEach(cb => cb.checked = false);
                inputMin.value = '';
                inputMax.value = '';
                selects.forEach(select => select.value = 'Relevância');
                filtroSecaoInputs.forEach(input => input.value = '');

                atualizarTextoFiltros();
            }

            // Função para atualizar o texto de filtros aplicados
            function atualizarTextoFiltros() {
                const filtrosCheckbox = Array.from(checkboxes).filter(cb => cb.checked).length;
                const filtrosPreco = (inputMin.value.trim() !== '' && !isNaN(inputMin.value) && inputMin.value > 0) ||
                    (inputMax.value.trim() !== '' && !isNaN(inputMax.value) && inputMax.value > 0) ? 1 : 0;

                const filtroSelect = Array.from(selects).filter(select =>
                    select.name !== 'ordenar' && select.value !== 'Relevância'
                ).length;

                const totalFiltros = filtrosCheckbox + filtrosPreco + filtroSelect;

                if (totalFiltros > 0) {
                    filtrosCont.style.display = 'flex'; // Mostra o contêiner de filtros aplicados
                    filtroTexto.innerHTML = `${totalFiltros} filtro${totalFiltros > 1 ? 's' : ''} aplicado${totalFiltros > 1 ? 's' : ''}: <a href="#" id="limpar-tudo">Limpar tudo</a>`;

                    // Reatribui o evento de clique no novo link
                    const novoLink = document.getElementById('limpar-tudo');
                    if (novoLink) {
                        novoLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            limparFiltros();
                        });
                    }
                } else {
                    filtrosCont.style.display = 'none'; // Esconde o contêiner de filtros aplicados
                    filtroTexto.innerHTML = ''; // Garante que o texto seja limpo
                }
            }
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    atualizarTextoFiltros();
                });
            });

            [inputMin, inputMax].forEach(input => {
                input.addEventListener('input', () => {
                    atualizarTextoFiltros();
                });
            });
            selects.forEach(select => {
                select.addEventListener('change', () => {
                    atualizarTextoFiltros();
                });
            });

            const limparInicial = document.getElementById('limpar-tudo');
            if (limparInicial) {
                limparInicial.addEventListener('click', function(e) {
                    e.preventDefault();
                    limparFiltros();
                });
            }

            atualizarTextoFiltros();
        });
    </script>







</body>

</html>