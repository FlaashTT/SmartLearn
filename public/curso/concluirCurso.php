<?php
include("../../database/basedados.php");
include("../popup.php");
include("../logs.php");

if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(!isset($_POST['cursoAtual']) && $_POST['cursoAtual'] === null){
        $textoErro ="Erro na coleta do id do curso";
        $erro = true;
        exit;
    }
    //por codigo que faz update na bd para colocar como 100% e concluido o curso
}else{
    echo "<script>window.history.back();</script>";

}
if($erro){
//criar log
//mostrarPopUP
}

?>
