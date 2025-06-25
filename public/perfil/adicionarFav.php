<?php
include("../../database/basedados.php");
session_start();
require_once("../popup.php");
$erro = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST["idFav"])) {
        $erro = true;
    } else {
        $idFavorito = $_POST['idFav'];
        $idUsuario = $_SESSION['utilizadorOn']['Id_user']; // Ajuste conforme necessário

        // Verificar se o curso já está nos favoritos
        $verifica = $conn->prepare("SELECT 1 FROM cursos_favoritos WHERE Id_user = ? AND Id_curso = ?");
        $verifica->bind_param("ii", $idUsuario, $idFavorito);
        $verifica->execute();
        $verifica->store_result();

        if ($verifica->num_rows > 0) {
            // Já existe, mostrar popup informativo
            mostrarPopUp("Este curso já está nos seus favoritos!", null, "../categorias.php");
        } else {
            // Inserir o curso nos favoritos
            $stmt = $conn->prepare("INSERT INTO cursos_favoritos (Id_user, Id_curso) VALUES (?, ?)");
            $stmt->bind_param("ii", $idUsuario, $idFavorito);

            if ($stmt->execute()) {
                mostrarPopUp("Curso adicionado aos favoritos com sucesso!", null, "../categorias.php");
            } else {
                $erro = true;
            }
        }

        $verifica->close();
    }
} else {
    $erro = true;
}

if ($erro) {
    mostrarPopUp('Ocorreu um erro inesperado,tente novamente!');
    exit();
}
