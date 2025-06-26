<?php
include("../../database/basedados.php");
include("../segurança.php");
require_once("../popup.php");
require_once("../logs.php");
$erro = false;
$textErro = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['idCurso'])) {
        $erro = true;
        $textErro = "Erro ao receber o Id do curso";
    } else {
        $idCursoReembolso = $_POST['idCurso'];
        $idUser = $_SESSION['utilizadorOn']['Id_user'];

        // Verificar se o curso existe
        $sql = "SELECT * FROM curso WHERE Id_curso = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idCursoReembolso);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $rowPreco = $result->fetch_assoc();
            $preco = $rowPreco['Preco'];
            $stmt->close();

            // Verificar se o utilizador tem esse curso
            $sql = "SELECT * FROM cursos_adquiridos WHERE Id_curso = ? AND Id_user = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $idCursoReembolso, $idUser);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $stmt->close();

                if ($row['Progresso'] == "concluido") {
                    mostrarPopUp("Não pode realizar reembolso deste curso! Curso concluído.");

                    $erro = true;
                } else if ($row['Percentagem_progresso'] > 10) {
                    mostrarPopUp("Não pode realizar reembolso deste curso! Mais de 10% concluído.");

                    $erro = true;
                } else {
                    // Atualizar tipo de pagamento no histórico de compras
                    $sql = "UPDATE historico_compras SET Tipo_pagamento = 'reembolsado' WHERE Id_curso = ? AND Id_user = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $idCursoReembolso, $idUser);
                    if ($stmt->execute()) {
                        $stmt->close();

                        // Remover curso dos adquiridos
                        $sql = "DELETE FROM cursos_adquiridos WHERE Id_curso = ? AND Id_user = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ii", $idCursoReembolso, $idUser);
                        if ($stmt->execute()) {
                            $stmt->close();

                            // Atualizar saldo do utilizador
                            $novoSaldo = $_SESSION['utilizadorOn']['Carteira'] + $preco;
                            $sql = "UPDATE user SET Carteira = ? WHERE Id_user = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("di", $novoSaldo, $idUser);
                            if ($stmt->execute()) {
                                $stmt->close();

                                // Atualizar a sessão com o novo saldo
                                $_SESSION['utilizadorOn']['Carteira'] = $novoSaldo;

                                // Criar log de reembolso

                                criarLogs("Reembolso curso", $idUser, $preco, $idCursoReembolso);

                                mostrarPopUp("Reembolso realizado com sucesso!");

                                exit();
                            } else {

                                $textErro = "Erro ao atualizar o saldo do utilizador";
                                $erro = true;
                            }
                        } else {
                            $textErro = "Erro ao remover o curso dos seus cursos";
                            $erro = true;
                        }
                    } else {
                        $erro = "Erro ao atualizar o estado do curso";
                        $erro = true;
                    }
                }
            } else {
                $textoErro = "Erro ao verificar o curso na sua conta! Tente novamente.";
                $erro = true;
            }
        } else {
            $textoErro = "Curso inexistente, tente novamente.";
            $erro = true;
        }
    }
} else {
    echo '
        <script>
            window.history.back();
        </script>
    ';
}

if ($erro) {
    criarLogs("Erro", $_SESSION['utilizadorOn']['Id_user'], null, null, null, $textoErro, __FILE__);
    mostrarPopUp($textoErro);
}
