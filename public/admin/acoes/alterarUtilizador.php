<?php
include("../../../database/basedados.php");

include("../../popup.php");

$efetuadaTroca = false;
$erro = false;
$textoErro = '';
// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega os valores do POST
    $idEditar = $_POST['idEditar'] ?? '';
    $novoNome = $_POST['NovoNome'] ?? '';
    $novoEmail = $_POST['NovoEmail'] ?? '';
    $novoCargo = $_POST['novoCargo'] ?? '';
    $verificacaoTrocaDono = isset($_POST['checkboxConfirmacao']) && $_POST['checkboxConfirmacao'] === 'on';





    //fazer select da tabela user atravez do id
    $query = "SELECT * from user WHERE Id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idEditar);


    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();


        if ($novoNome != '' && $novoNome !== $row['PNome_user'] . ' ' . $row['SNome_user']) {
            // Verifica se há pelo menos um espaço
            if (strpos($novoNome, ' ') !== false) {
                // Divide o nome em partes
                $partes = explode(' ', $novoNome, 2); // divide apenas em 2 partes
                $NovoPNome = $partes[0];
                $NovoSNome = $partes[1];
            } else {
                // Se não houver espaço, tudo é considerado como primeiro nome
                $NovoPNome = $novoNome;
                $NovoSNome = '';
            }


            // Atualiza o nome
            $updateNome = "UPDATE user SET PNome_user = ?, SNome_user = ? WHERE Id_user = ?";
            $stmtNome = $conn->prepare($updateNome);
            $stmtNome->bind_param("ssi", $NovoPNome, $NovoSNome, $idEditar);
            if (!$stmtNome->execute()) {
                $erro = true;
                $textoErro = "Erro ao atualizar o nome: " . $stmtNome->error;
            } else {
                $efetuadaTroca = true;
            }
        }


        if ($novoEmail != '' && $novoEmail !== $row['Email']) {
            // Verifica se o e-mail é válido
            if (!filter_var($novoEmail, FILTER_VALIDATE_EMAIL)) {
                $erro = true;
                $textoErro = "O email inserido não é válido.";
            } else {
                // Verifica se o email já existe
                $queryEmail = "SELECT * FROM user WHERE Email = ? AND Id_user != ?";
                $stmtEmail = $conn->prepare($queryEmail);
                $stmtEmail->bind_param("si", $novoEmail, $idEditar);
                $stmtEmail->execute();
                $resultEmail = $stmtEmail->get_result();

                if ($resultEmail->num_rows > 0) {
                    $erro = true;
                    $textoErro = "O email já está em uso.";
                } else {
                    // Atualiza o email
                    $updateEmail = "UPDATE user SET Email = ? WHERE Id_user = ?";
                    $stmtUpdateEmail = $conn->prepare($updateEmail);
                    $stmtUpdateEmail->bind_param("si", $novoEmail, $idEditar);
                    if (!$stmtUpdateEmail->execute()) {
                        $erro = true;
                        $textoErro = "Erro ao atualizar o email: " . $stmtUpdateEmail->error;
                    } else {
                        $efetuadaTroca = true;
                    }
                }
            }
        }



        if ($novoCargo != '' && $novoCargo !== $row['Tipo_user']) {

            if ($novoCargo === "Main-admin" && $row['Tipo_user'] !== "Main-admin" && $verificacaoTrocaDono === true) {

                // Remover Main-admin de todos os outros utilizadores
                $updateCargo = "UPDATE user SET Tipo_user = 'Admin' WHERE Tipo_user = 'Main-admin'";
                $stmtCargo = $conn->prepare($updateCargo);

                if (!$stmtCargo->execute()) {
                    $erro = true;
                    $textoErro = "Erro ao remover Main-Admin de outros utilizadores: " . $stmtCargo->error;
                }
                $stmtCargo->close();

                if (!$erro) {
                    // Atualiza o cargo
                    updateCargo($conn, $novoCargo, $idEditar);
                }
            } else if ($novoCargo === "Main-admin" && $verificacaoTrocaDono !== true) {
                $textoErro = "Para trocar o Main admin tem de confirmar a checkbox";
                $erro = true;
            }



            if ($novoCargo === "Admin" || $novoCargo === "Cliente") {
                // Atualiza o cargo normalmente
                updateCargo($conn, $novoCargo, $idEditar);
            }
        }
    } else {
        $erro = true;
        $textoErro = "Utilizador não encontrado.";
    }
} else {
    $erro = true;
    $textoErro = "Método de requisição inválido.";
}

if (!$erro && $efetuadaTroca) {
    mostrarPopUp("Utilizador atualizado com sucesso!");
} else if ($erro) {
    mostrarPopUp($textoErro);
}

function caminho()
{
    // Redireciona para a página de administração
    echo '
    <script>
    window.location.href = document.referrer;
    </script>
    ';
    exit();
}

function updateCargo($conn, $novoCargo, $idEditar)
{
    global $erro, $efetuadaTroca, $textoErro;

    $updateCargo = "UPDATE user SET Tipo_user = ? WHERE Id_user = ?";
    $stmtCargo = $conn->prepare($updateCargo);
    $stmtCargo->bind_param("si", $novoCargo, $idEditar);

    if (!$stmtCargo->execute()) {
        $erro = true;
        $textoErro = "Erro ao atualizar o cargo: " . $stmtCargo->error;
    } else {
        $efetuadaTroca = true;
    }
    $stmtCargo->close();
}
