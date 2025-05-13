<?php

include("../../../database/basedados.sql");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = false;
    $textoErro = "";

    if (!isset($_POST['idCategoria']) || empty($_POST['idCategoria'])) {
        $textoErro = "ID da categoria é obrigatório!";
        $erro = true;
    }

    $id_categoria = $_POST['idCategoria'];

    //remover a categoria dos cursos associado ha mesma
    $sql = "UPDATE curso SET Id_categoria = '' WHERE Id_categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_categoria);

    if ($stmt->execute()) {


        //eliminar a categoria
        $sql = "DELETE FROM categoria WHERE Id_categoria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {

            echo "<script>alert('Categoria eliminada com sucesso!');</script>";
            caminho();
        } else {
            $textoErro = "Erro ao eliminar categoria!";
            $erro = true;
        }
    }
}

if ($erro) {
    caminho();
    echo "<script>alert('" . $textoErro . "');</script>";
    exit;
}

function caminho()
{
    echo "<script>window.location.href = '../categoria_cursos.php';</script>";
    exit;
}
