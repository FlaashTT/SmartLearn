< ? php 
$database = 'smartlearndb';

$dbhost = 'localhost';

$dbuser = 'root';

$dbpass = '';

mysqli_report (MYSQLI_REPORT_OFF);

$conn = mysqli_connect ( $dbhost, $dbuser, $dbpass, $database );

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
            // Serve para:
            // /SmartLearn/public/admin
            // /SmartLearn/public/autenticacao
            // /SmartLearn/public/carrinho
            // /SmartLearn/public/curso
            // /SmartLearn/public/perfil
            header("Location: ../paginaErro.php");
            break;
    }

    exit();
} 

? >