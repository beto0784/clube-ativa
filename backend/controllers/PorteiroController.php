<?php
require_once '../models/Agendamento.php';
require_once '../models/Socio.php';

class PorteiroController {
    private $agendamentoModel;
    private $socioModel;

    public function __construct() {
        $this->agendamentoModel = new Agendamento();
        $this->socioModel = new Socio();
    }

    public function listarAgendamentosDoDia() {
        return $this->agendamentoModel->buscarAgendamentosDoDia();
    }

    public function registrarEntrada($agendamentoId) {
        if($this->agendamentoModel->atualizarStatus($agendamentoId, 'Em uso')) {
            return ['sucesso' => true, 'mensagem' => 'Entrada registrada com sucesso.'];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Erro ao registrar entrada.'];
        }
    }

    public function verificarSocio($busca) {
        $socio = $this->socioModel->buscarPorNomeOuMatricula($busca);
        if($socio) {
            $agendamentoHoje = $this->agendamentoModel->buscarAgendamentoHojePorSocio($socio['id']);
            return [
                'sucesso' => true,
                'socio' => $socio,
                'agendamentoHoje' => $agendamentoHoje
            ];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Sócio não encontrado.'];
        }
    }
}
