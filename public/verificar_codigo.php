<?php
require_once '../config.php';
require_once '../src/Usuario.php';

$data = json_decode(file_get_contents('php://input'), true);
$cpf = $data['cpf'];
$codigo = $data['codigo'];

$usuario = Usuario::verificarCodigo($cpf, $codigo);
if ($usuario) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Código de verificação inválido.']);
}
?>
