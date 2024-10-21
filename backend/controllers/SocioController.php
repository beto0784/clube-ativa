<?php
require_once '../models/Socio.php';

class SocioController {
    public function cadastrar($dados) {
        $socio = new Socio();
        $socio->nome = $dados['nome'];
        $socio->endereco = $dados['endereco'];
        $socio->email = $dados['email'];
        $socio->telefone = $dados['telefone'];
        $socio->matricula = $dados['matricula'];
        $socio->status = 'pendente';

        if ($socio->salvar()) {
            return ['sucesso' => true, 'mensagem' => 'Cadastro realizado com sucesso. Aguarde aprovação.'];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Erro ao realizar cadastro.'];
        }
    }

    public function obterStatusCadastro($id) {
        return $this->socioModel->buscarStatus($id);
    }
}
