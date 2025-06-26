<?php
include("../../database/basedados.php");
require_once("../popup.php");
require_once("../logs.php");
$textoErro="";
$erro = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (empty($_POST["idFav"]) ) {
        $erro = true;
        $textoErro = "Erro na coleta do Id";
    }else{
        $idFavorito =  $_POST['idFav'];

        $stmt = $conn->prepare("DELETE FROM cursos_favoritos WHERE Id_curso = ?");
        $stmt->bind_param("i", $idFavorito);
        $result = $stmt->get_result();

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            mostrarPopUp("Cusdo removido de favorito com sucesso!",null,"perfil_favoritos.php");
            
        }else{
            $erro = true;
            $textoErro ="Erro ao remover o curso da lista de favoritos";
        }
    }

    
}else{
    echo "
    <script>
        window.history.back();
    </script>
    ";
}

if($erro){
    criarLogs("Erro",$_SESSION['utilizadorOn']['Id_user'],null,$idFavorito,null,$textoErro,__FILE__);
    mostrarPopUp($textoErro);
    exit();
}

?>