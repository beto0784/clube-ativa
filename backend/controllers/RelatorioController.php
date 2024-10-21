<?php
require_once '../models/Relatorio.php';

class RelatorioController {
    private $relatorioModel;

    public function __construct() {
        $this->relatorioModel = new Relatorio();
    }

    public function agendamentosPorQuadra() {
        return $this->relatorioModel->buscarAgendamentosPorQuadra();
    }

    public function agendamentosPorDia() {
        return $this->relatorioModel->buscarAgendamentosPorDia();
    }

    public function sociosMaisAtivos() {
        return $this->relatorioModel->buscarSociosMaisAtivos();
    }
}
