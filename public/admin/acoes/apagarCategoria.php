<?php
session_start();
include("../../../database/basedados.php");

require_once("../../popup.php");
require_once("../../logs.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = false;
    $textoErro = "";

    if (!isset($_POST['idCategoria']) || empty($_POST['idCategoria'])) {
        $textoErro = "ID da categoria é obrigatório!";
        $erro = true;
    }

    $id_categoria = $_POST['idCategoria'];
    $stmt = $conn->prepare("SELECT Miniatura_cat FROM categoria WHERE Id_categoria = ?");
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $urlMiniaturaAntiga = $row['Miniatura_cat'];
        $imagem = "../../../assets/image/miniatura_cat/" . $urlMiniaturaAntiga;

        if (!empty($urlMiniaturaAntiga)) {
            if (file_exists($imagem)) {
                if (!unlink($imagem)) {
                    echo "<script>alert('Erro ao eliminar a imagem antiga!');</script>";
                }
            } else {
                echo "<script>alert('Imagem não encontrada no servidor.');</script>";
            }
        }
    } else {
        $textoErro = "Erro ao coletar a imagem da categoria!";
        $erro = true;
    }
    //remover a categoria dos cursos associado ha mesma
    $sql = "UPDATE curso SET Id_categoria = Null WHERE Id_categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_categoria);

    if ($stmt->execute()) {
        //eliminar a categoria
        $sql = "DELETE FROM categoria WHERE Id_categoria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            criarLogs("Categoria eliminada", $_SESSION['utilizadorOn']['Id_user']);
            mostrarPopUp('Categoria eliminada com sucesso!');
        } else {
            $textoErro = "Erro ao eliminar categoria!";
            $erro = true;
        }
    }
} else {
    caminho();
}

if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, null, $novoId, $textoErro, __FILE__);
    mostrarPopUp($textoErro);

    exit;
}

function caminho()
{
    echo "<script>window.location.href = '../categoria_cursos.php';</script>";
    exit;
}
