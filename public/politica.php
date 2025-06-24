<?php
session_start();
include("../database/basedados.php");
$sql = "SELECT * FROM configuracoes_site WHERE Id_configuracao = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $config = $result->fetch_assoc();
    // agora você pode acessar: $config['nome_do_campo']
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
        href="../assets/fontawesome/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/style_politica.css" />
</head>

<body>
    <!-- Cabeçalho -->
    <?php
    include("../src/views/utils/cabacalhoNaoLogado.html");
    ?>

    <section class="politica-container">
        <div class="banner">
            <h1>Política de Privacidade</h1>
            <p class="subtitulo">
                Transparência sobre o uso dos teus dados e cookies
            </p>
        </div>

        <div class="conteudo">
            <h2>Estado dos Cookies</h2>
            <p><strong>Status:</strong>
                <?php
                if ($config['Cookies_status'] === "Aceite") {
                    echo '<span class="ativo">Ativo</span></p>';
                } else {
                    echo '<span class="inativo">Inativo</span></p>';
                }


                if (isset($_SESSION['utilizadorOn']['Id_user'])) {
                    $sql = "SELECT Estado_cookies_user FROM user WHERE Id_user = ?";
                    $stmt = $conn->prepare($sql);

                    if ($stmt) {
                        $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
                        $stmt->execute();
                        $stmt->bind_result($estadoCookies);

                        if ($stmt->fetch()) {
                            if ($estadoCookies === "Nao aceite") {
                                echo '
                                    <form action="verificarCookies.php" method="POST">
                                        <div class="cookie-notice">
                                            <p>
                                                <strong>Nota sobre os Cookies:</strong> Utilizamos cookies para
                                                garantir uma melhor experiência, personalizar conteúdo e analisar o
                                                tráfego.
                                                <a href="politicaCookies.php" target="_blank" rel="noopener noreferrer">Saber mais</a>
                                            </p>
                                            <button class="cookie-btn" id="aceitar">Aceitar</button>
                                        </div>
                                    </form>';
                            }
                        }

                        $stmt->close();
                    }
                }

                ?>



            <h2>Redes Sociais</h2>
            <ul>
                <li>
                    <strong>Facebook:</strong>
                    <a href="<?= $config['Facebook'] ?>" target="_blank">SmartLearn no Facebook</a>
                </li>
                <li>
                    <strong>LinkedIn:</strong>
                    <a href="<?= $config['Linkedin'] ?>" target="_blank">Smartlearn no LinkedIn</a>
                </li>
            </ul>

            <h2>Política de Cookies</h2>
            <p>
                <?php
                if ($config['politica_cookies'] !== "" && $config['politica_cookies'] !== null) {
                    echo $config['politica_cookies'];
                } else {
                    echo 'Sem valores de política de cookies';
                }
                ?>
            </p>
        </div>
    </section>

    <!-- Rodapé -->
    <?php
    include("../src/views/utils/rodape.html");
    ?>
</body>
<script>

</script>

</html>