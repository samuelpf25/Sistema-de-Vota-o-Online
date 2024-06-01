<?php

require_once '../config.php';
require_once '../src/Email.php';
require_once '../src/Usuario.php';

$data = json_decode(file_get_contents('php://input'), true);
$cpf = $data['cpf'];
Usuario::zerarVoto($cpf);

?>

