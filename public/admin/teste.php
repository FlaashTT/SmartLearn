<?php
// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega os valores do POST
    $idEditar = $_POST['idEditar'] ?? '';
    $novoNome = $_POST['NovoNomeAdmin'] ?? '';
    $novoEmail = $_POST['NovoEmailAdmin'] ?? '';
    $novoCargo = $_POST['novoCargoAdmin'] ?? '';

    // Exibe os dados recebidos
    echo "<h2>Dados Recebidos:</h2>";
    echo "<strong>ID do Utilizador:</strong> " . htmlspecialchars($idEditar) . "<br>";
    echo "<strong>Nome:</strong> " . htmlspecialchars($novoNome) . "<br>";
    echo "<strong>Email:</strong> " . htmlspecialchars($novoEmail) . "<br>";
    echo "<strong>Cargo:</strong> " . htmlspecialchars($novoCargo) . "<br>";
} else {
    echo "Nenhum dado foi enviado.";
}
?>
