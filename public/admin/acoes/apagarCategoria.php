<?php

include("../../../database/basedados.php");

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
    } else {
        $textoErro = "Erro ao coletar a imagem da categoria!";
        $erro = true;
    }


    $imagem = "../../../assets/image/miniatura_cat/" . $urlMiniaturaAntiga;
    if (!empty($urlMiniaturaAntiga)) {
        if (file_exists($imagem)) {
            if (!unlink($imagem)) {
                $textoErro = "Erro ao remover a imagem da categoria!";
                $erro = true;
            }
        }
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

            echo "<script>alert('Categoria eliminada com sucesso!');</script>";
            caminho();
        } else {
            $textoErro = "Erro ao eliminar categoria!";
            $erro = true;
        }
    }
} else {
    echo "<script>alert('Método de requisição inválido!');</script>";
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
