<?php
session_start();
include('../public/segurança.php');
include('../database/basedados.sql');
$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idCurso = $_POST['IdCurso'];
    if (empty($idCurso)) {
        $erro = true;
    } else {
        echo ($_SESSION['utilizadorOn']['Id_user']);

        $stmt = $conn->prepare("SELECT * FROM cursos_adquiridos WHERE Id_user = ? AND Id_curso = ?");
        $stmt->bind_param("ii", $_SESSION['utilizadorOn']['Id_user'], $idCurso);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "
            <script>
                alert('Ja tem este curso adquirido no seu perfil');
                window.history.back();
            </script>
            ";
        } else {

            $stmt = $conn->prepare("SELECT * FROM carrinho_compras WHERE Id_user = ? AND Id_curso = ?");
            $stmt->bind_param("ii", $_SESSION['utilizadorOn']['Id_user'], $idCurso);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "
            <script>
                alert('Ja tem este curso adicionado ao seu carrinho');
                window.history.back();
            </script>
            ";
            } else {

                $stmt = $conn->prepare("INSERT INTO carrinho_compras (Id_user, Id_curso) VALUES  (?, ?)");
                $stmt->bind_param("ii", $_SESSION['utilizadorOn']['Id_user'], $idCurso);

                if ($stmt->execute()) {
                    echo "
                <script>
                if(confirm('Adicionado ao carrinho, deseja ir para o carrinho?')){
                window.location.href ='../public/carrinho.php';
        }else{

                window.history.back();
        }
                </script>
            ";
                }
            }
        }
    }
} else {
    $erro = true;
}

if ($erro) {
    echo "
    <script>
    alert('Ocorreu um erro ,tente mais tarde');
    window.history.back();
    </script>
    ";
    exit;
}

?>