<?php
require_once '../config.php';
require_once '../src/Usuario.php';


$usuarios = Usuario::obterUsuarios();

echo json_encode(['usuarios' => $usuarios]);

?>

