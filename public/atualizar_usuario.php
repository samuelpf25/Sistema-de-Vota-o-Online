<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, cpf = ?, email = ? WHERE id = ?");
    $stmt->bind_param('sssi', $nome, $cpf, $email, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Não foi possível atualizar o usuário.']);
    }

    $stmt->close();
}
?>
