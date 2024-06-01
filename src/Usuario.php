<?php
require_once '../config.php';

class Usuario
{
    public static function obterUsuarioPorCpf($cpf)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT id, nome, cpf, email, codigo_verificacao, voto_registrado, ultima_atualizacao FROM usuarios WHERE cpf = ?");
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $stmt->bind_result($id, $nome, $cpf, $email, $codigo_verificacao, $voto_registrado, $ultima_atualizacao);
        $stmt->fetch();
        $stmt->close();

        if ($id) {
            return [
                'id' => $id,
                'nome' => $nome,
                'cpf' => $cpf,
                'email' => $email,
                'codigo_verificacao' => $codigo_verificacao,
                'voto_registrado' => $voto_registrado,
                'ultima_atualizacao' => $ultima_atualizacao,
            ];
        } else {
            return null;
        }
    }

public static function obterUsuarios()
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, nome, cpf, email, codigo_verificacao, voto_registrado FROM usuarios");
    $stmt->execute();
    $stmt->bind_result($id, $nome, $cpf, $email, $codigo_verificacao, $voto_registrado);
    
    $usuarios = [];
    while ($stmt->fetch()) {
        $usuarios[] = [
            'id' => $id,
            'nome' => $nome,
            'cpf' => $cpf,
            'email' => $email,
            'codigo_verificacao' => $codigo_verificacao,
            'voto_registrado' => $voto_registrado,
        ];
    }

    $stmt->close();
    return $usuarios;
}


    public static function salvarCodigoVerificacao($cpf, $codigo, $ultima_atualizacao)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE usuarios SET codigo_verificacao = ?, ultima_atualizacao = ? WHERE cpf = ?");
        $stmt->bind_param("sss", $codigo, $ultima_atualizacao, $cpf);
        $stmt->execute();
        $stmt->close();
    }

    public static function zerarVoto($cpf)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE usuarios SET voto_registrado = '' WHERE cpf = ?");
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $stmt->close();
    }

    public static function verificarCodigo($cpf, $codigo)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT id, nome, cpf, email, codigo_verificacao, voto_registrado FROM usuarios WHERE cpf = ? AND codigo_verificacao = ?");
        $stmt->bind_param("ss", $cpf, $codigo);
        $stmt->execute();
        $stmt->bind_result($id, $nome, $cpf, $email, $codigo_verificacao, $voto_registrado);
        $stmt->fetch();
        $stmt->close();

        if ($id) {
            return [
                'id' => $id,
                'nome' => $nome,
                'cpf' => $cpf,
                'email' => $email,
                'codigo_verificacao' => $codigo_verificacao,
                'voto_registrado' => $voto_registrado,
            ];
        } else {
            return null;
        }
    }

    public static function registrarVoto($cpf, $voto, $ultima_atualizacao, $ip)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE usuarios SET voto_registrado = ?, ultima_atualizacao = ?, ip = ? WHERE cpf = ?");
        $stmt->bind_param("ssss", $voto, $ultima_atualizacao, $ip, $cpf);
        $stmt->execute();
        $stmt->close();
    }
}
