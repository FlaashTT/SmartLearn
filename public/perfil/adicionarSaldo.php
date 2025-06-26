<?php

include("../segurança.php");
include("../../database/basedados.php");
include("../logs.php");
require_once("../popup.php");
$erro = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['adicionarSaldo']) && $_POST['adicionarSaldo'] > 0) {

        $novoSaldo = $_SESSION['utilizadorOn']['Carteira'] + $_POST['adicionarSaldo'];

        $sql = "UPDATE user set Carteira = ? WHERE Id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $novoSaldo, $_SESSION['utilizadorOn']['Id_user']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($stmt->affected_rows > 0) {
            criarLogs("Deposito de saldo", $_SESSION['utilizadorOn']['Id_user'], $_POST['adicionarSaldo']);
            mostrarPopUp("Adicionado " . $_POST['adicionarSaldo'] . "€ ha sua conta");
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
