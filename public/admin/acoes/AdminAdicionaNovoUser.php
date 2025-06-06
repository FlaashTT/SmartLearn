<?php
include("../../../database/basedados.php");

include("../../popup.php");
include("../../logs.php");

$efetuadaTroca = false;
$erro = false;
$textoErro = '';
$TipoAdd = '';
// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['TipoAdd']) || $_POST['TipoAdd'] === '') {
        $textoErro = "Ocorreu um erro tente novamente ou entre em contacto com o suporte";
        $erro = true;
    }
    $TipoAdd = $_POST['TipoAdd'];

    if (

        !isset($_POST['PnomeUser']) &&  $_POST['PnomeUser'] === '' ||
        !isset($_POST['Snomeuser']) &&  $_POST['Snomeuser'] === '' ||
        !isset($_POST['Email']) &&  $_POST['Email'] === '' ||
        !isset($_POST['Password']) &&  $_POST['Password'] === ''
    ) {
        $textoErro = "Não tem todos os campos obrigatorios preenchidos ";
        $erro = true;
    }

    //atribuiçao de variaveis em campos obrigatorios
    $primeiroNome = htmlspecialchars(strip_tags(trim($_POST['PnomeUser'])), ENT_QUOTES, 'UTF-8');
    $sobreNome = htmlspecialchars(strip_tags(trim($_POST['Snomeuser'])), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['Email']), FILTER_SANITIZE_EMAIL);
    $passwordHash = hash('sha256', htmlspecialchars(trim($_POST['Password']), ENT_QUOTES, 'UTF-8'));


    //outras variaveis nao obrigatorios
    $biografia = $_POST['Biografia'] ?? '';
    $urlFacebook = $_POST['URLfacebook'] ?? '';
    $urllinkedin = $_POST['URLlinkedin'] ?? '';
    $urlyoutube = $_POST['URLyoutube'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $textoErro = "O email inserido é invalido!";
        $erro = true;
    }

    //para verificar se o email ja esta em uso
    $testeEmail = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $testeEmail->bind_param("s", $email);
    $testeEmail->execute();
    $resultEmail = $testeEmail->get_result(); // <- Corrigido aqui

    if ($resultEmail->num_rows > 0) {
        $textoErro = "Este endereço de e-mail ja esta a ser usado";
        $erro = true;
    } else {





        date_default_timezone_set("Europe/Lisbon");
        $DataAtual = date("Y-m-d ");

        //comando para inserir o novo utilizador na base de dados 
        $stmt = $conn->prepare("INSERT INTO user (PNome_user, SNome_user, Password, Email, Data_criacao, Biografia, URL_facebook, URL_linkedin, URL_youtube, Tipo_user) VALUES  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $primeiroNome, $sobreNome, $passwordHash, $email, $DataAtual, $biografia, $urlFacebook, $urllinkedin, $urlyoutube, $TipoAdd);

        if ($stmt->execute()) {
            mostrarPopUp("Adicionou com sucesso um novo administrador!");



            $userID = $conn->insert_id;


            if (!empty($_FILES['url_imagem']['name'])) {

                inserirImagem($conn, $userID);
            }
            criarLogs("Novo Registo", $userID);
            
        }
    }
} else {
    caminho();
}

if ($erro) {
    mostrarPopUp($textoErro);
    
}

function caminho()
{
    // Redireciona para a página de administração
    
    echo '
    <script>
    window.location.href = document.referrer;
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

        $diretorio = "../../../assets/image/fotosPerfil/";
        $base_nome = "fotoPerfil_" . $idUser;
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
