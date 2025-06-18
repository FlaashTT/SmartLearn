<?php

include("../../database/basedados.php");
include("segurançaAdmin.php");
include("../popup.php");
include("../logs.php");

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
    <link rel="stylesheet" href="../../assets/css/admin/style_configuracoes.css" />
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
                        <i style="font-size: 18px; margin-right: 10px;" class="fas fa-book"></i> Configurações do site
                    </h1>
                </section>

                <section class="page">
                    <h2>Configuração</h2>

                    <?php
                    $sql = "
                        SELECT cs.*, u.Pnome_user, u.Snome_user
                        FROM configuracoes_site cs
                        INNER JOIN user u ON cs.Id_utilizador_Ultimo_update = u.Id_user
                        WHERE cs.Id_configuracao = 1
                        ";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo '
                            <!-- Formulário de Administração -->
                            <form class="form-group" action="acoes/alterar_configuracoes.php" method="POST" enctype="multipart/form-data">
                                <label for="titulo">Título do Banner:</label>
                                <input type="text" id="titulo_banner" name="titulo_banner" value="' . $row['Titulo_banner'] . '" placeholder="Introduzir um nome do banner" required />

                                <label for="titulo">Sub-título do Banner:</label>
                                <input type="text" id="subtitulo_banner" name="subtitulo_banner" value="' . $row['Subtitulo_banner'] . '" placeholder="Introduzir um nome do sub-banner" required />

                                <label for="titulo">Cookie status:</label>
                                <input type="text" id="cookie_status" name="cookie_status" value="' . $row['Cookies_status'] . '" placeholder="Introduzir vários status" required />

                                <label for="titulo">Cookie note:</label>
                                <input type="text" id="cookie_note" name="cookie_note" value="' . $row['cookie_note'] . '" placeholder="Introduzir notas" required />

                                <label for="titulo">Facebook:</label>
                                <input type="url" id="facebook_link" name="facebook_link" value="' . $row['Facebook'] . '" placeholder="Introduzir o URL da plataforma" />

                                <label for="titulo">Linkedin:</label>
                                <input type="url" id="linkedin_link" name="linkedin_link" value="' . $row['Linkedin'] . '" placeholder="Introduzir o URL da plataforma" />

                                <label for="politicaCookies">Política de cookies:</label>
                                <textarea id="politicaCookies" name="politicaCookies" placeholder="Escreve a política de cookies..." maxlength="1000">' . $row['politica_cookies'] . '</textarea>

                                <p>Ultima atualização:</p>
                                <p  style="margin-bottom: 20px;">Feita por:' . $row['Pnome_user'] . ' ' . $row['Snome_user'] . ' id(' . $row['Id_utilizador_Ultimo_update'] . ') em ' . $row['data_update'] . ' </p>


                                <button class="btn-button" type="submit">Enviar</button>
                            </form>
                    ';
                    } else {
                        criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'],  null,  null,  null, "Erro ao carregar configurações do sistema", __FILE__);
                        mostrarPopUp("Erro ao carregar configurações do sistema",null,"admin_base.php");
                    }

                    ?>
    </div>
    </section>

    </main>
    </main>
    </div>

    
    


</body>

</html>