<?php
function criarLogs($tipoLog, $idUser = null, $saldo = null, $idCurso = null, $idCategoria = null,$tipoErro = null,$ficheiro = null)
{ //devemos por mais campos,ter de ver depois oq vai ser necesario

    global $conn;

    date_default_timezone_set("Europe/Lisbon");
    $DataAtual = date("Y-m-d H:i:s");


    switch ($tipoLog) {

        case "Novo Registo":
            $descricaoLog = "Foi criado um novo utilizador no sistema!";
            break;

        case "Levantamento de saldo":
            $descricaoLog = "Foi levantado saldo no valor de " . $saldo . " € euros";
            break;

        case "Deposito de saldo":
            $descricaoLog = "Foi depositado na conta o valor de " . $saldo . "€ euros";

            break;


        case "Reembolso curso":
            $descricaoLog = "Foi solicitado reembolso do curso com id" . $idCurso;
            break;

        case "Compra curso":
            $descricaoLog = "O utilizador realizou uma compra no valor de " . $saldo . " €";
            break;

        case "Alteração de dados":
            $descricaoLog = "Foram alterados dados de conta deste utilizador";
            break;

        case "Conta eliminada":
            $descricaoLog = "A conta deste utilizador foi eliminada";
            break;

        case "Novo curso":
            $descricaoLog = "Foi adicionado um novo curso";
            break;

        case "Alteração de curso":
            $descricaoLog = "Foram alteradas informações do curso com id" . $idCurso;
            break;

        case "Nova categoria":
            $descricaoLog = "Foi criada uma nova categoria" . $idCategoria;
            break;

        case "Categoria alterada":
            $descricaoLog = "A categoria " . $idCategoria . " foi alterada";
            break;
        case "Utilizador Matriculado":
            $descricaoLog = "O utilizador com id " . $idUser . " foi matriculado no de id $idCurso pelo admin com id " . $_SESSION['utilizadorOn']['Id_user'];
            break;
        case "Conteudo curso alterado":
            $descricaoLog = "O administrador com id " . $idUser . " alterou o conteúdo do curso " . $idCurso;
            break;
        case "Erro":
            $descricaoLog = "Ocorreu um erro: ".$tipoErro ." no ficheiro :".$ficheiro;
            break;  
    }
    $stmt = $conn->prepare("INSERT INTO logs_sistema (Id_user, Descricao_log, Tipo_log, Data_log, saldo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $idUser, $descricaoLog, $tipoLog, $DataAtual, $saldo);


    if (!$stmt->execute()) {
        echo "<script>alert('Erro ao criar log')</script>";
    }

    $stmt->close();
    $conn->close();
}
