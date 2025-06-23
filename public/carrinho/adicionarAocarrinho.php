<?php
include('../segurança.php');
include('../../database/basedados.php');
include("../popup.php");
include("../logs.php");

$erro = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idCurso = $_POST['IdCurso'];
    if (empty($idCurso)) {
        $erro = true;
    } else {
        $idUser = $_SESSION['utilizadorOn']['Id_user'];

        // Verificar se já foi adquirido
        $stmt = $conn->prepare("SELECT * FROM cursos_adquiridos WHERE Id_user = ? AND Id_curso = ?");
        $stmt->bind_param("ii", $idUser, $idCurso);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            mostrarPopUp("Já tem este curso adquirido no seu perfil",NULL,"../categorias.php");
            
            exit;
        }

        // Verificar se já está no carrinho
        $stmt = $conn->prepare("SELECT * FROM carrinho_compras WHERE Id_user = ? AND Id_curso = ?");
        $stmt->bind_param("ii", $idUser, $idCurso);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            mostrarPopUp("Já tem este curso adicionado ao seu carrinho",NULL,"../categorias.php");
            
            exit;
        }

        // Adicionar ao carrinho
        $stmt = $conn->prepare("INSERT INTO carrinho_compras (Id_user, Id_curso) VALUES (?, ?)");
        $stmt->bind_param("ii", $idUser, $idCurso);

        if ($stmt->execute()) {
            echo "
            <script>
                if(confirm('Adicionado ao carrinho, deseja ir para o carrinho?')) {
                    window.location.href = 'carrinho.php';
                } else {
                    window.location.href = '../categorias.php';
                }
            </script>
            ";
            exit;
        } else {
            $erro = true;
        }
    }
} else {
    $erro = true;
}

if ($erro) {
    criarLogs("Erro",$_SESSION['utilizadorOn']['Id_user'],null,$idCurso,null,"Ocorreu um erro ao adicionar o curso no carrinho",__FILE__);
    mostrarPopUp("Ocorreu um erro, tente mais tarde",NULL,"../categorias.php");
    
    exit;
}
?>
