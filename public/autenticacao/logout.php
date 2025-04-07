<?php
session_start();

unset($_SESSION['utilizadorOn']);
echo"<script>alert('Sessão terminada,volte sempre!') 
window.location.href = '../inicio.php';
</script>";

session_destroy();

?>