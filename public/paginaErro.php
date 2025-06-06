<!DOCTYPE html>
<html lang="pt">
<?php
$estado = "erro";  // altera para testar manutenção ou erro
$horas = 0; // número de horas que o site estará em manutenção

// Calcular timestamp final da manutenção
$timestampFinal = time() + ($horas * 3600);
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Site em Manutenção</title>
    <link rel="stylesheet" href="../assets/css/style_manutencao.css" />
    <link rel="stylesheet" href="../assets/fontawesome/fontawesome/css/all.min.css" />
</head>

<body>
    <div class="background">
        <div class="shape square"></div>
        <div class="shape circle"></div>
        <div class="shape triangle"></div>
        <div class="shape rectangle"></div>
    </div>

    <?php if ($estado === "manutencao") {

        echo '
        <div class="container">
            <div class="content">
                <i class="fas fa-tools icon animated-icon"></i>
                <h1>Estamos em Manutenção</h1>
                <p>Estamos a melhorar o nosso site.</p>
                ';
                if($horas > 0) {
                    echo '<p>Prevemos voltar dentro de </p>
                <div id="cronometro" class="cronometro-container"></div>';
                } else {
                    echo '<p>Prevemos voltar em breve.</p>';
                }
                echo'
                
            </div>
            
        </div>
        ';
    } else {
        echo '
        <div class="container">
            <div class="content">
                <i class="fas fa-exclamation-triangle icon animated-icon"></i>
                <h1>Ocorreu um Erro</h1>
                <p>Pedimos desculpa, mas ocorreu um problema.<br>Por favor, tente novamente mais tarde.</p>
                <form action="inicio.php" method="get">
                    <button type="submit" class="novamente">Tentar Novamente</button>
                </form>
            </div>
        </div>
        ';
    }

    if ($estado === "manutencao") {
        echo "
<script>
    // Assumindo que timestampFinal já está definido no PHP e passado para JS
    const timestampFinal = $timestampFinal * 1000;

    function atualizarCronometro() {
        const agora = new Date().getTime();
        let distancia = timestampFinal - agora;

        if (distancia < 0) {
            document.getElementById('cronometro').innerHTML = 'Manutenção concluída!';
            clearInterval(intervalo);
            setTimeout(() => {
                window.location.href = 'inicio.php';
            }, 3000);
            return;
        }

        const horas = Math.floor(distancia / (1000 * 60 * 60));
        const minutos = Math.floor((distancia % (1000 * 60 * 60)) / (1000 * 60));
        const segundos = Math.floor((distancia % (1000 * 60)) / 1000);

        document.getElementById('cronometro').innerHTML =
            '<div class=\"cronometro-item\">' + String(horas).padStart(2, '0') + '<span class=\"cronometro-label\">h</span></div>' +
            '<div class=\"cronometro-item\">' + String(minutos).padStart(2, '0') + '<span class=\"cronometro-label\">m</span></div>' +
            '<div class=\"cronometro-item\">' + String(segundos).padStart(2, '0') + '<span class=\"cronometro-label\">s</span></div>';
    }

    atualizarCronometro();
    const intervalo = setInterval(atualizarCronometro, 1000);
</script>
";
    }
    ?>
</body>

</html>