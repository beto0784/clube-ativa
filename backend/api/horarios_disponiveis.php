<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/AgendamentoController.php';

$controller = new AgendamentoController();

if(isset($_GET['data'])) {
    $horarios = $controller->buscarHorariosDisponiveis($_GET['data']);
    
    if($horarios) {
        http_response_code(200);
        echo json_encode($horarios);
    } else {
        http_response_code(404);
        echo json_encode(array("mensagem" => "Nenhum horário disponível para esta data."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("mensagem" => "Data não fornecida."));
}
