<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/GestorController.php';

$controller = new GestorController();
$socios = $controller->listarSociosPendentes();

if($socios) {
    http_response_code(200);
    echo json_encode($socios);
} else {
    http_response_code(404);
    echo json_encode(array("mensagem" => "Nenhum sócio pendente encontrado."));
}
