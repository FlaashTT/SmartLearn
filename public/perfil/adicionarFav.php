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

    // Supondo que você tenha o Id do usuário na sessão, por exemplo:
    $idUsuario = $_SESSION['utilizadorOn']['Id_user']; // Ajuste conforme seu código

    $stmt = $conn->prepare("INSERT INTO cursos_favoritos (Id_user, Id_curso) VALUES (?, ?)");
    $stmt->bind_param("ii", $idUsuario, $idFavorito);

    if ($stmt->execute()) {
        mostrarPopUp("Curso adicionado aos favoritos com sucesso!", null, "../categorias.php");
        
        
    } else {
        $erro = true;
    }
}


    
}else{
    $erro = true;
}

if($erro){
    mostrarPopUp('Ocorreu um erro inesperado,tente novamente!');
    exit();
}

?>