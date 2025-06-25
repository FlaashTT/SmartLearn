<?php

include('../segurança.php');
include('../../database/basedados.php');
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
    <link rel="stylesheet" href="../../assets/css/style_user.css" />
    <link rel="stylesheet" href="../../assets/css/style_carrinho.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <?php
    include("../../src/views/utils/cabecalho.html");
    $listaCursos = "";
    $listaCursosarray =[];
    ?>

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
                            <span>' . $row["Nome_curso"] . '</span>
                            <span class="item-price">' . $row["Preco"] . '€</span> 
                        </div>          

                    ';
                    $listaCursosarray[] = $row['Id_curso']; 

                    
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


            <a href="../inicio.php" class="continue">Continuar a comprar</a>
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
                echo '<input type="hidden" id="quantidadeCarrinho" name="nomeDoCampo" value="1">';
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="cart-item">
                            <span>' . $row["Nome_curso"] . '</span>
                            <span>' . $row["Preco"] . '€</span>
                            <form action="removerItem.php" method="POST">
                                <button type="submit" class="remove" name="id_carrinho" value="' . $row['Id_carrinho'] . '">Remover</button>
                            </form>
                        </div>        

                    ';
                }
            } else {
                echo '<input type="hidden" id="quantidadeCarrinho" name="nomeDoCampo" value="0">';
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
            $_SESSION['listaCursos'] = $listaCursosarray;
            echo '
            <script>
                window.onload = function() {
                    let btnFinalizarCompra = document.getElementById("btnFinalizarCompra");
                    let total = document.getElementById("quantidadeCarrinho").value;
                    if(total == 0){
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
    <?php
        include("../../src/views/utils/rodape.html");
    ?>
</body>

</html>