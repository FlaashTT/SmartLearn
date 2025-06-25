<?php
include("../../../database/basedados.php");
session_start();
require_once("../../popup.php");
require_once("../../logs.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = false;
    $emailUtilizador = $_POST['utilizador'];
    $nomeCurso = $_POST['curso'];
    $cursoId = $_POST['curso_id'];
    $idUtilizador = $_POST['utilizador_id'];


    echo "<script>
    if (!confirm('Tem a certeza que deseja matricular o utilizador $emailUtilizador no curso $nomeCurso?')) {
        window.location.href = document.referrer;
    }
    </script>";



    $sql = "SELECT * FROM cursos_adquiridos WHERE Id_user = ? AND Id_curso = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUtilizador, $cursoId);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
        // O utilizador já está matriculado no curso
        $textoErro = "O utilizador $emailUtilizador já está matriculado no curso $nomeCurso.";
        $erro = true;
    }

    if (!$erro) {
        $sqlInsert = "INSERT INTO cursos_adquiridos (Id_user, Id_curso, Data_compra, Progresso, AdicionadoPor) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $dataCompra = date('Y-m-d H:i:s');
        $progresso = 'Por Iniciar';

        $stmtInsert->bind_param("iissi", $idUtilizador, $cursoId, $dataCompra, $progresso, $_SESSION['utilizadorOn']['Id_user']);

        if (!$stmtInsert->execute()) {
            $textoErro = "Erro ao matricular o utilizador no curso: " . $stmtInsert->error;
            $erro = true;
        }
    }
}
if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, null, $novoId, $textoErro, __FILE__);
    mostrarPopUp($textoErro);

    exit();
} else {
    criarLogs("Utilizador Matriculado", $_SESSION['utilizadorOn']['Id_user'], null, $cursoId, null, null, null, $idUtilizador);
    mostrarPopUp("Inscreveu " . $emailUtilizador . " no curso " . $nomeCurso);

    exit();
}
