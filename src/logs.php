<?php

function criarLogs($tipoLog , $idUser){//devemos por mais campos,ter de ver depois oq vai ser necesario
 

    date_default_timezone_set("Europe/Lisbon");
    $DataLog = date("Y-m-d H:i:s");
   

    switch ($tipoLog){
        
    case "Novo Registo":
        $descricaoLog = "Foi criado um novo utilizador no sistema"; 
        echo$descricaoLog;
    break;

    }


    //$sql = "INSERT into logs_sistema (id_User, Descricao_log, Tipo_Log, Data_Log) VALUES ($idUser, $descricaoLog, $tipoLog, $DataLog) ";
}


?>