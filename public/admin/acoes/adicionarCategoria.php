<?php

include("../../../database/basedados.php");
include("inserirImagemCat.php");
require_once("../../popup.php");
require_once("../../logs.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = false;
    $textoErro = "";

    if (!isset($_POST['nome_categoria']) || empty(trim($_POST['nome_categoria']))) {
        $textoErro = 'Nome da categoria é obrigatório!';
        $erro = true;
    }

    $nome_categoria = $_POST['nome_categoria'];

    // Verifica se a categoria já existe
    $query = $conn->prepare("SELECT * FROM categoria WHERE Nome_cat = ?");
    $query->bind_param("s", $nome_categoria);
    $query->execute();
    $resultado = $query->get_result();
    if ($resultado->num_rows > 0) {
        $textoErro = 'Categoria com esse nome já existe!';
        $erro = true;
    }
    $query->close();

    if (!$erro) {
        $stmt = $conn->prepare("INSERT INTO categoria (Nome_cat) VALUES (?)");
        $stmt->bind_param("s", $nome_categoria);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $novoId = $conn->insert_id;
            // Se foi enviada uma imagem válida
            if (!empty($_FILES['url_imagem']['name'])) {



                inserirImagem($conn, $novoId);
            } else {
                caminho();
            }
        } else {
            $textoErro = 'Erro ao criar categoria.';
            $erro = true;
        }

        $stmt->close();
    }

    if ($erro) {
        criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, null, $novoId, $textoErro, __FILE__);
        mostrarPopUp($textoErro);
    } else {
        mostrarPopUp("Categoria adicionada com sucesso!");
        criarLogs("Nova categoria", $_SESSION['utilizadorOn']['Id_user'], null, null, $novoId);
    }
} else {
    caminho();
}

function caminho()
{
    echo "<script>window.location.href = '../categoria_cursos.php';</script>";
    exit;
}
