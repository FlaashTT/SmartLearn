<?php

include("../segurança.php");
include("../../database/basedados.php");
include("../logs.php");
$erro = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['levantarSaldo']) && $_POST['levantarSaldo'] > 0) {

        if ($_POST['levantarSaldo'] < $_SESSION['utilizadorOn']['Carteira']) {

            $novoSaldo = $_SESSION['utilizadorOn']['Carteira'] - $_POST['levantarSaldo'];

            $sql = "UPDATE user set Carteira = ? WHERE Id_user = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $novoSaldo, $_SESSION['utilizadorOn']['Id_user']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($stmt->affected_rows > 0) {
                criarLogs("Levantamento de saldo", $_SESSION['utilizadorOn']['Id_user'], $_POST['levantarSaldo']);
                echo '
            <script>
                alert("Foi retirado ' . $_POST['levantarSaldo'] . '€ da sua conta");
                window.location.href = document.referrer;
            </script>
            ';
            }
        } else {
            echo '
                <script>
                alert("Nao tem esse saldo na sua conta");
                </script>
                ';
            $erro = true;
        }
    } else {
        echo '
        <script>
        alert("Tem de inserir um valor valido");
        </script>
        ';
        $erro = true;
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
