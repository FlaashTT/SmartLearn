<?php
// Descomente as duas linhas abaixo para depuração (opcional)
file_put_contents("debug_server.txt", print_r($_SERVER, true));
 file_put_contents("debug_post.txt", print_r($_POST, true));

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Captura os dados do formulário
    $timestamp       = $_POST["timestamp"]       ?? "";
    $email           = $_POST["email"]           ?? "";
    $perfil          = $_POST["perfil"]          ?? "";
    $frequencia      = $_POST["frequencia"]      ?? "";
    $experiencia     = $_POST["experiencia"]     ?? "";
    $funcionalidades = $_POST["funcionalidades"] ?? "";
    $comentarios     = $_POST["comentarios"]     ?? "";
    $maisGostou      = $_POST["maisGostou"]      ?? "";
    $mudaria         = $_POST["mudaria"]         ?? "";

    // Junta tudo num texto
    $texto = "Data/Hora: $timestamp\nEmail: $email\nPerfil: $perfil\nFrequência: $frequencia\nExperiência: $experiencia\nFuncionalidades: $funcionalidades\nComentários: $comentarios\nMais Gostou: $maisGostou\nMudaria: $mudaria\n\n----------------------\n";

    // Caminho do arquivo (fora da pasta pública)
    $arquivo = __DIR__ . "/respostas.txt";

    // Salva os dados no arquivo
    file_put_contents($arquivo, $texto, FILE_APPEND);

    // Retorno para o Apps Script
    echo "Resposta salva com sucesso!";
} else {
    echo "Método inválido.";
}
