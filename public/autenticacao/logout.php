<?php
include("../popup.php");
session_start();

unset($_SESSION['utilizadorOn']);

mostrarPopUp("Sessão terminada,volte sempre!",null,"../inicio.php");


session_destroy();

?>