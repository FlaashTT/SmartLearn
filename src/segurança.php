<?php
session_start();


if($_SESSION['utilizadorOn'] == null) {
    header('Location:../public/index.php');
}

?>