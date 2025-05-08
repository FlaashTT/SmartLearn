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
            if (!empty($_FILES['miniatura_cat']['tmp_name'])) {
                inserirImagem($conn, $novoId);
            }

        } else {
            echo "<script>alert('Erro ao criar categoria.');</script>";
            $erro = true;
        }

        $stmt->close();
    }

    if (!$erro) {
        echo "<script>window.location.href = '../categoria_cursos.php';</script>";
        exit;
    }

} else {
    echo "<script>alert('Requisição inválida!'); window.location.href = '../categoria_cursos.php';</script>";
    exit;
}

function inserirImagem($conn, $novoId)
{
    $extensao = strtolower(pathinfo($_FILES["miniatura_cat"]["name"], PATHINFO_EXTENSION));

    $extensoes_permitidas = ['jpg', 'jpeg', 'png'];
    $tipo_mime = mime_content_type($_FILES["miniatura_cat"]["tmp_name"]);
    $mimes_permitidos = ['image/jpeg', 'image/png'];

    if (in_array($extensao, $extensoes_permitidas) && in_array($tipo_mime, $mimes_permitidos)) {

        $diretorio = "../../assets/image/miniatura_cat/";
        $base_nome = "miniatura_" . $novoId;
        $novo_nome = $base_nome . "." . $extensao;
        $destino = $diretorio . $novo_nome;

        // Apagar versões anteriores com outras extensões
        foreach (['jpg', 'jpeg', 'png'] as $ext) {
            $possivel_arquivo = $diretorio . $base_nome . '.' . $ext;
            if (file_exists($possivel_arquivo)) {
                unlink($possivel_arquivo);
            }
        }
        echo"<script>console.log(".$novo_nome.");</script>";
        if (move_uploaded_file($_FILES["miniatura_cat"]["tmp_name"], $destino)) {
            // Atualizar o caminho da imagem na tabela categoria
            $sql = "UPDATE categoria SET Imagem_cat = ? WHERE Id_cat = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $novo_nome, $novoId);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "<script>alert('Erro ao mover a imagem!');</script>";
        }
    } else {
        echo "<script>alert('Formato de imagem inválido. Apenas JPG, JPEG e PNG são permitidos.');</script>";
    }
}
