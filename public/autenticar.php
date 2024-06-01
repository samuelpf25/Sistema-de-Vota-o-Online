<?php
require_once '../config.php';
require_once '../src/Email.php';
require_once '../src/Usuario.php';

$data = json_decode(file_get_contents('php://input'), true);
$cpf = $data['cpf'];
$email = '';

$usuario = Usuario::obterUsuarioPorCpf($cpf);
if ($usuario) {
    if ($usuario['voto_registrado'] != '') {
        echo json_encode(['success' => false, 'message' => 'Voto já registrado.']);
        exit;
    } else {
        $email = $usuario['email'];
    }

    $codigo = rand(100000, 999999);
    date_default_timezone_set('America/Sao_Paulo');
    $ultima_atualizacao = date('Y-m-d H:i:s'); //$_POST['momento_registro'];
    
    Usuario::salvarCodigoVerificacao($cpf, $codigo, $ultima_atualizacao);
    if (Email::enviarCodigoVerificacao($usuario['email'], $codigo)) {
        echo json_encode(['success' => true, 'email' => $email]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Falha ao enviar o código de verificação.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
}
