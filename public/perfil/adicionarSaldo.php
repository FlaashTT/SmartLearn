<?php

include("../segurança.php");
include("../../database/basedados.php");
include("../logs.php");
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
            criarLogs("Deposito de saldo",$_SESSION['utilizadorOn']['Id_user'],$_POST['adicionarSaldo']);
            echo'
            <script>
                alert("Adicionado '.$_POST['adicionarSaldo'].'€ ha sua conta");
                window.location.href = document.referrer;
            </script>
            ';
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
