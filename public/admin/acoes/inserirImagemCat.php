<?php
include("../../popup.php");
include("../../logs.php");
$textoErro = "";
$erro = false;
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403); // Código de status HTTP 403 (Proibido)
    echo "<script>
        window.location.href = '../categoria_cursos.php'; // Volta para a página anterior
    </script>";
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
                $textoErro = "Erro ao atualizar o banco de dados!";
                $erro = true;
            }
        } else {
            $textoErro = "Erro ao mover a imagem!";
            $erro = true;
        }
    } else {
        $textoErro = "Formato de imagem inválido. Apenas JPG, JPEG e PNG são permitidos.";
        $erro = true;
    }
    if ($erro) {
        mostrarPopUp($textoErro);
    }
}
