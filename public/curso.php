<?php
include('segurança.php');
include('../database/basedados.sql');

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idCurso = $_POST['idCurso'];
    if(empty($idCurso)){
        $erro = true;
    }

    echo$idCurso;



} else {
    echo "
    <script>
        alert('Erro de ligação, pedimos desculpa!');
        window.history.back();
    </script>
    ";
    exit();
}


if($erro){
    echo "
    <script>
        alert('Ocorreu um erro inesperado,tente novamente!');
        window.history.back();
    </script>
    ";
    exit();
}
