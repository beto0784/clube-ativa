<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../controllers/RelatorioController.php';

$controller = new RelatorioController();
$dados = $controller->agendamentosPorDia();

echo json_encode($dados);
