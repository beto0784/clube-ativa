<?php
require_once '../models/Socio.php';

class GestorController {
    private $socioModel;

    public function __construct() {
        $this->socioModel = new Socio();
    }

    public function listarSociosPendentes() {
        return $this->socioModel->buscarPorStatus('pendente');
    }

    public function atualizarStatusSocio($id, $status) {
        if($this->socioModel->atualizarStatus($id, $status)) {
            return ['sucesso' => true, 'mensagem' => 'Status do sócio atualizado com sucesso.'];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar status do sócio.'];
        }
    }
}
