<?php
session_start();

include("../../../database/basedados.php");

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
            (Nome_curso, Id_categoria, Id_idioma, Criador_curso, Data_criacao, URL_foto_perfil_curso, Pequena_descricao, Descricao, Preco, Preco_antigo, Estado_curso, Tempo_estimado, Dificuldade, Requisitos, Provedor_geral_curso, Keywords) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Erro na preparação da query: " . $conn->error);
        }

        $criadorCurso = $_SESSION['utilizadorOn']['Id_user'] ?? 1;

        $stmt->bind_param(
            "siiissssddssssss",
            $titulo,
            $id_categoria,
            $linguagem,
            $criadorCurso,
            $DataAtual,
            $imagemNome,
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
            echo "<script>alert('Curso adicionado com sucesso!'); window.location.href = '../adicionar_cursos.php';</script>";
            exit;
        } else {
            $textoErro = 'Erro ao adicionar o curso: ' . $stmt->error;
            $erro = true;
        }
    }

    if ($erro) {
        echo "<script>alert('$textoErro'); window.location.href = '../adicionar_cursos.php';</script>";
        exit;
    }
}
