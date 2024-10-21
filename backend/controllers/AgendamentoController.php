<?php
require_once '../models/Agendamento.php';
require_once '../utils/EmailSender.php';

class AgendamentoController {
    private $agendamentoModel;
    private $emailSender;

    public function __construct() {
        $this->agendamentoModel = new Agendamento();
        $this->emailSender = new EmailSender();
    }

    public function listarAgendamentosPorSocio($socioId) {
        return $this->agendamentoModel->buscarPorSocio($socioId);
    }

    public function buscarHorariosDisponiveis($data) {
        return $this->agendamentoModel->horariosDisponiveis($data);
    }

    public function fazerAgendamento($socioId, $data, $horario, $quadraId) {
        if($this->agendamentoModel->contarAgendamentosSemana($socioId, $data) >= 2) {
            return ['sucesso' => false, 'mensagem' => 'Limite de agendamentos semanais atingido.'];
        }

        $agendamentoId = $this->agendamentoModel->criar($socioId, $data, $horario, $quadraId);
        if($agendamentoId) {
            $socio = $this->agendamentoModel->buscarSocio($socioId);
            $quadra = $this->agendamentoModel->buscarQuadra($quadraId);
            
            $this->emailSender->enviarConfirmacaoAgendamento(
                $socio['email'],
                $socio['nome'],
                $data,
                $horario,
                $quadra['nome']
            );
            
            return ['sucesso' => true, 'mensagem' => 'Agendamento realizado com sucesso.'];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Erro ao realizar agendamento.'];
        }
    }
}
