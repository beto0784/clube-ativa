<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/PorteiroController.php';

$controller = new PorteiroController();

$agendamentos = $controller->listarAgendamentosDoDia();

if($agendamentos) {
    http_response_code(200);
    echo json_encode($agendamentos);
} else {
    http_response_code(404);
    echo json_encode(array("mensagem" => "Nenhum agendamento encontrado para hoje."));
}
