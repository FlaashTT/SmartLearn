<?php
include("../../../database/basedados.php");
include("inserirImagemCat.php");
session_start();
require_once("../../popup.php");
require_once("../../logs.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = false;
    $textoErro = "";
    $alteracaoFeita = false;
    $id_config = 1;

    $sql = "
                    SELECT cs.*, u.Pnome_user, u.Snome_user
                    FROM configuracoes_site cs
                    INNER JOIN user u ON cs.Id_utilizador_Ultimo_update = u.Id_user
                    WHERE cs.Id_configuracao = 1
                    ";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $textoErro = "Erro na coleta de dados!";
        $erro = true;
    }

    if (isset($_POST['titulo_banner']) && $_POST['titulo_banner'] != $row['Titulo_banner']) {
        $titulo = $_POST['titulo_banner'];
        $stmt = $conn->prepare("UPDATE configuracoes_site SET Titulo_banner = ? WHERE Id_configuracao = ?");
        $stmt->bind_param("si", $titulo, $id_config);
        if ($stmt->execute()) {
            $alteracaoFeita = true;
        } else {
            $textoErro .= "Erro ao atualizar Título do Banner. ";
            $erro = true;
        }
    }

    // Subtítulo do banner
    if (isset($_POST['subtitulo_banner']) && $_POST['subtitulo_banner'] != $row['Subtitulo_banner']) {
        $subtitulo = $_POST['subtitulo_banner'];
        $stmt = $conn->prepare("UPDATE configuracoes_site SET Subtitulo_banner = ? WHERE Id_configuracao = ?");
        $stmt->bind_param("si", $subtitulo, $id_config);
        if ($stmt->execute()) {
            $alteracaoFeita = true;
        } else {
            $textoErro .= "Erro ao atualizar Subtítulo do Banner. ";
            $erro = true;
        }
    }

    // Cookie status
    if (isset($_POST['cookie_status']) && $_POST['cookie_status'] != $row['Cookies_status']) {
        $cookieStatus = $_POST['cookie_status'];
        $stmt = $conn->prepare("UPDATE configuracoes_site SET Cookies_status = ? WHERE Id_configuracao = ?");
        $stmt->bind_param("si", $cookieStatus, $id_config);
        if ($stmt->execute()) {
            $alteracaoFeita = true;
        } else {
            $textoErro .= "Erro ao atualizar Cookie Status. ";
            $erro = true;
        }
    }

    // Cookie note
    if (isset($_POST['cookie_note']) && $_POST['cookie_note'] != $row['cookie_note']) {
        $cookieNote = $_POST['cookie_note'];
        $stmt = $conn->prepare("UPDATE configuracoes_site SET cookie_note = ? WHERE Id_configuracao = ?");
        $stmt->bind_param("si", $cookieNote, $id_config);
        if ($stmt->execute()) {
            $alteracaoFeita = true;
        } else {
            $textoErro .= "Erro ao atualizar Cookie Note. ";
            $erro = true;
        }
    }

    // Facebook
    if (isset($_POST['facebook_link']) && $_POST['facebook_link'] != $row['Facebook']) {
        $facebook = $_POST['facebook_link'];
        $stmt = $conn->prepare("UPDATE configuracoes_site SET Facebook = ? WHERE Id_configuracao = ?");
        $stmt->bind_param("si", $facebook, $id_config);
        if ($stmt->execute()) {
            $alteracaoFeita = true;
        } else {
            $textoErro .= "Erro ao atualizar Facebook. ";
            $erro = true;
        }
    }

    // Linkedin
    if (isset($_POST['linkedin_link']) && $_POST['linkedin_link'] != $row['Linkedin']) {
        $linkedin = $_POST['linkedin_link'];
        $stmt = $conn->prepare("UPDATE configuracoes_site SET Linkedin = ? WHERE Id_configuracao = ?");
        $stmt->bind_param("si", $linkedin, $id_config);
        if ($stmt->execute()) {
            $alteracaoFeita = true;
        } else {
            $textoErro .= "Erro ao atualizar Linkedin. ";
            $erro = true;
        }
    }

    // Política de cookies
    if (isset($_POST['politicaCookies']) && $_POST['politicaCookies'] != $row['politica_cookies']) {
        $politica = $_POST['politicaCookies'];
        $stmt = $conn->prepare("UPDATE configuracoes_site SET politica_cookies = ? WHERE Id_configuracao = ?");
        $stmt->bind_param("si", $politica, $id_config);
        if ($stmt->execute()) {
            $alteracaoFeita = true;
        } else {
            $textoErro .= "Erro ao atualizar Política de Cookies. ";
            $erro = true;
        }
    }

    $id_utilizador = $_SESSION['utilizadorOn']['Id_user']; 
    $data = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("UPDATE configuracoes_site SET Id_utilizador_Ultimo_update = ?, data_update = ? WHERE Id_configuracao = ?");
    $stmt->bind_param("isi", $id_utilizador, $data, $id_config);
    $stmt->execute();

    
} else {
    caminho();
}

if (!$erro && $alteracaoFeita) {


    mostrarPopUp("Configurações atualizadas com sucesso!");
    criarLogs("Configurações alteradas",$_SESSION['utilizadorOn']['Id_user']);
} else if ($erro) {
    mostrarPopUp($textoErro);
    criarLogs("Erro",$_SESSION['utilizadorOn']['Id_user'],null,null,$novoId,$textoErro,__FILE__);
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
