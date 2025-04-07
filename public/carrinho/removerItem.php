<?php
session_start();
include("../segurança.php");
include("../../database/basedados.sql");

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

            echo"
            <script>
                alert('Curso removido do carrinho com sucesso!');
                window.location.href = document.referrer;
            </script>
            ";
        }else{
            $erro = true;
        }
    }
} else {
    $erro = true;
}

if ($erro) {
    echo "
    <script>
    alert('Ocorreu um erro ,tente mais tarde');
    window.history.back();
    </script>
    ";
    exit;
}
