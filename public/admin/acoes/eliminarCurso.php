<?php
session_start();
include("../../../database/basedados.php");
require_once("../../popup.php");
require_once("../../logs.php");
$erro = false;
$textErro = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!isset($_POST["Id_curso"]) || $_POST['Id_curso'] === "") {
        $textErro = "Erro ao coletar o Id do curso a eliminar";
        $erro = true;
    } else {
        $Id_curso = $_POST['Id_curso'];
        $estado = "Eliminado";

        $stmt = $conn->prepare("UPDATE curso SET Estado_curso = ? WHERE Id_curso = ?");
        $stmt->bind_param("si", $estado, $Id_curso);

        if (!$stmt->execute()) {
            $erro = true;
            $textErro = "Erro ao executar o UPDATE.";
        }else{
            criarLogs("Curso eliminado",$_SESSION['utilizadorOn']['Id_user'],null,$Id_curso);
            mostrarPopUp("Curso eliminado com sucesso!",null,"../dashboard_cursos.php");
        }

        $stmt->close();
    }
} else {
    echo "<script>window.location.href = document.referrer;</script>";
}

if ($erro) {
    criarLogs("Erro",$_SESSION['utilizadorOn']['Id_user'],null,$Id_curso,null,$textErro,__FILE__);
    mostrarPopUp($textErro);
}
