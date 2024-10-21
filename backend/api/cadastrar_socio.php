<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../controllers/SocioController.php';

$controller = new SocioController();

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->nome) &&
    !empty($data->endereco) &&
    !empty($data->email) &&
    !empty($data->telefone) &&
    !empty($data->matricula)
) {
    $resultado = $controller->cadastrar((array)$data);
    
    http_response_code(200);
    echo json_encode($resultado);
} else {
    http_response_code(400);
    echo json_encode(array("mensagem" => "Dados incompletos. Não foi possível realizar o cadastro."));
}
