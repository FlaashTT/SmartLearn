<?php

include('../public/segurança.php');
include('../database/basedados.sql');
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
    <link rel="stylesheet" href="../assets/css/style_carrinho.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <header>
        <div class="container">
            <nav>
                <div class="nav-left">
                    <div class="logo">
                        <a href="../public/inicio.php"><img src="../assets/image/Logo.png" alt="Logo" /></a>
                        <span class="brand-name">SmartLearn</span>
                    </div>
                    <ul class="nav-links">
                        <li>
                            <a href="#" class="nav-item">
                                <i class="fas fa-bars"></i> Categorias
                            </a>
                        </li>
                        <li>
                            <input
                                type="text"
                                placeholder="Pesquisar cursos..."
                                class="search-input" />
                        </li>
                    </ul>
                </div>
                <div class="nav-right">
                    <ul class="nav-links">
                        <li>
                            <a href="#" class="nav-item"> Tutorial </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item"> Meus Cursos </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <i class="fa-regular fa-heart"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-item">
                                <i class="fa-regular fa-circle-user"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Secção Principal (Hero) -->
    <main class="container">
        <section class="hero container">
            <div>
                <h1 class="hero-title">Carrinho de Compras</h1>
                <p class="hero-description">
                    Aqui estão os cursos que adicionaste ao teu carrinho. Podes proceder
                    para a compra ou remover cursos do carrinho.
                </p>
            </div>
        </section>
    </main>

    <main class="main-container">


        <section class="compra">
            <h2>Compra:</h2>
            <br>


            <?php

            $stmt = $conn->prepare("
                SELECT * 
                FROM carrinho_compras cc
                INNER JOIN curso c ON cc.Id_curso = c.Id_curso
                WHERE cc.Id_user = ?;
            ");
            $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
            $stmt->execute();
            $result = $stmt->get_result();
            $preçoTotal = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="item">
                         <input type="checkbox" name="cursos[]" value="">
                            <span>' . $row["Nome_curso"] . '</span>
                            <span class="item-price">' . $row["Preco"] . '€</span> 
                        </div>          

                    ';
                    $preçoTotal = $preçoTotal + $row["Preco"];
                }
            } else {
                echo '
                <div class="item">
                    <span>Não tem itens no carrinho</span>
                    
                </div>  
                ';
            }

            ?>


            <a href="inicio.php" class="continue">Continuar a comprar</a>
        </section>

        <aside class="carrinho">
            <h2>Carrinho</h2>
            <br>
            <?php
            $stmt = $conn->prepare("
                    SELECT * 
                    FROM carrinho_compras cc
                    INNER JOIN curso c ON cc.Id_curso = c.Id_curso
                    WHERE cc.Id_user = ?;
                ");
            $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="cart-item">
                            <span>' . $row["Nome_curso"] . '</span>
                            <span>' . $row["Preco"] . '€</span>
                            <form action="../public/removerItem.php" method="POST">
                                <button type="submit" class="remove" name="id_carrinho" value="' . $row['Id_carrinho'] . '">Remover</button>
                            </form>
                        </div>        

                    ';
                }
            } else {
                echo '
                <div class="cart-item">
                    <span>Não tem itens no carrinho</span>
                    
                </div>  
                ';
            }

            $totaliva = $preçoTotal * 0.23;
            $ivaFormatado = number_format($totaliva, 2, ',', '.');
            $preçoTotalComIva = $preçoTotal + $totaliva;
            $preçoTotalComIvaFormatado = number_format($preçoTotalComIva, 2, ',', '.');
            $_SESSION['valorFinal'] = $preçoTotalComIva;
            echo '
            <script>
                window.onload = function() {
                    let btnFinalizarCompra = document.getElementById("btnFinalizarCompra");
                    if('.$preçoTotalComIvaFormatado.' == 0){
                        btnFinalizarCompra.disabled = true;
                        btnFinalizarCompra.style.opacity = "0.5";
                        btnFinalizarCompra.textContent = "Não tem itens no carrinho";
                    }else{
                        btnFinalizarCompra.disabled = false;
                        btnFinalizarCompra.style.opacity = "1";
                        btnFinalizarCompra.textContent = "Finalizar compra";
                    }
                }
            </script>
            <div class="totals">
                <span>Total IVA: ' . $ivaFormatado . '€</span>
                <span>Valor Final: ' . $preçoTotalComIvaFormatado . '€</span>
            </div>
            
            <form action="finalizaCompra.php" method="POST">
                <button type="submit" id="btnFinalizarCompra" class="finalizar" name="valorTotal" ">Finalizar compra</button>
                
            </form>
            ';
            ?>
        </aside>
    </main>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="footer-map">
            <!-- Aqui podes adicionar um iframe com o Google Maps -->
            <iframe
                src=""
                width="100%"
                height="300"
                frameborder="0"
                style="border: 0"
                allowfullscreen=""
                aria-hidden="false"
                tabindex="0"></iframe>
        </div>
        <div class="container footer-content">
            <p>2025 Copyright by Leando Pinto e Ruben Pinheiro</p>
            <p>Castelo Branco – Rua Esperança – 6200-000</p>
            <p>Email: teste@gmail.com | Telefone: 255 777 222 | Fax: 966 662 222</p>
            <p>Privacy Policy | Terms & Conditions</p>
        </div>
    </footer>
</body>

</html>