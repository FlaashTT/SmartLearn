<?php

include("../../../database/basedados.sql");
include("inserirImagemCat.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = false;

    if (!isset($_POST['nome_categoria']) || empty(trim($_POST['nome_categoria']))) {
        echo "<script>alert('Nome da categoria é obrigatório!');</script>";
        $erro = true;
    }

    $nome_categoria = $_POST['nome_categoria'];

    // Verifica se a categoria já existe
    $query = $conn->prepare("SELECT * FROM categoria WHERE Nome_cat = ?");
    $query->bind_param("s", $nome_categoria);
    $query->execute();
    $resultado = $query->get_result();
    if ($resultado->num_rows > 0) {
        echo "<script>alert('Categoria com esse nome já existe!');</script>";
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

                // verificar se já existe imagem na base de dados
                if (empty($row['URL_imagem_perfilUser'])) {
                    inserirImagem($conn, $novoId);
                    echo "<script>window.location.href = '../categoria_cursos.php';</script>";
                } else {

                    $file = "../../../assets/image/miniatura_cat/" . $novoId;

                    if (file_exists($file)) {

                        if (unlink($file)) {
                            echo "<script>alert('Imagem antiga removida com sucesso.');</script>";
                            inserirImagem($conn, $novoId);
                            echo "<script>window.location.href = '../categoria_cursos.php';</script>";
                        } else {
                            echo "<script>alert('Erro ao remover a imagem antiga!');</script>";
                        }
                    } else {
                        echo "<script>alert('Imagem antiga não encontrada.');</script>";
                        $erro = true;
                    }
                }

                $alteracaoFeita = true;
            } else {
                echo "<script>alert('Nenhuma imagem enviada pelo formulário!');</script>";
            }
        } else {
            echo "<script>alert('Erro ao criar categoria.');</script>";
            $erro = true;
        }

        $stmt->close();
    }

    if ($erro) {
        echo "<script>window.location.href = '../categoria_cursos.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Requisição inválida!'); window.location.href = '../categoria_cursos.php';</script>";
    exit;
}



