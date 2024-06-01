<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, cpf, email) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $nome, $cpf, $email);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Não foi possível cadastrar o usuário.']);
    }

    $stmt->close();
}
?>
