<?php
session_start();
include("../../../database/basedados.php");
require_once("../../popup.php");
require_once("../../logs.php");
$erro = false;
$textErro = "";

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
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
        }

        $stmt->close();
    }
} else {
    echo "<script>window.location.href = document.referrer;</script>";
}

if ($erro) {
    mostrarPopUp($textErro);
}
