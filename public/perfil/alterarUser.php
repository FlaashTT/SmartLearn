<?php

include("../../database/basedados.sql");
include("../segurança.php");

$erro = false;
$alteracaoFeita = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_SESSION['utilizadorOn']['Id_user'];



    //para verificar se nao existe erro com o Id_user
    if (!$idUser) {
        echo '
            <script> 
            alert("Erro ao verificar o seu ID");
            </script>
            ';
        $erro = true;
    }

    $sql = "SELECT * FROM user WHERE Id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();


        //primeiro nome
        if (!empty($_POST['primeiroNome']) && $row['PNome_user'] != $_POST['primeiroNome']) {
            $primeiroNome =  htmlspecialchars(strip_tags(trim($_POST['primeiroNome'])), ENT_QUOTES, 'UTF-8');


            $sql = "UPDATE user SET PNome_user = ? WHERE Id_user = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $primeiroNome, $idUser);
            if ($stmt->execute()) {
                $stmt->close();
                $alteracaoFeita = true;
            }
        }

        //sobrenome
        if (!empty($_POST['sobrenome']) && $row['SNome_user'] != $_POST['sobrenome']) {

            $sobrenome =  htmlspecialchars(strip_tags(trim($_POST['sobrenome'])), ENT_QUOTES, 'UTF-8');


            $sql = "UPDATE user SET SNome_user = ? WHERE Id_user = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $sobrenome, $idUser);
            if ($stmt->execute()) {
                $stmt->close();
                $alteracaoFeita = true;
            }
        }

        //biografia
        if (!empty($_POST['biografia']) && $row['Biografia'] != $_POST['biografia']) {
            $biografia =  htmlspecialchars(strip_tags(trim($_POST['biografia'])), ENT_QUOTES, 'UTF-8');


            $sql = "UPDATE user SET Biografia = ? WHERE Id_user = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $biografia, $idUser);
            if ($stmt->execute()) {
                $stmt->close();
                $alteracaoFeita = true;
            }
        }

        //facebook
        if (!empty($_POST['URL_facebook']) && $row['URL_facebook'] != $_POST['URL_facebook']) {

            $URL_facebook =  htmlspecialchars(strip_tags(trim($_POST['URL_facebook'])), ENT_QUOTES, 'UTF-8');


            $sql = "UPDATE user SET URL_facebook = ? WHERE Id_user = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $URL_facebook, $idUser);
            if ($stmt->execute()) {
                $stmt->close();
                $alteracaoFeita = true;
            }
        }

        //youtube
        if (!empty($_POST['URL_youtube']) && $row['URL_youtube'] != $_POST['URL_youtube']) {
            $URL_youtube =  htmlspecialchars(strip_tags(trim($_POST['URL_youtube'])), ENT_QUOTES, 'UTF-8');


            $sql = "UPDATE user SET URL_youtube = ? WHERE Id_user = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $URL_youtube, $idUser);
            if ($stmt->execute()) {
                $stmt->close();
                $alteracaoFeita = true;
            }
        }

        //linkedin
        if (!empty($_POST['URL_linkedin']) && $row['URL_linkedin'] != $_POST['URL_linkedin']) {
            $URL_linkedin =  htmlspecialchars(strip_tags(trim($_POST['URL_linkedin'])), ENT_QUOTES, 'UTF-8');


            $sql = "UPDATE user SET URL_linkedin = ? WHERE Id_user = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $URL_linkedin, $idUser);
            if ($stmt->execute()) {
                $stmt->close();
                $alteracaoFeita = true;
            }
        }

        //foto perfil
        if (!empty($_FILES['url_imagem']['name'])) {

            //verificar se ja existe imagem na base de dados
            if (empty($row['URL_imagem_perfilUser'])) {
                // Se não existir imagem, apenas insere a nova imagem
                inserirImagem($conn, $idUser);
            } else {
                // Se já existe imagem, elimina a antiga e depois insere a nova
                $file = "../../assets/image/fotosPerfil/" . $_SESSION['utilizadorOn']['URL_foto_perfilUser'];

                if (file_exists($file)) {
                    if (unlink($file)) {
                        echo "Imagem antiga removida com sucesso!";

                        // Agora insere a nova imagem e atualiza a base de dados
                        inserirImagem($conn, $idUser);
                        $alteracaoFeita = true;
                    } else {
                        echo "<script>alert('Erro ao remover a imagem antiga!');</script>";
                    }
                } else {
                    echo "<script>alert('Erro ao atualizar a foto de perfil!');</script>";
                    $erro = true;
                }
            }
        }


        //email
        if (!empty($_POST['email']) && $row['Email'] != $_POST['email']) {
            $email =  htmlspecialchars(strip_tags(trim($_POST['email'])), ENT_QUOTES, 'UTF-8');


            $sql = "UPDATE user SET email = ? WHERE Id_user = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $email, $idUser);
            if ($stmt->execute()) {
                $stmt->close();
                $alteracaoFeita = true;
            }
        }

        //trocar palavra pass
        if (!empty($_POST['OldPass']) && !empty($_POST['novaPass'])) {
            // Verifica se a senha nova é igual à senha antiga
            if ($_POST['OldPass'] == $_POST['novaPass']) {
                echo "<script>
                alert('A palavra passe nova não pode ser igual à antiga!');
                </script>";
                $erro = true;
            } else {
                $passantigaBD = $row['Password']; 

                if (hash('sha256', $_POST['OldPass']) == $passantigaBD) {
                   
                    $password = hash('sha256', $_POST['novaPass']);

                    // Atualizar na BD
                    $sql = "UPDATE user SET Password = ? WHERE Id_user = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $password, $idUser);

                    if ($stmt->execute()) {
                        $stmt->close();
                        $alteracaoFeita = true;
                    } else {
                        echo "<script>alert('Erro ao atualizar a senha.');</script>";
                    }
                } else {
                    echo "<script>
                    alert('Palavra passe atual incorreta!');
                    </script>";
                    $erro = true;
                }
            }
        }
    }

    if (!$erro && $alteracaoFeita) {
        echo '
            <script>
            alert("Alteraçoes realizadas com sucesso!");
            window.location.href = document.referrer;
            </script>
            ';
    } elseif (!$alteracaoFeita) {
        echo '
        <script>
            alert("Nenhuma mudança registada!");
            window.location.href = document.referrer;
        </script>
        ';
    }
} else {
    $erro = true;
}

