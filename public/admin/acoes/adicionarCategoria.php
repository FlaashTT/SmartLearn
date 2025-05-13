<?php

include("../../../database/basedados.sql");

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
                } else {

                    $file = "../../../assets/image/miniatura_cat/" . $novoId;

                    if (file_exists($file)) {

                        if (unlink($file)) {
                            echo "<script>alert('Imagem antiga removida com sucesso.');</script>";
                            inserirImagem($conn, $novoId);
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

function inserirImagem($conn, $idCategoria)
{
    

    $extensao = strtolower(pathinfo($_FILES["url_imagem"]["name"], PATHINFO_EXTENSION));
    $extensoes_permitidas = ['jpg', 'jpeg', 'png'];
    $tipo_mime = mime_content_type($_FILES["url_imagem"]["tmp_name"]);
    $mimes_permitidos = ['image/jpeg', 'image/png'];

    if (in_array($extensao, $extensoes_permitidas) && in_array($tipo_mime, $mimes_permitidos)) {
       

        $diretorio = "../../../assets/image/miniatura_cat/";
        $base_nome = "miniatura_cat" . $idCategoria;
        $novo_nome = $base_nome . "." . $extensao;
        $destino = $diretorio . $novo_nome;

        foreach (['jpg', 'jpeg', 'png'] as $ext) {
            $possivel_arquivo = $diretorio . $base_nome . '.' . $ext;
            if (file_exists($possivel_arquivo)) {
                unlink($possivel_arquivo);
            }
        }

        if (move_uploaded_file($_FILES["url_imagem"]["tmp_name"], $destino)) {
            

            $URL_foto = $novo_nome;
            $sql = "UPDATE categoria SET Miniatura_cat = ? WHERE Id_categoria = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $URL_foto, $idCategoria);

            if ($stmt->execute()) {
                $stmt->close();
            } else {
                echo "<script>alert('Erro ao atualizar o banco de dados!');</script>";
            }
        } else {
            echo "<script>alert('Erro ao mover a imagem!');</script>";
        }
    } else {
        echo "<script>alert('Formato de imagem inválido. Apenas JPG, JPEG e PNG são permitidos.');</script>";
    }
}

