<?php
include('../database/basedados.sql');
function criarLogs($tipoLog , $idUser){//devemos por mais campos,ter de ver depois oq vai ser necesario
    global $conn;

    date_default_timezone_set("Europe/Lisbon");
    $DataAtual = date("Y-m-d H:i:s");
   

    switch ($tipoLog){
        
    case "Novo Registo":
        $descricaoLog = "Foi criado um novo utilizador no sistema!"; 
    break;

    }


    $stmt = $conn -> prepare ("INSERT INTO logs_sistema (Id_user, Descricao_log, Tipo_log, Data_log) VALUES  (?, ?, ?, ?)");
    $stmt -> bind_param("ssss", $idUser, $descricaoLog, $tipoLog, $DataAtual);

    
    if(!$stmt -> execute()){
        echo"<script>alert('Erro ao criar log')</script>";
    }

    $stmt->close();
    $conn->close();

}
?>