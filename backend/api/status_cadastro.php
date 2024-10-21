<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/SocioController.php';

$controller = new SocioController();

if(isset($_GET['id'])) {
    $status = $controller->obterStatusCadastro($_GET['id']);
    
    if($status) {
        http_response_code(200);
        echo json_encode(array("status" => $status));
    } else {
        http_response_code(404);
        echo json_encode(array("mensagem" => "Sócio não encontrado."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("mensagem" => "ID do sócio não fornecido."));
}
