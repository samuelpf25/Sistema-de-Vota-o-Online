<?php
$servername = "localhost";
$username = "u892138677_asfito_vota";
$password = "Sa747400";
$dbname = "u892138677_asfito_vota";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Configuração do fuso horário (opcional, mas recomendado)
date_default_timezone_set('America/Sao_Paulo');
?>