if ($erro) {
    echo '
        <script>
            window.history.back();
        </script>
    ';
    exit();
}
function inserirImagem($conn, $idUser)
{
    //guarada o nome da imagem
    $extensao = strtolower(pathinfo($_FILES["url_imagem"]["name"], PATHINFO_EXTENSION));

    //para garantir que apenas sao permitidos jpg,jpeg e png
    $extensoes_permitidas = ['jpg', 'jpeg', 'png'];
    $tipo_mime = mime_content_type($_FILES["url_imagem"]["tmp_name"]);
    $mimes_permitidos = ['image/jpeg', 'image/png'];

    if (in_array($extensao, $extensoes_permitidas) && in_array($tipo_mime, $mimes_permitidos)) {

        $diretorio = "../../assets/image/fotosPerfil/";
        $base_nome = "fotoPerfil_" . $_SESSION['utilizadorOn']['Id_user'];
        $novo_nome = $base_nome . "." . $extensao;
        $destino = $diretorio . $novo_nome;

        // verifica se exite alguma imagem com tipo diferente e elimina
        foreach (['jpg', 'jpeg', 'png'] as $ext) {
            $possivel_arquivo = $diretorio . $base_nome . '.' . $ext;
            if (file_exists($possivel_arquivo)) {
                unlink($possivel_arquivo);
            }
        }

        //copia para o destino final(pasta de imagens)
        if (move_uploaded_file($_FILES["url_imagem"]["tmp_name"], $destino)) {
            $URL_foto = $novo_nome;

            $sql = "UPDATE user SET URL_foto_perfilUser = ? WHERE Id_user = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $URL_foto, $idUser);
            if ($stmt->execute()) {
                $stmt->close();
                $_SESSION['utilizadorOn']['URL_foto_perfilUser'] = $novo_nome;
                echo "<br>Imagem atualizada com sucesso!";
            } else {
                echo "<br>Erro ao atualizar o banco de dados!";
            }
        } else {
            echo "<br>Erro ao mover a imagem!";
        }
    } else {
        echo "<br>Formato de imagem inválido. Apenas JPG, JPEG e PNG são permitidos.";
    }
}
