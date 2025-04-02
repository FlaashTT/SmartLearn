<?php
session_start();

unset($_SESSION['utilizadorOn']);
echo"<script>alert('Sessão terminada,volte sempre!') 
window.location.href = '../public/inicio.php';
</script>";

session_destroy();

?>