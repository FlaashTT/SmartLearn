<?php
include("../../../database/basedados.php");
include("../../popup.php");
include("../../logs.php");
$erro = false;
$textoErro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['midia']) && isset($_POST['fase']) && isset($_POST['idCurso']) && isset($_POST['Nome'])) {
        $midia = $_POST['midia'];
        $fase = $_POST['fase'];
        $idCurso = $_POST['idCurso'];
        $nome = $_POST['Nome'];

        if ($midia !== "videos" && $midia !== "imagens") {
            $textoErro = "Tipo de mídia inválido.";
            $erro = true;
            exit;
        }
    } else {
        $textoErro = "Alguns campos obrigatórios não foram enviados.";
        $erro = true;
        exit;
    }

    $caminhoDoArquivo = '../../../assets/conteudosCursos/' . $midia . '/' . $nome;
    //remover midia das pastas
    if (file_exists($caminhoDoArquivo)) {
        if (unlink($caminhoDoArquivo)) {

            $query = '';
            if ($midia === "videos") {
                $query = "UPDATE fase SET video = '' WHERE video = ? AND Num_fase = ? AND Id_curso = ?";
            }
            if ($midia === "imagens") {
                $query = "UPDATE fase SET imagem = '' WHERE imagem = ? AND Num_fase = ? AND Id_curso = ?";
            }
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sii", $nome, $fase, $idCurso);
            if ($stmt->execute()) {
                criarLogs("Conteudo curso alterado", $_SESSION['utilizadorOn']['Id_user'], null, $idCurso);
                mostrarPopUp("Mídia removida com sucesso!");
                
            } else {
                $textoErro = "Erro ao remover o arquivo da base de dados.";
                $erro = true;
            }
        } else {
            $textoErro = "Erro ao remover o arquivo.";
            $erro = true;
        }
    } else {
        $textoErro = "O arquivo não existe.";
        $erro = true;
    }
} else {
    caminho();
    exit;
}



if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'],  null,  null,  null, $textoErro ,__FILE__);
    mostrarPopUp($textoErro);
}
function caminho()
{
    echo '<script>
        // Redirecionar para a página anterior
    window.location.href = document.referrer;
    </script>
    ';
}
