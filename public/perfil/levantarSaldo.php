<?php

include("../segurança.php");
include("../../database/basedados.php");
include("../logs.php");
require_once("../popup.php");
$erro = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['levantarSaldo']) && $_POST['levantarSaldo'] > 0) {

        if ($_POST['levantarSaldo'] <= $_SESSION['utilizadorOn']['Carteira']) {

            $novoSaldo = $_SESSION['utilizadorOn']['Carteira'] - $_POST['levantarSaldo'];

            $sql = "UPDATE user set Carteira = ? WHERE Id_user = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $novoSaldo, $_SESSION['utilizadorOn']['Id_user']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($stmt->affected_rows > 0) {
                $_SESSION['utilizadorOn']['Carteira'] = $novoSaldo; // Atualizar sessão
                criarLogs("Levantamento de saldo", $_SESSION['utilizadorOn']['Id_user'], $_POST['levantarSaldo']);
                mostrarPopUp('Foi retirado ' . number_format($_POST['levantarSaldo'], 2, ',', ' ') . '€ da sua conta');
              
            }
        } else {
            mostrarPopUp("Nao tem esse saldo na sua conta");
           
        }
    } else {
        mostrarPopUp("Tem de inserir um valor valido");
        
    }
} else {
    $erro = true;
}

if ($erro) {
    echo '
    <script>
    window.history.back();
    </script>
    ';
}
