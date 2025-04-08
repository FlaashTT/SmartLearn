<?php

session_start();

if($_SESSION['utilizadorOn'] == null || !$_SESSION['utilizadorOn']) {
    header('Location:../inicio.php');
    exit();
}

?>