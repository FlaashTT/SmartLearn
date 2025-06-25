<?php
include("../segurança.php");
include("../../database/basedados.php");
require_once("../popup.php");
require_once("../logs.php");

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idCarrinho = $_POST['id_carrinho'];
    if (empty($idCarrinho)) {
        $erro = true;
    } else {
        $stmt = $conn->prepare("DELETE FROM carrinho_compras WHERE Id_carrinho = ?");
        $stmt->bind_param("i", $idCarrinho);
        $result = $stmt->get_result();

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            mostrarPopUp("Curso removido do carrinho com sucesso!");
            
        }else{
            $erro = true;
        }
    }
} else {
    $erro = true;
}

if ($erro) {
    mostrarPopUp("Ocorreu um erro ,tente mais tarde");
    
    exit;
}
