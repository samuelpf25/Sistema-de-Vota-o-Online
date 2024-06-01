<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class Email
{
    private $email_origem = "naoresponda@samsites.com.br";//"atendimento@asfito.com.br";
    private $senha = "#Sa747400";//'Fisio050620';
    private $host = 'smtp.hostinger.com';
    
    public function Variaveis($mail)
    {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host = $this->host; //'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = $this->email_origem;
        $mail->Password = $this->senha;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    }

    public static function enviarCodigoVerificacao($email, $codigo)
    {
        $mail = new PHPMailer(true);
        try {
            $emailClass = new self();
            $emailClass->Variaveis($mail);
            
            // Remetente e destinatário
            $mail->setFrom($emailClass->email_origem, 'ASFITO-ELEIÇÃO');
            $mail->addAddress($email);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Seu código de verificação';
            $mail->Body    = "Seu código de verificação é: <b>$codigo</b>";
            $mail->CharSet = 'UTF-8';
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function enviarComprovanteVotacao($email, $nome, $voto_registrado, $codigo_verificacao, $data_hora, $ip)
    {
        $mail = new PHPMailer(true);
        try {
            $emailClass = new self();
            $emailClass->Variaveis($mail);
            
            // Remetente e destinatário
            $mail->setFrom($emailClass->email_origem, 'ASFITO-ELEIÇÃO');
            $mail->addAddress($email);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Comprovante de Votação - ASFITO [ELEIÇÕES 2024]';
            $mail->Body    = "Olá " . $nome . ", você registrou o seguinte voto: <strong>" . $voto_registrado . "</strong>.<br>O código autorização do registro desse voto foi o " . $codigo_verificacao . " enviado no seu e-mail.<br>O voto foi registrado em " . $data_hora . ".<br>O IP de acesso foi ".$ip.".";
            $mail->CharSet = 'UTF-8';
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    
}
