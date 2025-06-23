<?php
include("../database/basedados.php");
include("popup.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    echo "<script> window.history.back()</script>";
} else {
    $sql = "UPDATE user SET Estado_cookies_user = ? WHERE Id_user = ?";
    $stmt = $conn->prepare($sql);


    $estado = "Aceite";
    $idUser = $_SESSION['utilizadorOn']['Id_user'];
    $stmt->bind_param("si", $estado, $_SESSION['utilizadorOn']['Id_user']);

    if ($stmt->execute()) {
        echo "<script> window.history.back()</script>";
    } else {
        mostrarPopUp("Ocorreu um erro,Tente novamente mais tarde!");
    }

    $stmt->close();
}
