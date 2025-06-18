<?php
include("../../database/basedados.php");
include("../popup.php");
include("../logs.php");
$textoErro = "";
$erro = false;
$idcurso = "";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!isset($_POST['cursoAtual']) && $_POST['cursoAtual'] === null) {
        $textoErro = "Erro na coleta do id do curso";
        $erro = true;
        exit;
    }
    $progresso = "Concluido";
    $percentagem = 100;
    $idcurso = $_POST['cursoAtual'];
    //por codigo que faz update na bd para colocar como 100% e concluido o curso
    $stmt = $conn->prepare("UPDATE cursos_adquiridos SET Progresso = ?, Percentagem_progresso = ? WHERE Id_user = ? AND Id_curso = ?");
    $stmt->bind_param("siii", $progresso, $percentagem, $_SESSION['utilizadorOn']['Id_user'], $idcurso);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        mostrarPopUp("Parabens por concluir o curso com sucesso!", true, "../perfil/perfil_cursos.php");
    } else {
        $textoErro = "Erro ao realizar o update,tente mais tarde";
        $erro = true;
    }
} else {
    echo "<script>window.location.href ='../perfil/perfil_cursos.php';</script>";
}
if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'],  null,  $idcurso,  null, $textoErro, __FILE__);
    mostrarPopUp($textoErro, true, "../perfil/perfil_cursos.php");
}
