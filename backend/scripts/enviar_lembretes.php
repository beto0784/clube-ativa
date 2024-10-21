<?php
require_once '../models/Agendamento.php';
require_once '../utils/EmailSender.php';

$agendamentoModel = new Agendamento();
$emailSender = new EmailSender();

$agendamentosAmanha = $agendamentoModel->buscarAgendamentosParaAmanha();

foreach ($agendamentosAmanha as $agendamento) {
    $emailSender->enviarLembreteAgendamento(
        $agendamento['email'],
        $agendamento['nome'],
        $agendamento['data'],
        $agendamento['horario'],
        $agendamento['quadra']
    );
}

echo "Lembretes enviados com sucesso!";
