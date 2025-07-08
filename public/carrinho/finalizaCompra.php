<?php
include('../segurança.php');
include('../../database/basedados.php');
require_once("../popup.php");
require_once("../logs.php");

$erro = false;
$textoErro = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $preco = $_SESSION['valorFinal']; // valor final de compra
    $saldoConta = $_SESSION['utilizadorOn']['Carteira'];

    if (!isset($preco) || $preco === '') {

        $erro = true;
        $textoErro = "Erro: preço está vazio.";
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
            exit;  // para aqui porque o saldo é insuficiente
        } else {
            $preco = (float) $preco;
            $saldoFinal = $saldoConta - $preco;
            $saldoFinal = (float) $saldoFinal;

            $DataAtual = date('Y-m-d');

            $listaCursos = $_SESSION['listaCursos'] ?? [];

            // Inserir no cursos_adquiridos
            $stmt = $conn->prepare("
                INSERT INTO cursos_adquiridos(Id_user, Id_curso, Data_compra, AdicionadoPor)  
                VALUES (?, ?, ?, ?)
            ");
            if (!$stmt) {
                $textoErro = "Erro no prepare de cursos_adquiridos: " . $conn->error ;
                $erro = true;
            } else {
                $adicionaPor = null;
                $stmt->bind_param("iisi", $_SESSION['utilizadorOn']['Id_user'], $id_curso, $DataAtual, $adicionaPor);

                foreach ($listaCursos as $id_curso) {
                    $id_curso = (int) trim($id_curso); // garantir que é inteiro
                    $executou = $stmt->execute();
                    if (!$executou) {
                        $textoErro = "Erro ao executar INSERT cursos_adquiridos para o curso $id_curso: " . $stmt->error ;
                        $erro = true;
                        break;
                    }
                }
                $stmt->close();
            }

            // Inserir no historico_compras
            if (!$erro) {
                $stmt = $conn->prepare("
                    INSERT INTO historico_compras(Id_user, Id_curso, Data_compra)  
                    VALUES (?, ?, ?)
                ");
                if (!$stmt) {
                    $textoErro = "Erro no prepare de historico_compras: " . $conn->error ;
                    $erro = true;
                } else {
                    $stmt->bind_param("iis", $_SESSION['utilizadorOn']['Id_user'], $id_curso, $DataAtual);

                    foreach ($listaCursos as $id_curso) {
                        $id_curso = (int) trim($id_curso);
                        $executou = $stmt->execute();
                        if (!$executou) {
                            $textoErro = "Erro ao executar INSERT historico_compras para o curso $id_curso: " . $stmt->error ;
                            $erro = true;
                            break;
                        }
                    }
                    $stmt->close();
                }
            }

            // Eliminar do carrinho
            if (!$erro) {
                $stmt = $conn->prepare("
                    DELETE FROM carrinho_compras
                    WHERE Id_user = ?
                ");
                if (!$stmt) {
                    $textoErro = "Erro no prepare DELETE carrinho_compras: " . $conn->error ;
                    $erro = true;
                } else {
                    $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
                    $executou = $stmt->execute();
                    if (!$executou) {
                        $textoErro = "Erro ao executar DELETE carrinho_compras: " . $stmt->error ;
                        $erro = true;
                    }
                    $stmt->close();
                }
            }

            // Atualizar saldo do utilizador
            if (!$erro) {
                $stmt = $conn->prepare("
                    UPDATE user 
                    SET Carteira = ? 
                    WHERE Id_user = ?
                ");
                if (!$stmt) {
                    $textoErro = "Erro no prepare UPDATE user: " . $conn->error ;
                    $erro = true;
                } else {
                    $stmt->bind_param("di", $saldoFinal, $_SESSION['utilizadorOn']['Id_user']);
                    $executou = $stmt->execute();
                    if (!$executou) {
                        $textoErro = "Erro ao executar UPDATE user: " . $stmt->error ;
                        $erro = true;
                    }
                    $stmt->close();
                }
            }

            if (!$erro) {
                $_SESSION['utilizadorOn']['Carteira'] = $saldoFinal;
                criarLogs("Compra curso", $_SESSION['utilizadorOn']['Id_user'], $preco);
                mostrarPopUp("Pagamento realizado com sucesso!", null, "carrinho.php");
                exit;
            }
        }
    }
}

if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, null, null, $textoErro, __FILE__);
    mostrarPopUp($textoErro);
    exit;
}
