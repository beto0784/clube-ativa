<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class EmailSender {
    private $mailer;

    public function __construct() {
        $config = require_once '../config/email.php';
        
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = $config['host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $config['username'];
        $this->mailer->Password = $config['password'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = $config['port'];
        $this->mailer->setFrom($config['from_email'], $config['from_name']);
    }

    public function enviarConfirmacaoAgendamento($email, $nome, $data, $horario, $quadra) {
        $this->mailer->addAddress($email, $nome);
        $this->mailer->Subject = 'Confirmação de Agendamento - Clube Ativa';
        $this->mailer->Body = "Olá {$nome},\n\nSeu agendamento foi confirmado para o dia {$data} às {$horario} na quadra {$quadra}.\n\nAtenciosamente,\nClube Ativa";

        return $this->mailer->send();
    }

    public function enviarLembreteAgendamento($email, $nome, $data, $horario, $quadra) {
        $this->mailer->addAddress($email, $nome);
        $this->mailer->Subject = 'Lembrete de Agendamento - Clube Ativa';
        $this->mailer->Body = "Olá {$nome},\n\nLembramos que você tem um agendamento para amanhã, dia {$data} às {$horario} na quadra {$quadra}.\n\nAtenciosamente,\nClube Ativa";

        return $this->mailer->send();
    }
}
