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
    <link rel="stylesheet" href="../../assets/css/style_perfil_atualizar.css" />
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

                <h2>Editar Perfil</h2>
                <p>Adicionar informação sobre teu perfil</p>

                <?php
                $sql = "SELECT * FROM user WHERE Id_user = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $stmt->close();

                    //ecrypt é necesssario para enviar ficheiros
                    echo '
                    <form action="alterarUser.php" method="POST" enctype="multipart/form-data">
                         <div class="divider"></div>
                        <div class="from-group">
                            <label for="primeiro-nome">Primeiro Nome</label>';
                    $primeiroNome = !empty($row['PNome_user']) ? $row['PNome_user'] : '';
                    echo '<input type="text" id="primeiro-nome" name="primeiroNome" placeholder="Primeiro nome" value ="'.$primeiroNome.'" />';

                    echo ' 
                        </div>
                        <div class="from-group">
                            <label for="sobrenome">Sobrenome</label>
                            ';
                    $sobrenome = !empty($row['SNome_user']) ? $row['SNome_user'] : '';
                    echo '<input type="text" id="sobrenome" name="sobrenome" placeholder="sobrenome" value ="'.$sobrenome.'" />';


                    echo '
                        </div>
                        <div class="from-group">
                            <label for="biografia">Biografia</label>
                            ';
                    $biografia = !empty($row['Biografia']) ? $row['Biografia'] : '';
                    echo '<textarea name="biografia" id="biografia" placeholder="Escreva algo sobre voce..." ">'.$biografia.'</textarea>
                    
                    </div>';

                    echo '
                            
                        

                        <div class="divider"></div>
                        <div class="from-group-social">
                            <label for="facebook-link">Adicionar teu Facebook Link</label>
                            <div class="input-wrapper">
                                <span class="icon-square"><i class="fa-brands fa-facebook"></i></span>';
                    $facebook = !empty($row['URL_facebook']) ? htmlspecialchars($row['URL_facebook']) : '';
                    echo '<input type="text" id="facebook-link" name="URL_facebook" placeholder="Link do Facebook" value="' . $facebook . '">';

                    echo '
                                
                            </div>
                        </div>

                        <div class="from-group-social">
                            <label for="youtube-link">Adicionar teu Youtube Link</label>
                            <div class="input-wrapper">
                                <span class="icon-square"><i class="fa-brands fa-youtube"></i></span>';
                    $youtube = !empty($row['URL_youtube']) ? htmlspecialchars($row['URL_youtube']) : '';
                    echo '<input type="text" id="youtube-link" name="URL_youtube" placeholder="Link do Youtube" value="' . $youtube . '">';

                    echo '
                                
                            </div>
                        </div>

                        <div class="from-group-social">
                            <label for="linkedin-link">Adicionar teu Linkedin Link</label>
                            <div class="input-wrapper">
                                <span class="icon-square"><i class="fa-brands fa-linkedin"></i></span>';
                    $linkedin = !empty($row['URL_linkedin']) ? htmlspecialchars($row['URL_linkedin']) : 'Link do Linkedin';
                    echo '<input type="text" id="linkedin-link" name="URL_linkedin" placeholder="Link do Linkedin" value="'.$linkedin.'">';

                    echo '
                                
                            </div>
                        </div>
                        
                        <div class="divider"></div>
                        <div class="from-group file-input">
                            <label>Alterar imagem de perfil</label>
                            <input type="file" id="profile-image" name="url_imagem" accept=".jpg, .jpeg, .png">';
                    
                    echo '
                        </div>

                        <div class="submit-button">
                            <button>
                                <span><i class="fa-solid fa-floppy-disk"></i></span> Guardar
                            </button>
                        </div>
                        </form>
                         ';
                } else {
                    echo 'Ocorreu um erro ao verificar o ser perfil!';
                }
                ?>

            </div>

        </section>
    </main>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="footer-map">
            <!-- Aqui podes adicionar um iframe com o Google Maps -->
            <iframe src="" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
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