<?php
include("../../database/basedados.sql");
include("../segurança.php");

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['idCurso'])) {
        $erro = true;
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
                    echo '
                        <script>
                            alert("Não pode realizar reembolso deste curso! Curso concluído.");
                        </script>
                    ';
                    $erro = true;
                } else if ($row['Percentagem_progresso'] > 10) {
                    echo '
                        <script>
                            alert("Não pode realizar reembolso deste curso! Mais de 10% concluído.");
                        </script>
                    ';
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
                                include("../logs.php");
                                criarLogs("Reembolso curso", $idUser, $preco, $idCursoReembolso);

                                echo '
                                    <script>
                                        alert("Reembolso realizado com sucesso!");
                                        window.location.href = document.referrer;
                                    </script>
                                ';
                                exit();
                            } else {
                                $erro = true;
                            }
                        } else {
                            $erro = true;
                        }
                    } else {
                        $erro = true;
                    }
                }
            } else {
                echo '
                    <script>
                        alert("Erro ao verificar o curso na sua conta! Tente novamente.");
                    </script>
                ';
                $erro = true;
            }
        } else {
            echo '
                <script>
                    alert("Curso inexistente, tente novamente.");
                </script>
            ';
            $erro = true;
        }
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
?>
