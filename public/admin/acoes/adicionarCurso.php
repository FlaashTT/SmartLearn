<?php


include("../../../database/basedados.php");
session_start();
require_once("../../popup.php");
require_once("../../logs.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = false;
    $textoErro = "";

    // Validação título obrigatório
    if (!isset($_POST['titulo']) || empty(trim($_POST['titulo']))) {
        $textoErro = 'Título é obrigatório!';
        $erro = true;
    } else {
        $titulo = trim($_POST['titulo']);
    }

    $peqDescricao = $_POST['peq_descricao'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $id_categoria = $_POST['categoria'] ?? null;
    $dificuldade = $_POST['dificuldade'] ?? '';
    $linguagem = $_POST['idioma'] ?? '';
    $preco = $_POST['preco'] ?? 0.0;
    $precoDescontado = $_POST['desconto'] ?? 0.0;
    $provedor = $_POST['provedor'] ?? '';
    echo "<script>console.log('Provedor: $linguagem');</script>";

    $tempoEstimado = ''; // Sem input no form, deixa vazio
    $requesitos = '';    // Sem input no form, deixa vazio
    $keywords = '';      // Sem input no form, deixa vazio

    if (
        empty(trim($peqDescricao)) ||
        empty(trim($descricao)) ||
        empty(trim($id_categoria)) ||
        empty(trim($dificuldade)) ||
        empty(trim($linguagem))
    ) {
        $estado = "Incompleto";
    } else {
        $estado = "Completo";
    }

    $DataAtual = date('Y-m-d H:i:s');



    if (!$erro) {




        $sql = "INSERT INTO curso 
            (Nome_curso, Id_categoria, Id_idioma, Criador_curso, Data_criacao, Pequena_descricao, Descricao, Preco, Preco_antigo, Estado_curso, Tempo_estimado, Dificuldade, Requisitos, Provedor_geral_curso, Keywords) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Erro na preparação da query: " . $conn->error);
        }

        $criadorCurso = $_SESSION['utilizadorOn']['Id_user'] ?? 1;

        $stmt->bind_param(
            "siiisssddssssss",
            $titulo,
            $id_categoria,
            $linguagem,
            $criadorCurso,
            $DataAtual,
            $peqDescricao,
            $descricao,
            $preco,
            $precoDescontado,
            $estado,
            $tempoEstimado,
            $dificuldade,
            $requesitos,
            $provedor,
            $keywords
        );

        if ($stmt->execute()) {

            // 🔹 Recuperar o ID do curso recém inserido
            $Id_curso = $conn->insert_id;

            if (!empty($_FILES['imagem_curso']['name'])) {

                $extensao = strtolower(pathinfo($_FILES["imagem_curso"]["name"], PATHINFO_EXTENSION));
                $extensoes_permitidas = ['jpg', 'jpeg', 'png'];
                $tipo_mime = mime_content_type($_FILES["imagem_curso"]["tmp_name"]);
                $mimes_permitidos = ['image/jpeg', 'image/png'];

                if (in_array($extensao, $extensoes_permitidas) && in_array($tipo_mime, $mimes_permitidos)) {

                    $diretorio = "../../../assets/image/curso/";
                    $base_nome = "curso_id" . $Id_curso;
                    $novo_nome = $base_nome . "." . $extensao;
                    $destino = $diretorio . $novo_nome;

                    foreach (['jpg', 'jpeg', 'png'] as $ext) {
                        $possivel_arquivo = $diretorio . $base_nome . '.' . $ext;
                        if (file_exists($possivel_arquivo)) {
                            unlink($possivel_arquivo);
                        }
                    }

                    if (move_uploaded_file($_FILES["imagem_curso"]["tmp_name"], $destino)) {

                        $URL_foto = $novo_nome;
                        $sql = "UPDATE curso SET URL_foto_perfil_curso = ? WHERE Id_curso = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("si", $URL_foto, $Id_curso);

                        if ($stmt->execute()) {
                            $stmt->close();
                        } else {
                            $textoErro = 'Erro ao atualizar o banco de dados!';
                        }
                    } else {
                        $textoErro = 'Erro ao mover a imagem!';
                    }
                } else {
                    $textoErro = 'Formato de imagem inválido. Apenas JPG, JPEG e PNG são permitidos.';
                }
            }

            mostrarPopUp('Curso adicionado com sucesso!');
            criarLogs("Novo curso", $_SESSION['utilizadorOn']['Id_user'], null, $Id_curso);

            exit;
        } else {
            $textoErro = 'Erro ao adicionar o curso: ' . $stmt->error;
            $erro = true;
        }
    }

    if ($erro) {
        $textoErro = '$textoErro';
        criarLogs("Erro",$_SESSION['utilizadorOn']['Id_user'],null,$Id_curso,$null,$textoErro,__FILE__);
        exit;
    }
}
