<?php


include("../../../database/basedados.php");
session_start();
require_once("../../popup.php");
require_once("../../logs.php");
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
        $textoErro = "Erro ao coletar informações do curso!";
        $erro = true;
    }

    $titulos = $_POST['titulo'] ?? [];
    $conteudos = $_POST['conteudo'] ?? [];
    $fases = $_POST['fase'] ?? [];
    $videos = $_FILES['video']['name'] ?? [];
    $imagens = $_FILES['imagem']['name'] ?? [];

    $totalFases = count($fases);

    for ($i = 0; $i < $totalFases; $i++) {
        $NumFase = $fases[$i];

        $novoNomeImagem = "";
        $novoNomeVideo = "";

        $sqlverifica = "SELECT COUNT(*) as total FROM fase WHERE Id_curso = ? AND Num_fase = ?";
        $stmtVerifica = $conn->prepare($sqlverifica);
        $stmtVerifica->bind_param("ii", $idcursoAtual, $NumFase);
        $stmtVerifica->execute();
        $resultado = $stmtVerifica->get_result();
        $row = $resultado->fetch_assoc();
        $quantidade = $row['total'];

        if ($quantidade > 0) {
            // Atualizar fase existente

            if (!empty($videos[$i])) {
                $novoNomeVideo = processarVideo($conn, $idcursoAtual, $i);
                if ($novoNomeVideo !== false) {
                    $alteracaoFeita = true;
                    $update = "UPDATE fase SET video = ? WHERE Id_curso = ? AND Num_fase = ?";
                    $stmt = $conn->prepare($update);
                    $stmt->bind_param("sii", $novoNomeVideo, $idcursoAtual, $NumFase);
                    $stmt->execute();
                } else {
                    $textoErro = "ERRO ao atualizar o vídeo, tente mais tarde!";
                    $erro = true;
                }
            }

            if (!empty($imagens[$i])) {
                $novoNomeImagem = processarImagem($conn, $idcursoAtual, $i);
                if ($novoNomeImagem !== false) {
                    $alteracaoFeita = true;
                    $update = "UPDATE fase SET Imagem = ? WHERE Id_curso = ? AND Num_fase = ?";
                    $stmt = $conn->prepare($update);
                    $stmt->bind_param("sii", $novoNomeImagem, $idcursoAtual, $NumFase);
                    $stmt->execute();
                } else {
                    $textoErro = "ERRO ao atualizar a imagem, tente mais tarde!";
                    $erro = true;
                }
            }

            if (!empty($titulos[$i])) {
                $update = "UPDATE fase SET Titulo_fase = ? WHERE Id_curso = ? AND Num_fase = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("sii", $titulos[$i], $idcursoAtual, $NumFase);
                if ($stmt->execute()) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "Erro ao atualizar título: " . $stmt->error;
                    $erro = true;
                }
            }

            if (!empty($conteudos[$i])) {
                $update = "UPDATE fase SET Conteudo_fase = ? WHERE Id_curso = ? AND Num_fase = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("sii", $conteudos[$i], $idcursoAtual, $NumFase);
                if ($stmt->execute()) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "Erro ao atualizar conteúdo: " . $stmt->error;
                    $erro = true;
                }
            }
        } else {
            // Inserir nova fase

            if (!empty($videos[$i])) {
                $novoNomeVideo = processarVideo($conn, $idcursoAtual, $i);
                if ($novoNomeVideo === false) {
                    $textoErro = "ERRO ao fazer upload do vídeo, tente mais tarde!";
                    $erro = true;
                }
            }

            if (!empty($imagens[$i])) {
                $novoNomeImagem = processarImagem($conn, $idcursoAtual, $i);
                if ($novoNomeImagem === false) {
                    $textoErro = "ERRO ao fazer upload da imagem, tente mais tarde!";
                    $erro = true;
                }
            }

            $insert = "INSERT INTO fase (Id_curso, Num_fase, Titulo_fase, Conteudo_fase, Imagem, video) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert);
            $stmt->bind_param("iissss", $idcursoAtual, $NumFase, $titulos[$i], $conteudos[$i], $novoNomeImagem, $novoNomeVideo);

            if ($stmt->execute()) {
                $alteracaoFeita = true;
            } else {
                $textoErro = "Erro ao inserir fase: " . $stmt->error;
                $erro = true;
            }
        }
    }
} else {
    caminho(); // Função definida em outro ficheiro, assume redirecionamento
}

// Mensagens finais
if (!$erro && $alteracaoFeita) {
    criarLogs("Conteudo curso alterado", $_SESSION['utilizadorOn']['Id_user'], null, $idcursoAtual);
    mostrarPopUp("Alteração feita com sucesso!", null, "../adicionar_conteudo.php");
} elseif (!$alteracaoFeita) {
    mostrarPopUp("Nenhuma alteração foi feita!", null, "../adicionar_conteudo.php");
}

if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, null, null, $textoErro, __FILE__);
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

function processarVideo($conn, $idcursoAtual, $indice)
{
    $nomeArquivo     = $_FILES['video']['name'][$indice] ?? null;
    $tmpArquivo      = $_FILES['video']['tmp_name'][$indice] ?? null;
    $tipoMime        = $tmpArquivo ? mime_content_type($tmpArquivo) : null;

    $extensoesPermitidas = ['mp4', 'webm', 'ogg', 'mov', 'avi', 'mkv', 'm4v'];
    $mimesPermitidos     = [
        'video/mp4',
        'video/webm',
        'video/ogg',
        'video/quicktime',
        'video/x-msvideo',
        'video/x-matroska',
        'video/x-m4v'
    ];
    $extensao            = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

    if (in_array($extensao, $extensoesPermitidas) && in_array($tipoMime, $mimesPermitidos)) {
        $diretorio = "../../../assets/conteudosCursos/videos/";
        $base_nome = "video_fase{$indice}_curso{$idcursoAtual}";
        $novo_nome = "{$base_nome}.{$extensao}";
        $destino   = $diretorio . $novo_nome;

        // Remove vídeos anteriores
        foreach ($extensoesPermitidas as $ext) {
            $possivel = "{$diretorio}{$base_nome}.{$ext}";
            if (file_exists($possivel)) {
                unlink($possivel);
            }
        }

        // Move novo vídeo
        if (move_uploaded_file($tmpArquivo, $destino)) {
            return $novo_nome;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function processarImagem($conn, $idcursoAtual, $indice)
{
    $nomeArquivo     = $_FILES['imagem']['name'][$indice] ?? null;
    $tmpArquivo      = $_FILES['imagem']['tmp_name'][$indice] ?? null;
    $tipoMime        = $tmpArquivo ? mime_content_type($tmpArquivo) : null;

    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];
    $mimesPermitidos     = ['image/jpeg', 'image/png'];
    $extensao            = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

    if (in_array($extensao, $extensoesPermitidas) && in_array($tipoMime, $mimesPermitidos)) {
        $diretorio = "../../../assets/conteudosCursos/imagens/";
        $base_nome = "Imagem_fase{$indice}_curso{$idcursoAtual}";
        $novo_nome = "{$base_nome}.{$extensao}";
        $destino   = $diretorio . $novo_nome;

        // Remove imagens anteriores
        foreach ($extensoesPermitidas as $ext) {
            $possivel = "{$diretorio}{$base_nome}.{$ext}";
            if (file_exists($possivel)) {
                unlink($possivel);
            }
        }

        // Move nova imagem
        if (move_uploaded_file($tmpArquivo, $destino)) {
            return $novo_nome;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
