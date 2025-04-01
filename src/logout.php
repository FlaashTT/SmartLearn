<?php
session_start();

unset($_SESSION['utilizadorOn']);
echo"<script>alert('Sessão terminada,volte sempre!') </script>";
header("Location: inicio.php");

session_destroy();

?>