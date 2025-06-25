<?php
session_start();
include("../../../database/basedados.php");
require_once("../../logs.php");
require_once("../../popup.php");

$erro = false;
$textoErro = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Validação simples para evitar undefined index
    $idCurso = isset($_POST['Id_curso']) ? intval($_POST['Id_curso']) : 0;
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $estado = isset($_POST['estadoCurso']) ? $_POST['estadoCurso'] : '';
    $idioma = isset($_POST['IdiomaCurso']) ? intval($_POST['IdiomaCurso']) : 0;
    $dificuldade = isset($_POST['dificuldade']) ? $_POST['dificuldade'] : '';
    $tempo = isset($_POST['tempo']) ? $_POST['tempo'] : '';
    $requisitos = isset($_POST['requisitos']) ? $_POST['requisitos'] : '';
    $preco = isset($_POST['preco']) ? $_POST['preco'] : '';
    $Provedor = isset($_POST['Provedor']) ? $_POST['Provedor'] : '';
    $LinkProvedor = isset($_POST['LinkProvedor']) ? $_POST['LinkProvedor'] : '';


    $sql = "UPDATE curso SET 
    Nome_curso = ?,
    Id_categoria = ?,
    Id_idioma = ?,
    Nome_curso = ?, 
    Descricao = ?, 
    Preco = ?, 
    Estado_curso = ?, 
    Tempo_estimado = ?, 
    Dificuldade = ?, 
    Requisitos = ?, 
    Provedor_geral_curso = ?, 
    URL_geral_curso = ?
WHERE Id_curso = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param(
            "siisssssssssi",
            $titulo,
            $categoria,
            $idioma,
            $titulo,
            $descricao,
            $preco,
            $estado,
            $tempo,
            $dificuldade,
            $requisitos,
            $Provedor,
            $LinkProvedor,
            $idCurso
        );

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                criarLogs("Alteração de curso", $_SESSION['utilizadorOn']['Id_user'], null, $idCurso);
                mostrarPopUp("Alteraçoes realizadas com sucesso", null, "../dashboard_cursos.php");
            } else {
                $textoErro = "Nenhuma alteração feita ou ID não encontrado.";
                $erro = true;
            }
        } else {
            $textoErro = "Erro ao executar o update: " . $stmt->error;
            $erro = true;
        }

        $stmt->close();
    } else {
        $textoErro = "Erro ao preparar o statement: " . $conn->error;
        $erro = true;
    }
} else {
    echo "<script>window.location.href = document.referrer;</script>";
    exit;
}

if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, $idCurso, null, $textoErro, __FILE__);
    mostrarPopUp($textoErro, null, "../dashboard_cursos.php");
}
