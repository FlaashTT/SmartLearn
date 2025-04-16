<?php
include('../segurança.php');
include('../../database/basedados.sql');

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $preco = $_SESSION['valorFinal']; // valor final de compra
    $saldoConta = $_SESSION['utilizadorOn']['Carteira'];

    if (empty($preco)) {
        $erro = true;
    } else {
        if ($saldoConta < $preco) {
            echo '
            <script>
                if(confirm("O seu saldo é insuficiente, deseja depositar?")){
                    window.location.href = "../perfil/perfil_carteira.php";
                } else {
                    window.history.back();
                }
            </script>
            ';
        } else {
            $preco = (float) $preco;
            $saldoFinal = $saldoConta - $preco;
            $saldoFinal = (float) $saldoFinal;

            $DataAtual = date('Y-m-d');

            // Corrigir formato de listaCursos (string para array, se necessário)
            $listaCursos = $_SESSION['listaCursos'] ?? [];
            
            // Inserir no cursos_adquiridos
            $stmt = $conn->prepare("
                INSERT INTO cursos_adquiridos(Id_user, Id_curso, Data_compra)  
                VALUES (?, ?, ?)
            ");
            $stmt->bind_param("iis", $_SESSION['utilizadorOn']['Id_user'], $id_curso, $DataAtual);

            foreach ($listaCursos as $id_curso) {
                $id_curso = (int) trim($id_curso); // garantir que é inteiro
                if (!$stmt->execute()) {
                    $erro = true;
                    break;
                }
            }

            //para inserir na tabela historico compras
            $stmt = $conn->prepare("
                INSERT INTO historico_compras(Id_user, Id_curso, Data_compra)  
                VALUES (?, ?, ?)
            ");
            $stmt->bind_param("iis", $_SESSION['utilizadorOn']['Id_user'], $id_curso, $DataAtual);

            foreach ($listaCursos as $id_curso) {
                $id_curso = (int) trim($id_curso); // garantir que é inteiro
                if (!$stmt->execute()) {
                    $erro = true;
                    break;
                }
            }

            // Eliminar do carrinho
            if (!$erro) {
                $stmt = $conn->prepare("
                    DELETE FROM carrinho_compras
                    WHERE Id_user = ?
                ");
                $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);

                if ($stmt->execute()) {

                    // Atualizar saldo do utilizador
                    $stmt = $conn->prepare("
                        UPDATE user 
                        SET Carteira = ? 
                        WHERE Id_user = ?
                    ");
                    $stmt->bind_param("di", $saldoFinal, $_SESSION['utilizadorOn']['Id_user']);

                    if ($stmt->execute()) {
                        $_SESSION['utilizadorOn']['Carteira'] = $saldoFinal;

                        include('../logs.php');
                        criarLogs("Compra curso", $_SESSION['utilizadorOn']['Id_user'], $preco);

                        echo '
                        <script>
                            alert("Pagamento realizado com sucesso!");
                            window.location.href = "carrinho.php";
                        </script>
                        ';
                        exit;
                    } else {
                        $erro = true;
                    }
                } else {
                    $erro = true;
                }
            }
        }
    }
}

if ($erro) {
    echo "
    <script>
        alert('Ocorreu um erro, tente mais tarde.');
        window.history.back();
    </script>
    ";
    exit;
}
