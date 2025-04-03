<?php
include('../public/segurança.php');
include('../database/basedados.sql');

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $preco =  $_SESSION['valorFinal']; //valor final de compra
    $saldoConta = $_SESSION['utilizadorOn']['Carteira'];


    echo $_SESSION['utilizadorOn']['Carteira'];

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
            $preco = (float) $preco;  
            $saldoFinal = $saldoConta - $preco; 

            $saldoFinal = (float) $saldoFinal;  
            

            
            $stmt = $conn->prepare("
                    UPDATE user 
                    SET Carteira = ? 
                    WHERE Id_user = ?
                ");
            $stmt->bind_param("di", $saldoFinal, $_SESSION['utilizadorOn']['Id_user']);
            if($stmt->execute()){
                $_SESSION['utilizadorOn']['Carteira'] = $saldoFinal; 
                echo'
                    <script>
                        alert("Pagamento realizado com sucesso!");
                        window.location.href = "carrinho.php";
                    </script>
                ';
            }
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
