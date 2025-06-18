<?php
header('Content-Type: application/json'); // Garante resposta como JSON

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $classificacao = $data['classificacao'];
    $idCurso = $data['idCurso'];
    $idUser = $data['idUser'];

    include '../../database/basedados.php';

    // Atualiza avaliação do usuário no curso
    $update = $conn->prepare("UPDATE cursos_adquiridos SET Avaliacao = ? WHERE Id_user = ? AND Id_curso = ?");
    $update->bind_param("iii", $classificacao, $idUser, $idCurso);

    if ($update->execute()) {
        // Recalcula a média de avaliações desse curso
        $mediaQuery = $conn->prepare("SELECT AVG(Avaliacao) AS media FROM cursos_adquiridos WHERE Id_curso = ? AND Avaliacao IS NOT NULL");
        $mediaQuery->bind_param("i", $idCurso);
        $mediaQuery->execute();
        $result = $mediaQuery->get_result();
        $media = $result->fetch_assoc()['media'];
        $mediaQuery->close();

        // Atualiza o campo classificacao na tabela curso
        $updateCurso = $conn->prepare("UPDATE curso SET classificacao = ? WHERE Id_curso = ?");
        $updateCurso->bind_param("di", $media, $idCurso);
        $updateCurso->execute();
        $updateCurso->close();

        echo json_encode(['sucesso' => true, 'mediaAtualizada' => round($media, 2)]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => $update->error]);
    }

    $update->close();
    $conn->close();
} else {
    echo json_encode(['sucesso' => false, 'erro' => 'Dados inválidos']);
}
