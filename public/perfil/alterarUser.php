<?php

include("../../database/basedados.sql");
include("../segurança.php");

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_SESSION['utilizadorOn']['Id_user'];


    //verificar se existe alguma alteração 
    if (
        empty($_POST['primeiroNome']) && empty($_POST['sobrenome']) && empty($_POST['biografia']) && empty($_POST['URL_facebook'])
        &&  empty($_POST['URL_youtube'] && empty($_POST['URL_linkedin']) && empty($_FILES['url_imagem']['name']))
    ) {
        echo '
            <script>
            alert("Nao tem nenhuma alteração para fazer");
            </script>
        ';
        $erro = true;
    }
    //para verificar se nao existe erro com o Id_user
    if (!$idUser) {
        echo '
            <script>
            alert("Erro ao verificar o seu ID");
            </script>
            ';
        $erro = true;
    }


    //primeiro nome
    if (!empty($_POST['primeiroNome'])) {
        $primeiroNome =  htmlspecialchars(strip_tags(trim($_POST['primeiroNome'])), ENT_QUOTES, 'UTF-8');


        $sql = "UPDATE user SET PNome_user = ? WHERE Id_user = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $primeiroNome, $idUser);
        if ($stmt->execute()) {
            $stmt->close();
        }
    }

    //sobrenome
    if (!empty($_POST['sobrenome'])){

        $sobrenome =  htmlspecialchars(strip_tags(trim($_POST['sobrenome'])), ENT_QUOTES, 'UTF-8');


        $sql = "UPDATE user SET SNome_user = ? WHERE Id_user = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $sobrenome, $idUser);
        if ($stmt->execute()) {
            $stmt->close();
        }
    }

    //biografia
    if (!empty($_POST['biografia'])){
        $biografia =  htmlspecialchars(strip_tags(trim($_POST['biografia'])), ENT_QUOTES, 'UTF-8');


        $sql = "UPDATE user SET Biografia = ? WHERE Id_user = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $biografia, $idUser);
        if ($stmt->execute()) {
            $stmt->close();
        }
    }

    //facebook
    if (!empty($_POST['URL_facebook'])){

        $URL_facebook =  htmlspecialchars(strip_tags(trim($_POST['URL_facebook'])), ENT_QUOTES, 'UTF-8');


        $sql = "UPDATE user SET URL_facebook = ? WHERE Id_user = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $URL_facebook, $idUser);
        if ($stmt->execute()) {
            $stmt->close();
        }
    }

    //youtube
    if (!empty($_POST['URL_youtube'])){
        $URL_youtube =  htmlspecialchars(strip_tags(trim($_POST['URL_youtube'])), ENT_QUOTES, 'UTF-8');


        $sql = "UPDATE user SET URL_youtube = ? WHERE Id_user = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $URL_youtube, $idUser);
        if ($stmt->execute()) {
            $stmt->close();
        }
    }

    //linkedin
    if (!empty($_POST['URL_linkedin'])){
        $URL_linkedin =  htmlspecialchars(strip_tags(trim($_POST['URL_linkedin'])), ENT_QUOTES, 'UTF-8');


        $sql = "UPDATE user SET URL_linkedin = ? WHERE Id_user = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $URL_linkedin, $idUser);
        if ($stmt->execute()) {
            $stmt->close();
        }
    }

    //foto perfil
    /*
    if (empty($_FILES['url_imagem']['name'])) {
        echo "<br>URL_imagem: vazio";
    } else {
        echo "<br>URL_imagem: " . $_FILES['url_imagem']['name'];
    }
*/
    if (!$erro) {
        echo '
            <script>
            alert("Alteraçoes realizadas com sucesso!");
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
