<?php

$efetuadaTroca = false;
$erro = false;
$textoErro = '';
// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega os valores do POST
    $idEditar = $_POST['idEditar'] ?? '';

}
echo "<h1>$idEditar </h1>";
?>