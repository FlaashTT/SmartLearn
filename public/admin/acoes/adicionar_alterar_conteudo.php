<?php
session_start();
//adicionar_alterar_conteudo.php
include("../../../database/basedados.php");
require_once("../../popup.php");
require_once("../../logs.php");

$alteracaoFeita = false;
$erro = false;
$textoErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['input-curso-id']) || $_POST['input-curso-id'] === '' || $_POST['input-curso-id'] === null) {
        $textoErro = "Ocorreu um erro. Tente novamente ou entre em contacto com o suporte.";
        $erro = true;
    } else {
        $idcursoAtual = $_POST['input-curso-id'];
        $query = "SELECT * FROM curso WHERE Id_curso = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idcursoAtual);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            $textoErro = "Erro ao coletar informações do curso!";
            $erro = true;
        } else {
            $titulos = $_POST['titulo'] ?? [];
            $conteudos = $_POST['conteudo'] ?? [];
            $fases = $_POST['fase'] ?? [];
            $videos = $_FILES['video']['name'] ?? [];
            $imagens = $_FILES['imagem']['name'] ?? [];

            

            for ($i = 0; $i < count($fases); $i++) {
                $numFase = $fases[$i];
                $novoNomeImagem = "";
                $novoNomeVideo = "";

                // Verificar se já existe esta fase
                $sqlverifica = "SELECT COUNT(*) as total FROM fase WHERE Id_curso = ? AND Num_fase = ?";
                $stmtVerifica = $conn->prepare($sqlverifica);
                $stmtVerifica->bind_param("ii", $idcursoAtual, $NumFase);
                $stmtVerifica->execute();
                $resultado = $stmtVerifica->get_result();
                $row = $resultado->fetch_assoc();
                $quantidade = $row['total'];

                if ($quantidade > 0) {
                    // Atualizar fase existente
                    if (isset($videos[$i]) && $videos[$i] != "") {
                        if (processarVideo($conn, $idcursoAtual, $NumFase)) {
                            $alteracaoFeita = true;
                        } else {
                            $textoErro = "ERRO ao atualizar o vídeo. Tente mais tarde!";
                            $erro = true;
                        }
                    }

                    if (isset($imagens[$i]) && $imagens[$i] != "") {
                        if (processarImagem($conn, $idcursoAtual, $NumFase)) {
                            $alteracaoFeita = true;
                        } else {
                            $textoErro = "ERRO ao atualizar a imagem. Tente mais tarde!";
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
                            $textoErro = "Erro ao atualizar o título: " . $stmt->error;
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
                            $textoErro = "Erro ao atualizar o conteúdo: " . $stmt->error;
                            $erro = true;
                        }
                    }
                } else {
                    // Inserir nova fase
                    if (isset($videos[$i]) && $videos[$i] != "") {
                        if (processarVideo($conn, $idcursoAtual, $NumFase)) {
                            $alteracaoFeita = true;
                        } else {
                            $textoErro = "ERRO ao adicionar o vídeo. Tente mais tarde!";
                            $erro = true;
                        }
                    }

                    if (isset($imagens[$i]) && $imagens[$i] != "") {
                        if (processarImagem($conn, $idcursoAtual, $NumFase)) {
                            $alteracaoFeita = true;
                        } else {
                            $textoErro = "ERRO ao adicionar a imagem. Tente mais tarde!";
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
        }
    }
} else {
    caminho();
    exit;
}

if (!$erro && $alteracaoFeita) {
    criarLogs("Conteudo curso alterado", $_SESSION['utilizadorOn']['Id_user'], null, $idcursoAtual);
    mostrarPopUp("Alteração feita com sucesso!", null, "../adicionar_conteudo.php");
    exit;
}

if (!$alteracaoFeita && !$erro) {
    mostrarPopUp("Nenhuma alteração foi feita!", null, "../adicionar_conteudo.php");
    exit;
}

if ($erro) {
    criarLogs("Erro" , $_SESSION['utilizadorOn']['Id_user'], null, $idcursoAtual,null,$textoErro);
    mostrarPopUp($textoErro, null, "../adicionar_conteudo.php");
    exit;
}

function caminho()
{
    echo '<script>
        // Redirecionar para a página anterior
    window.location.href = document.referrer;
    </script>
    ';
}
 
function processarVideo($conn, $idcursoAtual, $NumFaseVideo)
{
    $nomeArquivo     = $_FILES['video']['name'][$NumFaseVideo] ?? null;
    $tmpArquivo      = $_FILES['video']['tmp_name'][$NumFaseVideo] ?? null;
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
        $base_nome = "video_fase{$NumFaseVideo}_curso{$idcursoAtual}";
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
            $sql = "UPDATE fase SET video = ? WHERE Id_curso = ? AND Num_fase = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $novo_nome, $idcursoAtual, $NumFaseVideo);
 
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function processarImagem($conn, $idcursoAtual, $NumFase)
{
    $nomeArquivo     = $_FILES['imagem']['name'][$NumFase] ?? null;
    $tmpArquivo      = $_FILES['imagem']['tmp_name'][$NumFase] ?? null;
    $tipoMime        = $tmpArquivo ? mime_content_type($tmpArquivo) : null;
 
    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];
    $mimesPermitidos     = ['image/jpeg', 'image/png'];
    $extensao            = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
 
    if (in_array($extensao, $extensoesPermitidas) && in_array($tipoMime, $mimesPermitidos)) {
        $diretorio = "../../../assets/conteudosCursos/imagens/";
        $base_nome = "Imagem_fase{$NumFase}_curso{$idcursoAtual}";
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
            $sql = "UPDATE fase SET Imagem = ? WHERE Id_curso = ? AND Num_fase = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $novo_nome, $idcursoAtual, $NumFase);
 
            if ($stmt->execute()) {
                return true;
            } else {
                $stmt->close();
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}