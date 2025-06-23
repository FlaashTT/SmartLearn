<?php
include("../../../database/basedados.php");
include("../../popup.php");
include("../../logs.php");
$erro = false;
$textoErro = "";
$idUser = "";
$idCurso = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['IdRemover']) || empty($_POST['IdRemover'])) {
        $textoErro = "Erro na coleta do ID da categoria!";
        $erro = true;
    }


    $idParaRemover = $_POST['IdRemover'];

    $select = "SELECT Id_user, Id_curso FROM curso_adquiridos WHERE Id_adquirido = ?";
    $selectQuerry = $conn->prepare($select);
    $selectQuerry->bind_param("i", $idParaRemover);

    if ($selectQuerry->execute()) {
        $selectQuerry->bind_result($id_user, $id_curso); // <- Aqui capturamos os dois valores
        if ($selectQuerry->fetch()) {
            $idUser = $id_user;
            $idCurso = $id_curso;
            // Agora você pode usar $idUser e $idCurso
        } else {
            $textoErro = "Nenhum resultado encontrado.";
            $erro = true;
        }
    } else {
        $textoErro = "Erro na execução da query: " . $selectQuerry->error;
        $erro = true;
    }

    //fazer delete da base de dados
    $query = "DELETE FROM cursos_adquiridos WHERE Id_adquirido = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idParaRemover);
    if ($stmt->execute()) {
        criarLogs("", $_SESSION['utilizadorOn']['Id_user'], null, $idCurso, null, null, null, $idUser);
        mostrarPopUp("Utilizador removido do curso com sucesso!");
    } else {
        $textoErro = "Erro ao remover o utilizador do curso!";
        $erro = true;
    }
} else {
    caminho();
}



if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, null, null, $textoErro, __FILE__);
    mostrarPopUp($textoErro);
}
function caminho()
{
    echo '
    <script>
        window.location.href = "../registar_historico.php";
    </script>
    ';
    exit;
}
