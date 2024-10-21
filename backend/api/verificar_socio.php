<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/PorteiroController.php';

$controller = new PorteiroController();

if(isset($_GET['busca'])) {
    $resultado = $controller->verificarSocio($_GET['busca']);
    
    http_response_code(200);
    echo json_encode($resultado);
} else {
    http_response_code(400);
    echo json_encode(array("mensagem" => "Termo de busca não fornecido."));
}
