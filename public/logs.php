<?php
function criarLogs($tipoLog, $idUser = null, $saldo = null, $idCurso = null, $idCategoria = null, $tipoErro = null, $ficheiro = null, $idUserAlterado = null)
{ //devemos por mais campos,ter de ver depois oq vai ser necesario

    global $conn;

    date_default_timezone_set("Europe/Lisbon");
    $DataAtual = date("Y-m-d H:i:s");


    switch ($tipoLog) {

        //funçoes de categoria
        case "Nova categoria":
            $descricaoLog = "Foi criada uma nova categoria" . $idCategoria . "pelo administador com id: " . $idUser;
            break;

        case "Categoria alterada":
            $descricaoLog = "A categoria " . $idCategoria . " foi alterada";
            break;
        case "Categoria eliminada":
            $descricaoLog = "O administrador com Id:" . $idUser . "eliminou uma categoria";
            break;

        //funçoes de utilizadores
        case "Novo Registo":
            $descricaoLog = "Foi criado um novo utilizador no sistema!";
            break;

        case "Levantamento de saldo":
            $descricaoLog = "Foi levantado saldo no valor de " . $saldo . " € euros";
            break;

        case "Deposito de saldo":
            $descricaoLog = "Foi depositado na conta o valor de " . $saldo . "€ euros";

            break;
        case "Alteração de dados":
            $descricaoLog = "Foram alterados dados de conta deste utilizador";
            break;
        case "Conta eliminada":
            $descricaoLog = "A conta deste utilizador com Id:".$idUserAlterado." foi eliminada pelo administrador com Id:".$idUser;
            break;
        case "Utilizador Matriculado":
            $descricaoLog = "O utilizador com id " . $idUserAlterado . " foi matriculado no curso de id $idCurso pelo admin com id " . $idUser;
            break;
        case "Utilizador Alterado por admin":
            $descricaoLog = "Foi alterado dados do utilizador com Id: " . $idUserAlterado . " pelo administrador com ID:" . $idUser;
            break;


        //funçoes de curso
        case "Reembolso curso":
            $descricaoLog = "Foi solicitado reembolso do curso com id" . $idCurso;
            break;

        case "Compra curso":
            $descricaoLog = "O utilizador realizou uma compra no valor de " . $saldo . " €";
            break;

        case "Novo curso":
            $descricaoLog = "Foi adicionado um novo curso(" . $idCurso . ") pelo administrador com ID: " . $idUser;
            break;

        case "Alteração de curso":
            $descricaoLog = "Foram alteradas informações do curso com id" . $idCurso;
            break;

        case "Conteudo curso alterado":
            $descricaoLog = "O administrador com id " . $idUser . " alterou o conteúdo do curso " . $idCurso;
            break;




        //funçao de erro
        case "Erro":
            $descricaoLog = "Ocorreu um erro: " . $tipoErro . " no ficheiro :" . $ficheiro;
            break;

        //fuçao de configuração de site
        case "Configurações alteradas":
            $descricaoLog = "O utilizador com Id:" . $idUser . " alterou as configuraçoes do site";
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
