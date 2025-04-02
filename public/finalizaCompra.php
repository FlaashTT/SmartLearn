<?php
session_start();
include('../public/segurança.php');
include('../database/basedados.sql');

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $preco = $_POST['valorTotal']; //valor final de compra
    $saldoConta = $_SESSION['utilizadorOn']['Carteira'];


   
    if (empty($preco)) {
        $erro = true;
    } else {
        if ($saldoConta < $preco) {
            echo '
            <script>
                if(confirm("O seu saldo é insuficiente,deseja depositar?")){
                    window.location.href = "adicionarSaldo.php";
                }else{
                    window.history.back();
                }
            </script>
            ';
        } else {
            echo $preco . "<br>" . $saldoConta+0;//da erro ao realizar a conta
        }
    }
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
