
<?php

include("../../../database/basedados.sql");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = false;
    $textoErro = "";


    if (!isset($_POST['titulo']) || empty(trim($_POST['titulo']))) {
        $textoErro = 'Título é obrigatório!';
        $erro = true;
    } else {
        $titulo = $_POST['titulo'];
    }

    $peqDescricao = $_POST['peq_descricao'];
    $descricao = $_POST['descricao'];
    $id_categoria = $_POST['id_categoria'];
    $dificuldade = $_POST['dificuldade'];
    $linguagem = $_POST['linguagem'];


    $preco = $_POST['preco_curso'] ?? null;
    $Precodescontado = $_POST['preco_descontado'] ?? null;

    $provedor = $_POST['provedor'];
    $imagem = $_FILES['url_imagem']['name'];

    if (
        !isset($_POST['peq_descricao']) || empty(trim($_POST['peq_descricao'])) ||
        !isset($_POST['descricao']) || empty(trim($_POST['descricao'])) ||
        !isset($_POST['id_categoria']) || empty(trim($_POST['id_categoria'])) ||
        !isset($_POST['dificuldade']) || empty(trim($_POST['dificuldade'])) ||
        !isset($_POST['linguagem']) || empty(trim($_POST['linguagem']))
    ) {
        $estado = "Incompleto";
    } else {
        $estado = "Completo";
    }
    $DataAtual = date('Y-m-d H:i:s');

    
    

    $sql = "INSERT INTO curso (Nome_curso, Id_categoria, Id_idioma, Criador_curso, Data_criacao, URL_foto_perfil_curso, Pequena_descricao, Descricao, Preco, Preco_antigo, Estado_curso, Tempo_estimado, Dificuldade, Requesitos, Provedor_geral_curso, Keywords) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiissssddssssss", $titulo, $id_categoria, $linguagem, $_SESSION['utilizadorOn']['Id_user'], $DataAtual, $imagem, $peqDescricao, $descricao, $preco, $precoDescontado, $estado, $tempoEstimado, $dificuldade, $requesitos, $provedor, $keywords);
    $stmt->execute();
    $result = $conn->query($sql);

    if (!$result) {
        
        $textoErro = 'Erro ao adicionar o curso: ' . $conn->error;
        $erro = true;
    } 
}
if ($erro) {
    echo '
    <script>alert("' . $textoErro . '");</script>
    ';
    caminho();
}
function caminho()
{
    echo "<script>
        window.location.href = '../adicionar_cursos.php'; // Volta para a página anterior
    </script>";
}
