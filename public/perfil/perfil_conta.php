<?php
include("../../database/basedados.sql");
include("../segurança.php");
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
    <link rel="stylesheet" href="../../assets/css/style_perfil_conta.css" />
    <script src="../../assets/js/perfil_conta.js"></script>
</head>

<body>
    <!-- Cabeçalho -->
    <?php
    include("../../src/views/utils/cabecalho.html");
    ?>

    <!-- Secção Principal (Hero) -->
    <div class="banner"></div>
    <main class="container-perfil">

        <?php
        include("../../src/views/utils/sidebar.html");
        ?>

        <section class="content">



            <div class="form-container">
                <h2>Informação da Conta</h2>
                <p>Edição da tua conta</p>
                <div class="divider"></div>


                <?php
                $sql = "SELECT Email FROM user WHERE Id_user = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $stmt->close();

                    echo '
                 <form action="alterarUser.php" method="POST">
                    <div class="from-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" placeholder="Teste@gmail.com" value="' . $row['Email'] . '" />
                    </div>
                    ';
                }

                ?>



                <div class="divider"></div>
                <div class="from-group-conta">
                    <label for="old-password">Password antiga</label>
                    <div class="input-wrapper">
                        <span class="icon-square"><i class="fa-solid fa-lock"></i></span>
                        <input type="password"  placeholder="Digite sua senha antiga" id="old-password">
                    </div>
                </div>
                <div class="from-group-conta">
                    <label for="new-password">Nova password</label>
                    <div class="input-wrapper">
                        <span class="icon-square"><i class="fa-solid fa-key"></i></span>
                        <input type="password"  placeholder="Digite sua nova senha" id="new-password">
                    </div>
                </div>
                <div class="from-group-conta">
                    <label for="confirm-password">Confirmação password</label>
                    <div class="input-wrapper">
                        <span class="icon-square"><i class="fa-solid fa-check"></i></span>
                        <input type="password"  placeholder="Confirme sua nova senha" id="confirm-password">
                    </div>
                </div>
                <div class="submit-button">
                    <button id="Button">
                        <span><i class="fa-solid fa-floppy-disk"></i></span> Guardar
                    </button>
                </div>
                </form>
            </div>

        </section>
    </main>

    <!-- Rodapé -->
    <?php
        include("../../src/views/utils/rodape.html");
    ?>
</body>

</html>