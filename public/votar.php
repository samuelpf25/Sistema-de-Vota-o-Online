<?php
require_once '../config.php';
require_once '../src/Usuario.php';
require_once '../src/Email.php';

$data = json_decode(file_get_contents('php://input'), true);
$cpf = $data['cpf'];
$voto = $data['voto'];
$ip = $data['ip'] ?? 'vazio';

$usuario = Usuario::obterUsuarioPorCpf($cpf);
if ($usuario && !$usuario['voto_registrado']) {
    date_default_timezone_set('America/Sao_Paulo');
    $ultima_atualizacao = date('Y-m-d H:i:s'); //$_POST['momento_registro'];
    Usuario::registrarVoto($cpf, $voto, $ultima_atualizacao, $ip);

    $usuario = Usuario::obterUsuarioPorCpf($cpf);
    if (Email::enviarComprovanteVotacao($usuario['email'], $usuario['nome'], $usuario['voto_registrado'], $usuario['codigo_verificacao'], $usuario['ultima_atualizacao'], $ip)) {
        echo json_encode(['success' => true, 'nome' => $usuario['nome']]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao registrar voto.']);
}
