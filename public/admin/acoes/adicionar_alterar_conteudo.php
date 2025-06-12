<?php

include("../../../database/basedados.php");
include("../../popup.php");
$alteracaoFeita = false;
$erro = false;
$textoErro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['input-curso-id']) || $_POST['input-curso-id'] === '' || $_POST['input-curso-id'] === null) {
        $textoErro = "Ocorreu um erro tente novamente ou entre em contacto com o suporte";
        $erro = true;
        exit;
    }
    $idcursoAtual = $_POST['input-curso-id'];
    $query = "SELECT * FROM curso WHERE Id_curso = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idcursoAtual);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        $textoErro = "Erro ao coletar informaçoes do curso!";
        $erro = true;
    }

    $titulos = $_POST['titulo'] ?? [];
    $conteudos = $_POST['conteudo'] ?? [];
    $fases = $_POST['fase'] ?? [];
    $videos = $_FILES['video']['name'] ?? [];
    $imagens = $_FILES['imagem']['name'] ?? [];

    $totalFases = count($fases); // Todas arrays devem ter o mesmo length

    for ($i = 0; $i < $totalFases; $i++) {
        echo "<h3>Fase " . htmlspecialchars($fases[$i]) . "</h3>";

        echo "Título: " . htmlspecialchars($titulos[$i] ?? '') . "<br>";
        echo "Conteúdo: " . nl2br(htmlspecialchars($conteudos[$i] ?? '')) . "<br>";

        if (!empty($videos[$i])) {
            echo "Vídeo: " . htmlspecialchars($videos[$i]) . "<br>";
        } else {
            echo "Vídeo: Nenhum vídeo enviado<br>";
        }

        if (!empty($imagens[$i])) {
            echo "Imagem: " . htmlspecialchars($imagens[$i]) . "<br>";
        } else {
            echo "Imagem: Nenhuma imagem enviada<br>";
        }
        echo "<hr>";
    }

    /*
    if (isset($_FILES['video']['name']) && !empty($_FILES['video']['name'])) {
        // verificar se já existe imagem na base de dados
        if (empty($row['Miniatura_cat'])) {
            $extensao = strtolower(pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION));
            $extensoes_permitidas = ['jpg', 'jpeg', 'png'];
            $tipo_mime = mime_content_type($_FILES["video"]["tmp_name"]);
            $mimes_permitidos = [
                'video/mp4',
                'video/quicktime',
                'video/x-msvideo',
                'video/x-matroska'
            ];

            if (in_array($extensao, $extensoes_permitidas) && in_array($tipo_mime, $mimes_permitidos)) {


                $diretorio = "../../../assets/video/conteudosCursos/";
                $base_nome = "video_" . $idcursoAtual;
                $novo_nome = $base_nome . "." . $extensao;
                $destino = $diretorio . $novo_nome;

                foreach (['mp4', 'mov', 'avi', 'mkv'] as $ext) {
                    $possivel_arquivo = $diretorio . $base_nome . '.' . $ext;
                    if (file_exists($possivel_arquivo)) {
                        unlink($possivel_arquivo);
                    }
                }

                if (move_uploaded_file($_FILES["video"]["tmp_name"], $destino)) {


                    $URL_foto = $novo_nome;
                    $sql = "UPDATE fase SET Miniatura_cat = ? WHERE Id_categoria = ?";
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
            $alteracaoFeita = true;
        } else {

            $file = "../../../assets/image/miniatura_cat/" . $row['Miniatura_cat'];

            if (file_exists($file)) {

                if (unlink($file)) {
                    echo "<script>alert('Imagem antiga removida com sucesso.');</script>";
                    $extensao = strtolower(pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION));
                    $extensoes_permitidas = ['jpg', 'jpeg', 'png'];
                    $tipo_mime = mime_content_type($_FILES["video"]["tmp_name"]);
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

                        if (move_uploaded_file($_FILES["video"]["tmp_name"], $destino)) {


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
                    $alteracaoFeita = true;
                } else {
                    echo "<script>alert('Erro ao remover a imagem antiga!');</script>";
                }
            } else {
                $textoErro = "Imagem antiga não encontrada.";
                $erro = true;
            }
        }

        $alteracaoFeita = true;
    }


    if (isset($_FILES['imagem']['name']) && !empty($_FILES['imagem']['name'])) {
        // verificar se já existe imagem na base de dados
        if (empty($row['Miniatura_cat'])) {
            inserirImagem($conn, $idCategoria);
            $alteracaoFeita = true;
        } else {

            $file = "../../../assets/image/miniatura_cat/" . $row['Miniatura_cat'];

            if (file_exists($file)) {

                if (unlink($file)) {
                    echo "<script>alert('Imagem antiga removida com sucesso.');</script>";
                    inserirImagem($conn, $idCategoria);
                    $alteracaoFeita = true;
                } else {
                    echo "<script>alert('Erro ao remover a imagem antiga!');</script>";
                }
            } else {
                $textoErro = "Imagem antiga não encontrada.";
                $erro = true;
            }
        }

        $alteracaoFeita = true;
    }*/
} else {
    caminho();
}


if (!$erro && $alteracaoFeita) {
    echo "Alteração feita com sucesso!";
} elseif (!$alteracaoFeita) {
    echo "Nenhuma alteração foi feita!";
}

if ($erro) {
    echo $textoErro;
    mostrarPopUp($textoErro);
}
function caminho()
{
    echo '<script>
        // Redirecionar para a página anterior
    window.location.href = document.referrer;
    </script>
    ';
}
