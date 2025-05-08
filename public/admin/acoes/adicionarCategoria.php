<?php
include('../segurança.php');
include('../../database/basedados.sql');

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome_categoria']) &&
    ) {
        //se tiver todos os dados para criar uma nova categoria
    }else{
        $erro = true;
    }
} else {
    $erro = true;
}

if ($erro) {
    echo "
    <script>
        alert('Ocorreu um erro, tente mais tarde');
        window.location.href = '../categoria_cursos.php';
    </script>
    ";
    exit;
}
