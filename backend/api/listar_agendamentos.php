<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/AgendamentoController.php';

$controller = new AgendamentoController();

if(isset($_GET['socio_id'])) {
    $agendamentos = $controller->listarAgendamentosPorSocio($_GET['socio_id']);
    
    if($agendamentos) {
        http_response_code(200);
        echo json_encode($agendamentos);
    } else {
        http_response_code(404);
        echo json_encode(array("mensagem" => "Nenhum agendamento encontrado."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("mensagem" => "ID do sócio não fornecido."));
}
