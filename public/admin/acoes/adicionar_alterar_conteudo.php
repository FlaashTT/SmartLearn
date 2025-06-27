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


    for ($i = 1; $i <= $totalFases; $i++) {
        $novoNomeImagem = "";
        $novoNomeVideo = "";

        //verificar se ja existe esta fase
        $sqlverifica = "SELECT COUNT(*) as total FROM fase WHERE Id_curso = ? AND Num_fase = ?";
        $stmtVerifica = $conn->prepare($sqlverifica);
        $stmtVerifica->bind_param("ii", $idcursoAtual, $i);
        $stmtVerifica->execute();
        $resultado = $stmtVerifica->get_result();
        $row = $resultado->fetch_assoc();
        $quantidade = $row['total'];

        if ($quantidade > 0) {
            //se ja existir a fase
            if (isset($videos[$i]) && $videos[$i] != "") {
                $NumFase = $i;
                if (processarVideo($conn, $idcursoAtual, $NumFase)) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "ERRO ao atualizar o video,tente mais tarde!";
                    $erro = true;
                }
            }

            if (isset($imagens[$i]) && $imagens[$i] != "") {
                $NumFase = $i;

                if (processarImagem($conn, $idcursoAtual, $NumFase)) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "ERRO ao atualizar a imagem,tente mais tarde!";
                    $erro = true;
                }
            }
            if ($titulos[$i] != "") {
                $update = "UPDATE fase SET Titulo_fase = ? WHERE Id_curso = ? AND Num_fase = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("sii", $titulos[$i], $idcursoAtual, $i);
                $stmt->execute();
                if ($stmt->execute()) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "Erro ao atualizar: " . $stmt->error . "<br>";
                    $erro = true;
                }
            }
            if ($conteudos[$i] != "") {
                $update = "UPDATE fase SET Conteudo_fase = ? WHERE Id_curso = ? AND Num_fase = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("sii", $conteudos[$i], $idcursoAtual, $i);
                $stmt->execute();
                if ($stmt->execute()) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "Erro ao atualizar: " . $stmt->error . "<br>";
                    $erro = true;
                }
            }
        } else {
            //se nao ja existir a fase
            if (isset($videos[$i]) && $videos[$i] != "") {

                if (processarVideo($conn, $idcursoAtual, $NumFase)) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "ERRO ao atualizar o video,tente mais tarde!";
                    $erro = true;
                }
            }

            if (isset($imagens[$i]) && $imagens[$i] != "") {
                $NumFase = $i;

                if (processarImagem($conn, $idcursoAtual, $NumFase)) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "ERRO ao atualizar a imagem,tente mais tarde!";
                    $erro = true;
                }
            }

            $insert = "INSERT Into fase(Id_curso, Num_fase, Titulo_fase, Conteudo_fase, Imagem, video) value(?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert);
            $stmt->bind_param("iissss", $idcursoAtual, $i, $titulos[$i], $conteudos[$i], $novoNomeImagem, $novoNomeVideo);
            
            if ($stmt->execute()) {
                $alteracaoFeita = true;
            } else {
                $textoErro = "Erro ao atualizar: " . $stmt->error . "<br>";
                $erro = true;
            }
        }
    }
} else {
    caminho();
}


if (!$erro && $alteracaoFeita) {
    criarLogs("Conteudo curso alterado", $_SESSION['utilizadorOn']['Id_user'], null, $idcursoAtual);
    mostrarPopUp("Alteração feita com sucesso!", null, "../adicionar_conteudo.php");
} elseif (!$alteracaoFeita) {
    mostrarPopUp("Nenhuma alteração foi feita!", null, "../adicionar_conteudo.php");
}

if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'],  null,  null,  null, $textoErro, __FILE__);
    mostrarPopUp($textoErro, null, "../adicionar_conteudo.php");
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
