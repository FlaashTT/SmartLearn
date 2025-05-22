<?php
include("../../../database/basedados.sql");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['IdRemover']) || empty($_POST['IdRemover'])) {
        $textoErro = "Erro na coleta do ID da categoria!";
        $erro = true;
    }


    $idParaRemover = $_POST['IdRemover'];
    //fazer delete da base de dados
    $query = "DELETE FROM cursos_adquiridos WHERE Id_adquirido = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idParaRemover);
    if ($stmt->execute()) {
        echo '
        <script>
            alert("Utilizador removido do curso com sucesso!");
            </script>';
        
        caminho();

    } else {
        $textoErro = "Erro ao remover o utilizador do curso!";
        $erro = true;
    }
} else {
    caminho();
}



if ($erro) {
    echo "<script>alert('$textoErro');</script>";
}
function caminho()
{
    echo '
    <script>
        window.location.href = "../registar_historico.php";
    </script>
    ';
    exit;
}
