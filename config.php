<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Configuração do fuso horário (opcional, mas recomendado)
date_default_timezone_set('America/Sao_Paulo');
?>
