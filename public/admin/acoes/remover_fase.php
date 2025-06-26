<?php
include("../../../database/basedados.php");
session_start();
require_once("../../popup.php");
require_once("../../logs.php");
$erro = false;
$textoErro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Id_curso']) && isset($_POST['Id_fase'])) {
        $idCurso = $_POST['Id_curso'];
        $idfase = $_POST['Id_fase'];


        if (isset($_POST['NomeImagem']) && $_POST['NomeImagem'] !== '') {
            $caminhoDoArquivo = '../../../assets/conteudosCursos/imagens/' . $_POST['NomeImagem'];
            if (file_exists($caminhoDoArquivo)) {
                if (unlink($caminhoDoArquivo)) {
                } else {
                    $textoErro = "Erro ao remover o arquivo.";
                    $erro = true;
                }
            } else {
                $textoErro = "O arquivo não existe.";
                $erro = true;
            }
        }

        if (isset($_POST['NomeVideo']) && $_POST['NomeVideo'] !== '') {
            $caminhoDoArquivo = '../../../assets/conteudosCursos/videos/' . $_POST['NomeVideo'];
            if (file_exists($caminhoDoArquivo)) {
                if (unlink($caminhoDoArquivo)) {
                } else {
                    $textoErro = "Erro ao remover o arquivo.";
                    $erro = true;
                }
            } else {
                $textoErro = "O arquivo não existe.";
                $erro = true;
            }
        }

        $sqlEliminarFase = "DELETE FROM fase WHERE Id_curso = ? AND Num_fase = ?";
        $stmt = $conn->prepare($sqlEliminarFase);
        $stmt->bind_param("ii", $idCurso, $idfase);
        if ($stmt->execute()) {
            mostrarPopUp("Fase removida com sucesso!",null,"../adicionar_conteudo.php");
            criarLogs("Fase removida", $_SESSION['utilizadorOn']['Id_user'], null, $idCurso);
        } else {
            $textoErro = "Erro ao remover a fase. Tente novamente.";
            $erro = true;
        }
    } else {
        $textoErro = "Campos obrigatórios não enviados.";
        $erro = true;
    }
} else {
    caminho();
}

if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, $idCurso, null, $textoErro, __FILE__);
    mostrarPopUp($textoErro);
    exit;
}
function caminho()
{
    echo '<script>
        // Redirecionar para a página anterior
    window.location.href = document.referrer;
    </script>
    ';
    exit;
}
