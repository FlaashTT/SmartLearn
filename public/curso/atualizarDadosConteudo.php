<?php
header('Content-Type: application/json'); // Garante resposta como JSON

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $percentagem = $data['percentagem'];
    $notas = $data['notas']; // Pode ser null
    $idCurso = $data['idCurso'];
    $idUser = $data['idUser'];

    include '../../database/basedados.php';

    // Prepara dinamicamente a query
    if ($notas === null) {
        $update = $conn->prepare("UPDATE cursos_adquiridos SET Percentagem_progresso = ? WHERE Id_user = ? AND Id_curso = ?");
        $update->bind_param("dii", $percentagem, $idUser, $idCurso);
    } else {
        $update = $conn->prepare("UPDATE cursos_adquiridos SET Percentagem_progresso = ?, Notas = ? WHERE Id_user = ? AND Id_curso = ?");
        $update->bind_param("dsii", $percentagem, $notas, $idUser, $idCurso);
    }

    if ($update->execute()) {
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => $update->error]);
    }

    $update->close();
    $conn->close();
} else {
    echo json_encode(['sucesso' => false, 'erro' => 'Dados inválidos']);
}
?>