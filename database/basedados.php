<?php 
$database = 'smartlearndb';
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';

// Comando para não mostrar erros do slq
mysqli_report(MYSQLI_REPORT_OFF);


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $database);

if (!$conn) {
    $dir = rtrim(dirname($_SERVER['PHP_SELF']), '/');

    switch ($dir) {
        case '/SmartLearn/public':
            header("Location: paginaErro.php");
            break;

        case '/SmartLearn/public/admin/acoes':
            header("Location: ../../paginaErro.php");
            break;

        default:
            header("Location: ../paginaErro.php");
            break;
    }

    exit();
}
?>
