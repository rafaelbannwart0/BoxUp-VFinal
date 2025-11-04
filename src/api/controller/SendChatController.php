<?php
session_start();
include_once("../data.trait.php");

$service = new Service();

$user_id = $_SESSION["user"]["id"];
$mudanca_id = intval($_POST['mudanca_id']);
$mensagem = trim($_POST['mensagem']);

$mudanca = $service->BuscarMudancaPorId($mudanca_id);
$receptor_id = ($mudanca['id_usuario'] == $user_id) 
    ? $mudanca['id_motorista'] 
    : $mudanca['id_usuario'];

$service->SalvarMensagem($mudanca_id, $user_id, $receptor_id, $mensagem);

echo json_encode(["success" => true]);
