<?php
include("../../database/basedados.sql");
$erro = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (empty($_POST["idFav"]) ) {
        $erro = true;
    }else{
        $idFavorito =  $_POST['idFav'];

        $stmt = $conn->prepare("DELETE FROM cursos_favoritos WHERE Id_curso = ?");
        $stmt->bind_param("i", $idFavorito);
        $result = $stmt->get_result();

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            echo'
            <script>
                alert("Curso removido com sucesso!");
                window.location.href = document.referrer;
            </script>
            ';
        }else{
            $erro = true;
        }
    }

    
}else{
    $erro = true;
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

?>