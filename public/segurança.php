<?php

session_start();

if($_SESSION['utilizadorOn'] == null || !$_SESSION['utilizadorOn']) {
    header('Location:../public/inicio.php');
    exit();
}

?>