<?php
include("../../database/basedados.sql");
session_start();
//evita que utilizador nao registados entrem nas paginas que necessitam login
if ($_SESSION['utilizadorOn'] == null || !$_SESSION['utilizadorOn']) {
    header('Location:../inicio.php');
    exit();
} else {
    //para estar sempre a atualizar a session
    $stmt = $conn->prepare("SELECT * FROM user WHERE Id_user = ?");
    $stmt->bind_param("i", $_SESSION['utilizadorOn']['Id_user']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['utilizadorOn'] = $user;
    }
}
?>
