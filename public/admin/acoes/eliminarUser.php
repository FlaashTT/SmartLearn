<?php
include("../../../database/basedados.php");
session_start();
require_once("../../popup.php");
require_once("../../logs.php");
$efetuadaTroca = false;
$erro = false;
$textoErro = '';
// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['idEliminar']) && $_POST['idEliminar'] === '') {
        $textoErro = "Erro ao coletar o ID";
        $erro = true;
    }
    $id = $_POST['idEliminar'];

    //fazer update da tabela user o campo Estado_conta para Eliminado onde o Id_user = Id
    $sql = "UPDATE user SET Estado_conta = 'Eliminado' WHERE Id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $efetuadaTroca = true;
    } else {
        $erro = true;
        $textoErro = "Erro ao eliminar utilizador: " . $conn->error;
    }
} else {
    $erro = true;
    $textoErro = "Método de requisição inválido.";
}

if (!$erro && $efetuadaTroca) {
    criarLogs("Conta eliminada", $_SESSION['utilizadorOn']['Id_user'], null, null, null, null, null, $id);
    mostrarPopUp("Utilizador atualizado com sucesso!");
} else if ($erro) {
    criarLogs("Erro",$_SESSION['utilizadorOn']['Id_user'],null,null,$novoId,$textoErro,__FILE__);
    mostrarPopUp($textoErro);
}

function caminho()
{
    // Redireciona para a página de administração
    echo '
    <script>
    window.location.href = document.referrer;
    </script>
    ';
    exit();
}
