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
    echo "<script>console.log('Requisição POST iniciada');</script>";

    if (!isset($_POST['input-curso-id']) || $_POST['input-curso-id'] === '' || $_POST['input-curso-id'] === null) {
        $textoErro = "Ocorreu um erro tente novamente ou entre em contacto com o suporte";
        $erro = true;
        echo "<script>console.log('Erro: ID do curso não enviado');</script>";
        exit;
    }

    $idcursoAtual = $_POST['input-curso-id'];
    echo "<script>console.log('ID do curso: " . $idcursoAtual . "');</script>";

    $query = "SELECT * FROM curso WHERE Id_curso = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idcursoAtual);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        $textoErro = "Erro ao coletar informaçoes do curso!";
        $erro = true;
        echo "<script>console.log('Curso não encontrado com ID: " . $idcursoAtual . "');</script>";
    }

    $titulos = $_POST['titulo'] ?? [];
    $conteudos = $_POST['conteudo'] ?? [];
    $fases = $_POST['fase'] ?? [];
    $videos = $_FILES['video']['name'] ?? [];
    $imagens = $_FILES['imagem']['name'] ?? [];

    echo "<script>console.log('Títulos recebidos: " . json_encode($titulos) . "');</script>";
    echo "<script>console.log('Conteúdos recebidos: " . json_encode($conteudos) . "');</script>";
    echo "<script>console.log('Fases recebidas: " . json_encode($fases) . "');</script>";
    echo "<script>console.log('Videos recebidos: " . json_encode($videos) . "');</script>";
    echo "<script>console.log('Imagens recebidas: " . json_encode($imagens) . "');</script>";

    $totalFases = count($fases);
    echo "<script>console.log('Total de fases: " . $totalFases . "');</script>";

    for ($i = 1; $i <= $totalFases; $i++) {
        echo "<script>console.log('Processando fase " . $i . "');</script>";

        $novoNomeImagem = "";
        $novoNomeVideo = "";

        $sqlverifica = "SELECT COUNT(*) as total FROM fase WHERE Id_curso = ? AND Num_fase = ?";
        $stmtVerifica = $conn->prepare($sqlverifica);
        $stmtVerifica->bind_param("ii", $idcursoAtual, $i);
        $stmtVerifica->execute();
        $resultado = $stmtVerifica->get_result();
        $row = $resultado->fetch_assoc();
        $quantidade = $row['total'];

        echo "<script>console.log('Fase " . $i . " já existe? " . $quantidade . "');</script>";

        if ($quantidade > 0) {
            if (isset($videos[$i]) && $videos[$i] != "") {
                $NumFase = $i;
                echo "<script>console.log('Atualizando vídeo da fase " . $i . "');</script>";
                if (processarVideo($conn, $idcursoAtual, $NumFase)) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "ERRO ao atualizar o video,tente mais tarde!";
                    $erro = true;
                }
            }

            if (isset($imagens[$i]) && $imagens[$i] != "") {
                $NumFase = $i;
                echo "<script>console.log('Atualizando imagem da fase " . $i . "');</script>";
                if (processarImagem($conn, $idcursoAtual, $NumFase)) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "ERRO ao atualizar a imagem,tente mais tarde!";
                    $erro = true;
                }
            }

            if ($titulos[$i] != "") {
                echo "<script>console.log('Atualizando título da fase " . $i . ": " . addslashes($titulos[$i]) . "');</script>";
                $update = "UPDATE fase SET Titulo_fase = ? WHERE Id_curso = ? AND Num_fase = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("sii", $titulos[$i], $idcursoAtual, $i);
                $stmt->execute();
                if ($stmt->execute()) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "Erro ao atualizar título: " . $stmt->error;
                    $erro = true;
                }
            }

            if ($conteudos[$i] != "") {
                echo "<script>console.log('Atualizando conteúdo da fase " . $i . ": " . addslashes($conteudos[$i]) . "');</script>";
                $update = "UPDATE fase SET Conteudo_fase = ? WHERE Id_curso = ? AND Num_fase = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("sii", $conteudos[$i], $idcursoAtual, $i);
                $stmt->execute();
                if ($stmt->execute()) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "Erro ao atualizar conteúdo: " . $stmt->error;
                    $erro = true;
                }
            }
        } else {
            echo "<script>console.log('Criando nova fase " . $i . "');</script>";

            $NumFase = $i;
            if (isset($videos[$i]) && $videos[$i] != "") {
                echo "<script>console.log('Processando vídeo para nova fase " . $i . "');</script>";
                if (processarVideo($conn, $idcursoAtual, $NumFase)) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "ERRO ao atualizar o video,tente mais tarde!";
                    $erro = true;
                }
            }

            if (isset($imagens[$i]) && $imagens[$i] != "") {
                echo "<script>console.log('Processando imagem para nova fase " . $i . "');</script>";
                if (processarImagem($conn, $idcursoAtual, $NumFase)) {
                    $alteracaoFeita = true;
                } else {
                    $textoErro = "ERRO ao atualizar a imagem,tente mais tarde!";
                    $erro = true;
                }
            }

            echo "<script>console.log('Inserindo fase " . $i . ": título=" . addslashes($titulos[$i] ?? '') . ", conteúdo=" . addslashes($conteudos[$i] ?? '') . "');</script>";

            $insert = "INSERT INTO fase(Id_curso, Num_fase, Titulo_fase, Conteudo_fase, Imagem, video) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert);
            $stmt->bind_param("iissss", $idcursoAtual, $i, $titulos[$i], $conteudos[$i], $novoNomeImagem, $novoNomeVideo);
            if ($stmt->execute()) {
                echo "<script>";
                echo "console.log('INSERT INTO fase(Id_curso, Num_fase, Titulo_fase, Conteudo_fase, Imagem, video)');";
                echo "console.log('VALUES (" . $idcursoAtual . ", " . $i . ", \"" . addslashes($titulos[$i]) . "\", \"" . addslashes($conteudos[$i]) . "\", \"" . $novoNomeImagem . "\", \"" . $novoNomeVideo . "\")');";
                echo "</script>";
                $alteracaoFeita = true;
            } else {
                $textoErro = "Erro ao inserir nova fase: " . $stmt->error;
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
    echo "<script>console.log('Erro ocorrido: " . addslashes($textoErro) . "');</script>";
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
